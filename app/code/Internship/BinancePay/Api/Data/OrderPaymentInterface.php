<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api\Data;

interface OrderPaymentInterface
{
    public const ENTITY_ID = 'entity_id';
    public const BIZ_ID = 'biz_id';
    public const BIZ_TYPE = 'biz_type';
    public const BIZ_ID_STR = 'biz_id_str';
    public const BIZ_STATUS = 'biz_status';
    public const MERCHANT_TRADE_NO = 'merchant_trade_no';
    public const PRODUCT_TYPE = 'product_type';
    public const PRODUCT_NAME = 'product_name';
    public const TRANSACT_TIME = 'transact_time';
    public const TRADE_TYPE = 'trade_type';
    public const TOTAL_FEE = 'total_fee';
    public const CURRENCY = 'currency';
    public const TRANSACTION_ID = 'transaction_id';
    public const OPEN_USER_ID = 'open_user_id';
    public const COMMISSION = 'commission';
    public const PAYER_ID = 'payer_id';
    public const PAY_METHOD = 'pay_method';
    public const INSTRUCTION_CURRENCY = 'instruction_currency';
    public const INSTRUCTION_AMOUNT = 'instruction_amount';
    public const INSTRUCTION_PRICE = 'instruction_price';
    public const CHANNEL = 'channel';
    public const ORDER_ID = 'order_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get entity id.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Get biz id.
     *
     * @return int
     */
    public function getBizId();

    /**
     * Set biz id.
     *
     * @param int $bizId
     * @return $this
     */
    public function setBizId($bizId);

    /**
     * Get a biz type.
     *
     * @return string
     */
    public function getBizType();

    /**
     * Set biz type.
     *
     * @param string $bizType
     * @return $this
     */
    public function setBizType($bizType);

    /**
     * Get biz id str.
     *
     * @return string
     */
    public function getBizIdStr();

    /**
     * Set biz id str.
     *
     * @param string $bizIdStr
     * @return $this
     */
    public function setBizIdStr($bizIdStr);

    /**
     * Get biz status.
     *
     * @return string
     */
    public function getBizStatus();

    /**
     * Set biz status.
     *
     * @param string $bizStatus
     * @return $this
     */
    public function setBizStatus($bizStatus);

    /**
     * Get merchant trade no.
     *
     * @return string
     */
    public function getMerchantTradeNo();

    /**
     * Set merchant trade no.
     *
     * @param string $merchantTradeNo
     * @return $this
     */
    public function setMerchantTradeNo($merchantTradeNo);

    /**
     * Get a product type.
     *
     * @return string
     */
    public function getProductType();

    /**
     * Set product type.
     *
     * @param string $productType
     * @return $this
     */
    public function setProductType($productType);

    /**
     * Get product name.
     *
     * @return string
     */
    public function getProductName();

    /**
     * Set product name.
     *
     * @param string $productName
     * @return $this
     */
    public function setProductName($productName);

    /**
     * Get transact time.
     *
     * @return int
     */
    public function getTransactTime();

    /**
     * Set transact time.
     *
     * @param int $transactTime
     * @return $this
     */
    public function setTransactTime($transactTime);

    /**
     * Get a trade type.
     *
     * @return string
     */
    public function getTradeType();

    /**
     * Set trade type.
     *
     * @param string $tradeType
     * @return $this
     */
    public function setTradeType($tradeType);

    /**
     * Get total fee.
     *
     * @return float
     */
    public function getTotalFee();

    /**
     * Set total fee.
     *
     * @param float $totalFee
     * @return $this
     */
    public function setTotalFee($totalFee);

    /**
     * Get currency.
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Set currency.
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency);

    /**
     * Get transaction id.
     *
     * @return string
     */
    public function getTransactionId();

    /**
     * Set transaction id.
     *
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId($transactionId);

    /**
     * Get open user id.
     *
     * @return string
     */
    public function getOpenUserId();

    /**
     * Set open user id.
     *
     * @param string $openUserId
     * @return $this
     */
    public function setOpenUserId($openUserId);

    /**
     * Get commission.
     *
     * @return string
     */
    public function getCommission();

    /**
     * Set commission.
     *
     * @param float $commission
     * @return $this
     */
    public function setCommission($commission);

    /**
     * Get payer id.
     *
     * @return string
     */
    public function getPayerId();

    /**
     * Set payer id.
     *
     * @param int $payerId
     * @return $this
     */
    public function setPayerId($payerId);

    /**
     * Get pay method.
     *
     * @return string
     */
    public function getPayMethod();

    /**
     * Set pay method.
     *
     * @param string $payMethod
     * @return $this
     */
    public function setPayMethod($payMethod);

    /**
     * Get instruction currency.
     *
     * @return string
     */
    public function getInstructionCurrency();

    /**
     * Set instruction currency.
     *
     * @param string $instructionCurrency
     * @return $this
     */
    public function setInstructionCurrency($instructionCurrency);

    /**
     * Get instruction amount.
     *
     * @return float
     */
    public function getInstructionAmount();

    /**
     * Set instruction amount.
     *
     * @param float $instructionAmount
     * @return $this
     */
    public function setInstructionAmount($instructionAmount);

    /**
     * Get instruction price.
     *
     * @return float
     */
    public function getInstructionPrice();

    /**
     * Set instruction price.
     *
     * @param float $instructionPrice
     * @return $this
     */
    public function setInstructionPrice($instructionPrice);

    /**
     * Get channel.
     *
     * @return string
     */
    public function getChannel();

    /**
     * Set channel.
     *
     * @param string $channel
     * @return $this
     */
    public function setChannel($channel);

    /**
     * Get order id.
     *
     * @return string
     */
    public function getOrderId();

    /**
     * Set order id.
     *
     * @param string $orderId
     * @return $this
     */
    public function setOrderId($orderId);

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at.
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /**
     * Get updated at.
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at.
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);
}
