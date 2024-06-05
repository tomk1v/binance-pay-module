<?php
/**
 * @author Barwenock
 * @copyright Copyright (c) Barwenock
 * @package Social Authorizes for Magento 2
 */

declare(strict_types=1);

namespace Internship\BinancePay\Service;

class BinancePay
{
    protected const BASE_URL = 'https://bpay.binanceapi.com';
    protected const BUILD_ORDER_ENDPOINT = '/binancepay/openapi/v3/order';
    protected const GET_CERTIFICATE_ENDPOINT = '/binancepay/openapi/certificates';

    /**
     * @param \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     */
    public function __construct(
        protected \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig,
        protected \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
    ) {
    }

    /**
     * Builds an order with the provided body data.
     *
     * @param string $body
     * @return array
     */
    public function buildOrder($body)
    {
        $timestamp = $this->getTimestamp();
        $nonce = $this->generateNonce();
        $headers = $this->buildHeaders($timestamp, $nonce, $body);

        $curl = $this->curlFactory->create();
        $curl->setHeaders($headers);
        $curl->post(self::BASE_URL . self::BUILD_ORDER_ENDPOINT, $body);
        $result = $curl->getBody();
        return json_decode($result, true);
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
        $signature = base64_decode($webhookHeaders['Binancepay-Signature']);

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

        $result = json_decode($curl->getBody(), true);
        return $result['data'][0]['certPublic'];
    }

    /**
     * Builds the headers required for Binance API requests.
     *
     * @param $timestamp
     * @param $nonce
     * @param $body
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
     * @param $length
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
     * @param $timestamp
     * @param $nonce
     * @param $body
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
     * @param $timestamp
     * @param $nonce
     * @param $body
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
