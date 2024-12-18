<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Service;

class BinancePay
{
    protected const BASE_URL = 'https://bpay.binanceapi.com';
    protected const BASE_URL_CURRENCY = 'https://www.binance.com';
    protected const BUILD_ORDER_ENDPOINT = '/binancepay/openapi/v3/order';
    protected const GET_CERTIFICATE_ENDPOINT = '/binancepay/openapi/certificates';
    protected const GET_CURRENCIES_ENDPOINT = '/bapi/asset/v1/public/asset-service/product/currency';
    protected const BUILD_REFUND_ENDPOINT = '/binancepay/openapi/order/refund';

    /**
     * @param \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     * @param \Magento\Framework\Url\DecoderInterface $decoder
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        private readonly \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig,
        private readonly \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
        private readonly \Magento\Framework\Url\DecoderInterface $decoder,
        private readonly \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    ) {
    }

    /**
     * Builds an order with the provided body data.
     *
     * @param string $body
     * @return array
     * @throws \Exception
     */
    public function buildOrder($body)
    {
        return $this->sendRequest(self::BUILD_ORDER_ENDPOINT, $body);
    }

    /**
     * Builds a refund with the provided body data.
     *
     * @param string $body
     * @return array
     * @throws \Exception
     */
    public function buildRefund(string $body): array
    {
        return $this->sendRequest(self::BUILD_REFUND_ENDPOINT, $body);
    }

    /**
     * Fetches the list of supported currencies.
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSupportedCurrencies(): array
    {
        try {
            $curl = $this->curlFactory->create();
            $curl->setOption(CURLOPT_ENCODING, '');
            $curl->get(self::BASE_URL_CURRENCY . self::GET_CURRENCIES_ENDPOINT);

            $response = $curl->getBody();
            $data = $this->jsonSerializer->unserialize($response);
            if (isset($data['data']) && is_array($data['data'])) {
                $currencies = [];
                foreach ($data['data'] as $currency) {
                    if (isset($currency['pair'])) {
                        $pair = explode('_', $currency['pair']);
                        if (isset($pair[0])) {
                            $currencies[] = $pair[0];
                        }
                    }
                }
                return $currencies;
            }
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }

        return [];
    }

    /**
     * Sends a request to the specified endpoint with the provided body data.
     *
     * @param string $endpoint
     * @param string $body
     * @return array
     * @throws \Exception
     */
    private function sendRequest(string $endpoint, string $body): array
    {
        $timestamp = $this->getTimestamp();
        $nonce = $this->generateNonce();
        $headers = $this->buildHeaders($timestamp, $nonce, $body);

        try {
            $curl = $this->curlFactory->create();
            $curl->setHeaders($headers);
            $curl->post(self::BASE_URL . $endpoint, $body);

            $result = $curl->getBody();
            return $this->jsonSerializer->unserialize($result);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Request failed: ' . $e->getMessage()));
        }
    }

    /**
     * Verifies the signature of the webhook request.
     *
     * @param string $body
     * @param array $webhookHeaders
     * @return bool
     */
    public function verifySignature($body, $webhookHeaders): bool
    {
        $timestamp = $this->getTimestamp();
        $nonce = $webhookHeaders['Binancepay-Nonce'];
        $signature = $this->decoder->decode($webhookHeaders['Binancepay-Signature']);

        $requestHeaders = $this->buildHeaders($timestamp, $nonce, $body);
        $payload = $this->buildPayload($webhookHeaders['Binancepay-Timestamp'], $nonce, $body);
        $certificate = $this->getCertificate($requestHeaders, $body);

        return openssl_verify($payload, $signature, $certificate, OPENSSL_ALGO_SHA256) === 1;
    }

    /**
     * Retrieves the certificate public key from Binance API.
     *
     * @param array $headers
     * @param string $body
     * @return string
     */
    protected function getCertificate(array $headers, string $body): string
    {
        $curl = $this->curlFactory->create();
        $curl->setHeaders($headers);
        $curl->post(self::BASE_URL . self::GET_CERTIFICATE_ENDPOINT, $body);

        $result = $this->jsonSerializer->unserialize($curl->getBody());
        return $result['data'][0]['certPublic'];
    }

    /**
     * Builds the headers required for Binance API requests.
     *
     * @param float $timestamp
     * @param string $nonce
     * @param string $body
     * @return array
     */
    protected function buildHeaders($timestamp, $nonce, $body): array
    {
        return [
            'Content-Type' => 'application/json',
            'BinancePay-Timestamp' => $timestamp,
            'BinancePay-Nonce' => $nonce,
            'BinancePay-Certificate-SN' => $this->adminConfig->getApiKey(),
            'BinancePay-Signature' => $this->getSignature($timestamp, $nonce, $body),
        ];
    }

    /**
     * Generates a nonce string of the given length.
     *
     * @param int $length
     * @return string
     */
    protected function generateNonce($length = 32)
    {
        return substr(
            str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)),
            0,
            $length
        );
    }

    /**
     * Builds the payload for signature verification.
     *
     * @param float $timestamp
     * @param string $nonce
     * @param string $body
     * @return string
     */
    protected function buildPayload($timestamp, $nonce, $body)
    {
        return "$timestamp\n" . "$nonce\n" . $body . "\n";
    }

    /**
     * Gets the current timestamp in milliseconds.
     */
    protected function getTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * Generates a HMAC signature for the given data.
     *
     * @param float $timestamp
     * @param string $nonce
     * @param string $body
     * @return string
     */
    protected function getSignature($timestamp, $nonce, $body)
    {
        return strtoupper(hash_hmac(
            'SHA512',
            $this->buildPayload($timestamp, $nonce, $body),
            $this->adminConfig->getSecretKey()
        ));
    }
}
