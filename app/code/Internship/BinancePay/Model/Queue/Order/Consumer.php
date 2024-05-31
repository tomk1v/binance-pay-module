<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Queue\Order;

class Consumer
{
    /**
     * @param \Magento\Quote\Api\CartRepositoryInterface $cartRepository
     * @param \Magento\Quote\Api\CartManagementInterface $cartManagement
     * @param \Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory $quotePaymentCollectionFactory
     */
    public function __construct(
        protected \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        protected \Magento\Quote\Api\CartManagementInterface $cartManagement,
        protected \Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory $quotePaymentCollectionFactory,
    ) {
    }

    /**
     * Processes a received message from the queue.
     *
     * @param string $message The message to be processed.
     * @return void
     * @throws \Exception
     */
    public function processMessage($message)
    {
        try {
            $paymentData = json_decode($message, true);
            $this->createOrder($paymentData);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param array $paymentData
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Exception
     */
    protected function createOrder(array $paymentData)
    {
        try {
            $payment = $this->quotePaymentCollectionFactory->create()
                ->addFieldToFilter('binance_prepay_id', $paymentData['bizIdStr'])
                ->getFirstItem();

            if ($payment) {
                $quote = $this->cartRepository->getActive($payment->getQuoteId());
                $orderId = $this->cartManagement->placeOrder($quote->getId());

                if (!$orderId) {
                    throw new \Magento\Framework\Exception\CouldNotSaveException(__('Order could not be created'));
                }
            }
        } catch (\Magento\Framework\Exception\CouldNotSaveException $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }
    }
}
