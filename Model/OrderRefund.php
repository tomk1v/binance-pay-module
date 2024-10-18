<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model;

class OrderRefund extends \Magento\Framework\Model\AbstractModel implements
    \Internship\BinancePay\Api\Data\OrderRefundInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = \Internship\BinancePay\Api\Data\OrderRefundInterface::ENTITY_ID;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\Internship\BinancePay\Model\ResourceModel\OrderRefund::class);
    }

    /**
     * Get Entity id.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Get Refund id.
     *
     * @return int
     */
    public function getRefundId()
    {
        return $this->getData(self::REFUND_ID);
    }

    /**
     * Set Refund id.
     *
     * @param int $refundId
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundId($refundId)
    {
        return $this->setData(self::REFUND_ID, $refundId);
    }

    /**
     * Get Refund Request id.
     *
     * @return string
     */
    public function getRefundRequestId()
    {
        return $this->getData(self::REFUND_REQUEST_ID);
    }

    /**
     * Set Refund Request id.
     *
     * @param string $refundRequestId
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundRequestId($refundRequestId)
    {
        return $this->setData(self::REFUND_REQUEST_ID, $refundRequestId);
    }

    /**
     * Get Prepay id.
     *
     * @return string
     */
    public function getPrepayId()
    {
        return $this->getData(self::PREPAY_ID);
    }

    /**
     * Set Prepay id.
     *
     * @param string $prepayId
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setPrepayId($prepayId)
    {
        return $this->setData(self::PREPAY_ID, $prepayId);
    }

    /**
     * Get Order Amount.
     *
     * @return float
     */
    public function getOrderAmount(): float
    {
        return $this->getData(self::ORDER_AMOUNT);
    }

    /**
     * Set Order Amount.
     *
     * @param float $orderAmount
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setOrderAmount($orderAmount)
    {
        return $this->setData(self::ORDER_AMOUNT, $orderAmount);
    }

    /**
     * Get Refunded Amount.
     *
     * @return float
     */
    public function getRefundedAmount()
    {
        return $this->getData(self::REFUNDED_AMOUNT);
    }

    /**
     * Set Refunded Amount.
     *
     * @param float $refundedAmount
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundedAmount($refundedAmount)
    {
        return $this->setData(self::REFUNDED_AMOUNT, $refundedAmount);
    }

    /**
     * Get Refund Amount.
     *
     * @return float
     */
    public function getRefundAmount()
    {
        return $this->getData(self::REFUND_AMOUNT);
    }

    /**
     * Set Refund Amount.
     *
     * @param float $refundAmount
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundAmount($refundAmount)
    {
        return $this->setData(self::REFUND_AMOUNT, $refundAmount);
    }

    /**
     * Get Remaining Attempts.
     *
     * @return int
     */
    public function getRemainingAttempts()
    {
        return $this->getData(self::REMAINING_ATTEMPTS);
    }

    /**
     * Set Remaining Attempts.
     *
     * @param int $remainingAttempts
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRemainingAttempts($remainingAttempts)
    {
        return $this->setData(self::REMAINING_ATTEMPTS, $remainingAttempts);
    }

    /**
     * Get Payer Open id.
     *
     * @return string
     */
    public function getPayerOpenId()
    {
        return $this->getData(self::PAYER_OPEN_ID);
    }

    /**
     * Set Payer Open id.
     *
     * @param string $payerOpenId
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setPayerOpenId($payerOpenId)
    {
        return $this->setData(self::PAYER_OPEN_ID, $payerOpenId);
    }

    /**
     * Get Duplicate Request Flag.
     *
     * @return string
     */
    public function getDuplicateRequest()
    {
        return $this->getData(self::DUPLICATE_REQUEST);
    }

    /**
     * Set Duplicate Request Flag.
     *
     * @param string $duplicateRequest
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setDuplicateRequest($duplicateRequest)
    {
        return $this->setData(self::DUPLICATE_REQUEST, $duplicateRequest);
    }

    /**
     * Get Refund Status.
     *
     * @return string
     */
    public function getRefundStatus()
    {
        return $this->getData(self::REFUND_STATUS);
    }

    /**
     * Set Refund Status.
     *
     * @param string $refundStatus
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundStatus($refundStatus)
    {
        return $this->setData(self::REFUND_STATUS, $refundStatus);
    }

    /**
     * Get Refund Commission.
     *
     * @return float
     */
    public function getRefundCommission()
    {
        return $this->getData(self::REFUND_COMMISSION);
    }

    /**
     * Set Refund Commission.
     *
     * @param float $refundCommission
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundCommission($refundCommission)
    {
        return $this->setData(self::REFUND_COMMISSION, $refundCommission);
    }

    /**
     * Get Refunded Commission.
     *
     * @return float
     */
    public function getRefundedCommission()
    {
        return $this->getData(self::REFUNDED_COMMISSION);
    }

    /**
     * Set Refunded Commission.
     *
     * @param float $refundedCommission
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setRefundedCommission($refundedCommission)
    {
        return $this->setData(self::REFUNDED_COMMISSION, $refundedCommission);
    }

    /**
     * Get createdAt.
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set createdAt.
     *
     * @param string $createdAt
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updatedAt.
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updatedAt.
     *
     * @param string $updatedAt
     * @return \Internship\BinancePay\Model\OrderRefund
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
