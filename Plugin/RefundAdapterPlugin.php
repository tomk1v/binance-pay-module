<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

namespace Internship\BinancePay\Plugin;

class RefundAdapterPlugin
{
    /**
     * @param \Internship\BinancePay\Service\BinancePay $binancePayService
     * @param \Internship\BinancePay\Api\OrderPaymentRepositoryInterface $binancePayRepository
     * @param \Internship\BinancePay\Model\OrderRefundFactory $orderRefundFactory
     * @param \Internship\BinancePay\Api\OrderRefundRepositoryInterface $orderRefundRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Internship\BinancePay\Model\Payment\Mapping $mapping
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(
        private readonly \Internship\BinancePay\Service\BinancePay                  $binancePayService,
        private readonly \Internship\BinancePay\Api\OrderPaymentRepositoryInterface $binancePayRepository,
        private readonly \Internship\BinancePay\Model\OrderRefundFactory            $orderRefundFactory,
        private readonly \Internship\BinancePay\Api\OrderRefundRepositoryInterface  $orderRefundRepository,
        private readonly \Magento\Framework\Api\SearchCriteriaBuilder               $searchCriteriaBuilder,
        private readonly \Internship\BinancePay\Model\Payment\Mapping               $mapping,
        private readonly \Magento\Framework\Serialize\SerializerInterface           $serializer
    ) {
    }

    /**
     * Before plugin for refund method
     *
     * @param \Magento\Sales\Model\Order\RefundAdapter $subject
     * @param \Magento\Sales\Api\Data\CreditmemoInterface $creditmemo
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param bool $isOnline
     * @return $this|array
     * @throws \Exception
     */
    public function beforeRefund(
        \Magento\Sales\Model\Order\RefundAdapter $subject,
        \Magento\Sales\Api\Data\CreditmemoInterface $creditmemo,
        \Magento\Sales\Api\Data\OrderInterface $order,
        $isOnline = false
    ) {
//         TODO: Need to implement logic with partial refund
        if ($order->getPayment()->getMethod() === 'binancepay') {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('order_id', $order->getId())->create();
            $searchResult = $this->binancePayRepository->getList($searchCriteria)->getItems();

            if (empty($searchResult)) {
                return $this;
            }

            $binanceTransactionDetails = reset($searchResult);
            $bodyRefund = $this->serializer->serialize($this->mapping->mapRefundBody($binanceTransactionDetails));
            try {
                $response = $this->binancePayService->buildRefund($bodyRefund);
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Binance Pay refund request failed: %1', $e->getMessage())
                );
            }

            if ($response['status'] !== 'SUCCESS') {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Binance Pay refund failed with status: %1', $response['status'])
                );
            }

            $refundTransaction = $this->orderRefundFactory->create();
            $refundTransaction->setRefundId($response['data']['refundId']);
            $refundTransaction->setRefundRequestId($response['data']['refundRequestId']);
            $refundTransaction->setPrepayId($response['data']['prepayId']);
            $refundTransaction->setOrderAmount($response['data']['orderAmount']);
            $refundTransaction->setRefundedAmount($response['data']['refundedAmount']);
            $refundTransaction->setRefundAmount($response['data']['refundAmount']);
            $refundTransaction->setRemainingAttempts($response['data']['remainingAttempts']);
            $refundTransaction->setPayerOpenId($response['data']['payerOpenId']);
            $refundTransaction->setDuplicateRequest($response['data']['duplicateRequest']);
            $refundTransaction->setRefundStatus($response['data']['refundStatus']);
            $refundTransaction->setRefundCommission($response['data']['refundCommission']);
            $refundTransaction->setRefundedCommission($response['data']['refundedCommission']);

            $this->orderRefundRepository->save($refundTransaction);
        }

        return [$creditmemo, $order, $isOnline];
    }
}
