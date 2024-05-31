<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Controller\Checkout;

class Webhook implements \Magento\Framework\App\ActionInterface, \Magento\Framework\App\CsrfAwareActionInterface
{
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig
     */
    public function __construct(
        protected \Magento\Framework\App\Action\Context            $context,
        protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        protected \Magento\Framework\HTTP\Client\CurlFactory       $curlFactory,
        protected \Magento\Framework\App\Request\Http              $request,
        protected \Internship\BinancePay\Helper\Adminhtml\Config   $adminConfig,
        protected \Magento\Sales\Model\OrderFactory $orderFactory,
        protected \Magento\Checkout\Model\Session $checkoutSession,
        protected \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        protected \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        protected \Magento\Quote\Api\CartManagementInterface $cartManagement,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        protected \Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory $quotePaymentCollectionFactory,
        protected \Internship\BinancePay\Model\Queue\Order\Publisher $orderPublisher
    ){
    }

    //TODO: realize refund and check webhook address
    /**
     * Verify webhook and create order
     *
     * @return \Magento\Framework\Controller\Result\Json
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $resultJson = $this->jsonFactory->create();
            $body = $this->request->getContent();
            $response = json_decode($body, true);

            $timestamp = round(microtime(true) * 1000);
            $nonce = $this->request->getHeader('Binancepay-Nonce');
            $payload = "{$timestamp}\n{$nonce}\n{$body}\n";
            $signature = strtoupper(hash_hmac('SHA512', $payload, $this->adminConfig->getSecretKey()));

            $headers = $this->buildHeaders($timestamp, $nonce, $signature);
            $certPublic = $this->getCertificate($headers, $body);

            if ($this->verifySignature($response, $certPublic)) {
                return $this->handleSuccess($response, $resultJson);
            }

            return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    protected function buildHeaders($timestamp, string $nonce, string $signature): array
    {
        return [
            'Content-Type' => 'application/json',
            'BinancePay-Timestamp' => $timestamp,
            'BinancePay-Nonce' => $nonce,
            'BinancePay-Certificate-SN' => $this->adminConfig->getApiKey(),
            'BinancePay-Signature' => $signature,
        ];
    }

    protected function getCertificate(array $headers, string $body): string
    {
        $curl = $this->curlFactory->create();
        $curl->setHeaders($headers);
        $curl->post("https://bpay.binanceapi.com/binancepay/openapi/certificates", $body);
        $result = json_decode($curl->getBody(), true);
        return $result['data'][0]['certPublic'];
    }

    protected function verifySignature(array $response, string $certPublic): bool
    {
        $payload = "{$this->request->getHeader('Binancepay-Timestamp')}\n" .
            "{$this->request->getHeader('Binancepay-Nonce')}\n" .
            json_encode($response, JSON_THROW_ON_ERROR) . "\n";
        $decodedSignature = base64_decode($this->request->getHeader('Binancepay-Signature'));
        return openssl_verify($payload, $decodedSignature, $certPublic, OPENSSL_ALGO_SHA256) === 1;
    }

    protected function handleSuccess($response, $resultJson)
    {
        if (isset($response['bizStatus']) && $response['bizStatus'] === 'PAY_SUCCESS') {
            try {
                $this->orderPublisher->publish(json_encode($response));
                return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'Order processing started']);
            } catch (\Exception $e) {
                return $resultJson->setData(['returnCode' => 'ERROR', "returnMessage" => $e->getMessage()]);
            }
        }
        return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
    }

    public function createCsrfValidationException(\Magento\Framework\App\RequestInterface $request): ? \Magento\Framework\App\Request\InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(\Magento\Framework\App\RequestInterface $request): ?bool
    {
        return true;
    }
}
