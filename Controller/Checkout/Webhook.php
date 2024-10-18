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
     * @param \Internship\BinancePay\Model\Queue\Order\CreationPublisher $orderCreationPublisher
     * @param \Internship\BinancePay\Service\BinancePay $binancePayService
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        private readonly \Magento\Framework\Controller\Result\JsonFactory           $jsonFactory,
        private readonly \Magento\Framework\App\Request\Http                        $request,
        private readonly \Internship\BinancePay\Model\Queue\Order\CreationPublisher $orderCreationPublisher,
        private readonly \Internship\BinancePay\Service\BinancePay                  $binancePayService,
        private readonly \Magento\Framework\Serialize\Serializer\Json               $jsonSerializer,
    ) {
    }

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
            $requestData = $this->jsonSerializer->unserialize($body);

            if ($this->binancePayService->verifySignature($body, $this->request->getHeaders()->toArray())) {
                if (isset($requestData['bizType'])) {
                    return match ($requestData['bizType']) {
                        'PAY' => $this->handlePaySuccess($requestData, $resultJson),
                        default => $resultJson->setData(
                            ['returnCode' => 'SUCCESS', 'returnMessage' => 'Unknown bizType']
                        ),
                    };
                } else {
                    return $resultJson->setData(['returnCode' => 'FAIL', 'returnMessage' => 'Missing bizType']);
                }
            }

            return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }

    /**
     * Handles the payment success response from Binance Pay.
     *
     * @param array $response
     * @param \Magento\Framework\Controller\Result\Json $resultJson
     */
    private function handlePaySuccess($response, $resultJson)
    {
        if (isset($response['bizStatus']) && $response['bizStatus'] === 'PAY_SUCCESS') {
            try {
                $this->orderCreationPublisher->publish($this->jsonSerializer->serialize($response));
                return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'Order processing started']);
            } catch (\Exception $e) {
                return $resultJson->setData(['returnCode' => 'ERROR', "returnMessage" => $e->getMessage()]);
            }
        }
        return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
    }

    /**
     * Create exception in case CSRF validation failed.
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\Request\InvalidRequestException|null
     */
    public function createCsrfValidationException(
        \Magento\Framework\App\RequestInterface $request
    ): ?\Magento\Framework\App\Request\InvalidRequestException {
        return null;
    }

    /**
     * Perform custom request validation.
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool|null
     */
    public function validateForCsrf(\Magento\Framework\App\RequestInterface $request): ?bool
    {
        return true;
    }
}
