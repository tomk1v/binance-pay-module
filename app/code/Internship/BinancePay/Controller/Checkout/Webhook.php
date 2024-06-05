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
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Internship\BinancePay\Model\Queue\Order\Publisher $orderPublisher
     * @param \Internship\BinancePay\Service\BinancePay $binancePayService
     */
    public function __construct(
        protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        protected \Magento\Framework\App\Request\Http $request,
        protected \Internship\BinancePay\Model\Queue\Order\Publisher $orderPublisher,
        protected \Internship\BinancePay\Service\BinancePay $binancePayService
    ) {
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
            $requestData = json_decode($body, true);

            if ($this->binancePayService->verifySignature($body, $this->request->getHeaders()->toArray())) {
                return $this->handleSuccess($requestData, $resultJson);
            }

            return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
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
