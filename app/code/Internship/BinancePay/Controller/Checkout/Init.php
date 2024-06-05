<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Controller\Checkout;

class Init implements \Magento\Framework\App\ActionInterface
{
    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Checkout\Model\Session $session
     * @param \Magento\Quote\Api\PaymentMethodManagementInterface $paymentMethodManagement
     * @param \Internship\BinancePay\Service\BinancePay $binancePayService
     * @param \Internship\BinancePay\Model\Order\Mapping $orderMapping
     */
    public function __construct(
        protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        protected \Magento\Checkout\Model\Session $session,
        protected \Magento\Quote\Api\PaymentMethodManagementInterface $paymentMethodManagement,
        protected \Internship\BinancePay\Service\BinancePay $binancePayService,
        protected \Internship\BinancePay\Model\Order\Mapping $orderMapping
    ) {
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $quote = $this->session->getQuote();
            $body = json_encode($this->orderMapping->mapRequestBody($quote));

            $response = $this->binancePayService->buildOrder($body);

            if ($response['status'] == 'SUCCESS') {
                $paymentMethod = $this->paymentMethodManagement->get($quote->getId());
                $paymentMethod->setBinancePrepayId($response['data']['prepayId'])->save();

                $result = ['success' => true, 'checkoutUrl' => $response['data']['checkoutUrl']];

                $resultJson = $this->jsonFactory->create();
                $resultJson->setData($result);
                return $resultJson;
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
