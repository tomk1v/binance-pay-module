<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api\Data;

interface OrderRefundInterface
{
    public const ENTITY_ID = 'entity_id';
    public const REFUND_ID = 'refund_id';
    public const REFUND_REQUEST_ID = 'refund_request_id';
    public const PREPAY_ID = 'prepay_id';
    public const ORDER_AMOUNT = 'order_amount';
    public const REFUNDED_AMOUNT = 'refunded_amount';
    public const REFUND_AMOUNT = 'refund_amount';
    public const REMAINING_ATTEMPTS = 'remaining_attempts';
    public const PAYER_OPEN_ID = 'payer_open_id';
    public const DUPLICATE_REQUEST = 'duplicate_request';
    public const REFUND_STATUS = 'refund_status';
    public const REFUND_COMMISSION = 'refund_commission';
    public const REFUNDED_COMMISSION = 'refunded_commission';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get Entity id.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Get Refund id.
     *
     * @return int
     */
    public function getRefundId();

    /**
     * Set Refund id.
     *
     * @param int $refundId
     * @return $this
     */
    public function setRefundId($refundId);

    /**
     * Get Refund Request id.
     *
     * @return string
     */
    public function getRefundRequestId();

    /**
     * Set Refund Request id.
     *
     * @param string $refundRequestId
     * @return $this
     */
    public function setRefundRequestId($refundRequestId);

    /**
     * Get Prepay id.
     *
     * @return string
     */
    public function getPrepayId();

    /**
     * Set Prepay id.
     *
     * @param string $prepayId
     * @return $this
     */
    public function setPrepayId($prepayId);

    /**
     * Get Order Amount.
     *
     * @return float
     */
    public function getOrderAmount();

    /**
     * Set Order Amount.
     *
     * @param float $orderAmount
     * @return $this
     */
    public function setOrderAmount($orderAmount);

    /**
     * Get Refunded Amount.
     *
     * @return float
     */
    public function getRefundedAmount();

    /**
     * Set Refunded Amount.
     *
     * @param float $refundedAmount
     * @return $this
     */
    public function setRefundedAmount($refundedAmount);

    /**
     * Get Refund Amount.
     *
     * @return float
     */
    public function getRefundAmount();

    /**
     * Set Refund Amount.
     *
     * @param float $refundAmount
     * @return $this
     */
    public function setRefundAmount($refundAmount);

    /**
     * Get Remaining Attempts.
     *
     * @return int
     */
    public function getRemainingAttempts();

    /**
     * Set Remaining Attempts.
     *
     * @param int $remainingAttempts
     * @return $this
     */
    public function setRemainingAttempts($remainingAttempts);

    /**
     * Get Payer Open id.
     *
     * @return string
     */
    public function getPayerOpenId();

    /**
     * Set Payer Open id.
     *
     * @param string $payerOpenId
     * @return $this
     */
    public function setPayerOpenId($payerOpenId);

    /**
     * Get Duplicate Request Flag.
     *
     * @return string
     */
    public function getDuplicateRequest();

    /**
     * Set Duplicate Request Flag.
     *
     * @param string $duplicateRequest
     * @return $this
     */
    public function setDuplicateRequest($duplicateRequest);

    /**
     * Get Refund Status.
     *
     * @return string
     */
    public function getRefundStatus();

    /**
     * Set Refund Status.
     *
     * @param string $refundStatus
     * @return $this
     */
    public function setRefundStatus($refundStatus);

    /**
     * Get Refund Commission.
     *
     * @return float
     */
    public function getRefundCommission();

    /**
     * Set Refund Commission.
     *
     * @param float $refundCommission
     * @return $this
     */
    public function setRefundCommission($refundCommission);

    /**
     * Get Refunded Commission.
     *
     * @return float
     */
    public function getRefundedCommission();

    /**
     * Set Refund Commission.
     *
     * @param float $refundedCommission
     * @return $this
     */
    public function setRefundedCommission($refundedCommission);

    /**
     * Get Created At timestamp.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Created At timestamp.
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Updated At timestamp.
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Updated At timestamp.
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
