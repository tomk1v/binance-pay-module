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
     * @param \Internship\BinancePay\Model\Payment\Mapping $mapping
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(
        private readonly \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        private readonly \Magento\Checkout\Model\Session $session,
        private readonly \Magento\Quote\Api\PaymentMethodManagementInterface $paymentMethodManagement,
        private readonly \Internship\BinancePay\Service\BinancePay $binancePayService,
        private readonly \Internship\BinancePay\Model\Payment\Mapping $mapping,
        private readonly \Magento\Framework\Serialize\SerializerInterface $serializer
    ) {
    }

    /**
     * Initialize Binance Pay checkout
     *
     * @return \Magento\Framework\Controller\Result\Json
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $quote = $this->session->getQuote();
            $body = $this->serializer->serialize($this->mapping->mapOrderBody($quote));

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
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }
}
