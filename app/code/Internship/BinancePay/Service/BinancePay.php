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

    public function __construct(
        protected \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig,
        protected \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
    ) {
    }

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

    public function verifySignature($body, $headers): bool
    {
        $timestamp = $this->getTimestamp();
        $nonce = $headers['Binancepay-Nonce'];
        $signature = base64_decode($headers['Binancepay-Signature']);

        $headers = $this->buildHeaders($timestamp, $nonce, $body);
        $payload = $this->buildPayload($headers['Binancepay-Timestamp'], $nonce, $body);
        $certificate = $this->getCertificate($headers, $body);

        return openssl_verify($payload, $signature, $certificate, OPENSSL_ALGO_SHA256) === 1;
    }

    protected function getCertificate(array $headers, string $body): string
    {
        $curl = $this->curlFactory->create();
        $curl->setHeaders($headers);
        $curl->post(self::BASE_URL . self::GET_CERTIFICATE_ENDPOINT, $body);

        $result = json_decode($curl->getBody(), true);
        return $result['data'][0]['certPublic'];
    }

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

    protected function generateNonce($length = 32)
    {
        return substr(
            str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)),
            0,
            $length
        );
    }

    protected function buildPayload($timestamp, $nonce, $body)
    {
        return "$timestamp\n" . "$nonce\n" . $body . "\n";
    }

    protected function getTimestamp()
    {
        return round(microtime(true) * 1000);
    }

    protected function getSignature($timestamp, $nonce, $body)
    {
        return strtoupper(hash_hmac(
            'SHA512',
            $this->buildPayload($timestamp, $nonce, $body),
            $this->adminConfig->getSecretKey()
        ));
    }
}
