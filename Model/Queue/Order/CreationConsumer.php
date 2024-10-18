<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Queue\Order;

use Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory;

class CreationConsumer
{
    /**
     * @param \Magento\Quote\Api\CartRepositoryInterface $cartRepository
     * @param \Magento\Quote\Api\CartManagementInterface $cartManagement
     * @param CollectionFactory $quotePaymentCollectionFactory
     * @param \Internship\BinancePay\Model\OrderPaymentFactory $orderPaymentFactory
     * @param \Internship\BinancePay\Api\OrderPaymentRepositoryInterface $binancePayRepository
     * @param \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
     */
    public function __construct(
        private readonly \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        private readonly \Magento\Quote\Api\CartManagementInterface $cartManagement,
        private readonly CollectionFactory $quotePaymentCollectionFactory,
        private readonly \Internship\BinancePay\Model\OrderPaymentFactory $orderPaymentFactory,
        private readonly \Internship\BinancePay\Api\OrderPaymentRepositoryInterface $binancePayRepository,
        private readonly \Magento\Framework\Serialize\Serializer\Json $jsonSerializer,
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
            $paymentData = $this->jsonSerializer->unserialize($message);
            $this->createOrder($paymentData);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }

    /**
     * Create order on success webhook and store data of transaction.
     *
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

            if ($payment->getId()) {
                $quote = $this->cartRepository->getActive($payment->getQuoteId());
                $orderId = $this->cartManagement->placeOrder($quote->getId());

                if (!$orderId) {
                    throw new \Magento\Framework\Exception\CouldNotSaveException(__('Order could not be created'));
                }

                $binanceTransaction = $this->orderPaymentFactory->create();

                if (isset($paymentData['data'])) {
                    $transactionData = $this->jsonSerializer->unserialize($paymentData['data']);
                    $binanceTransaction->setMerchantTradeNo($transactionData['merchantTradeNo']);
                    $binanceTransaction->setProductType($transactionData['productType']);
                    $binanceTransaction->setProductName($transactionData['productName']);
                    $binanceTransaction->setTransactTime($transactionData['transactTime']);
                    $binanceTransaction->setTradeType($transactionData['tradeType']);
                    $binanceTransaction->setTotalFee($transactionData['totalFee']);
                    $binanceTransaction->setCurrency($transactionData['currency']);
                    $binanceTransaction->setTransactionId($transactionData['transactionId']);
                    $binanceTransaction->setOpenUserId($transactionData['openUserId']);
                    $binanceTransaction->setCommission($transactionData['commission']);
                    $binanceTransaction->setPayerId($transactionData['paymentInfo']['payerId']);
                    $binanceTransaction->setPayMethod($transactionData['paymentInfo']['payMethod']);
                    $binanceTransaction->setInstructionCurrency(
                        $transactionData['paymentInfo']['paymentInstructions'][0]['currency']
                    );
                    $binanceTransaction->setInstructionAmount(
                        (float)$transactionData['paymentInfo']['paymentInstructions'][0]['amount']
                    );
                    $binanceTransaction->setInstructionPrice(
                        $transactionData['paymentInfo']['paymentInstructions'][0]['price']
                    );
                    $binanceTransaction->setChannel($transactionData['paymentInfo']['channel']);
                }

                $binanceTransaction->setBizType($paymentData['bizType']);
                $binanceTransaction->setBizId($paymentData['bizId']);
                $binanceTransaction->setBizIdStr($paymentData['bizIdStr']);
                $binanceTransaction->setBizStatus($paymentData['bizStatus']);
                $binanceTransaction->setOrderId($orderId);
                $this->binancePayRepository->save($binanceTransaction);
            }
        } catch (\Magento\Framework\Exception\CouldNotSaveException $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }
    }
}
