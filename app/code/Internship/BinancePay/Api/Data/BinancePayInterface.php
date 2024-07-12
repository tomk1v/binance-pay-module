<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api\Data;

interface BinancePayInterface
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
    public const INSTRUCTION_CHANNEL = 'instruction_channel';
    public const ORDER_ID = 'order_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return int
     */
    public function getBizId();

    /**
     * @param int $bizId
     * @return $this
     */
    public function setBizId($bizId);

    /**
     * @return string
     */
    public function getBizType();

    /**
     * @param string $bizType
     * @return $this
     */
    public function setBizType($bizType);

    /**
     * @return string
     */
    public function getBizIdStr();

    /**
     * @param string $bizIdStr
     * @return $this
     */
    public function setBizIdStr($bizIdStr);

    /**
     * @return string
     */
    public function getBizStatus();

    /**
     * @param string $bizStatus
     * @return $this
     */
    public function setBizStatus($bizStatus);

    /**
     * @return string
     */
    public function getMerchantTradeNo();

    /**
     * @param string $merchantTradeNo
     * @return $this
     */
    public function setMerchantTradeNo($merchantTradeNo);

    /**
     * @return string
     */
    public function getProductType();

    /**
     * @param string $productType
     * @return $this
     */
    public function setProductType($productType);

    /**
     * @return string
     */
    public function getProductName();

    /**
     * @param string $productName
     * @return $this
     */
    public function setProductName($productName);

    /**
     * @return int
     */
    public function getTransactTime();

    /**
     * @param int $transactTime
     * @return $this
     */
    public function setTransactTime($transactTime);

    /**
     * @return string
     */
    public function getTradeType();

    /**
     * @param string $tradeType
     * @return $this
     */
    public function setTradeType($tradeType);

    /**
     * @return float
     */
    public function getTotalFee();

    /**
     * @param float $totalFee
     * @return $this
     */
    public function setTotalFee($totalFee);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency);

    /**
     * @return string
     */
    public function getTransactionId();

    /**
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId($transactionId);

    /**
     * @return string
     */
    public function getOpenUserId();

    /**
     * @param string $openUserId
     * @return $this
     */
    public function setOpenUserId($openUserId);

    /**
     * @return string
     */
    public function getCommission();

    /**
     * @param float $commission
     * @return $this
     */
    public function setCommission($commission);

    /**
     * @return string
     */
    public function getPayerId();

    /**
     * @param int $payerId
     * @return $this
     */
    public function setPayerId($payerId);

    /**
     * @return string
     */
    public function getPayMethod();

    /**
     * @param string $payMethod
     * @return $this
     */
    public function setPayMethod($payMethod);

    /**
     * @return string
     */
    public function getInstructionCurrency();

    /**
     * @param string $instructionCurrency
     * @return $this
     */
    public function setInstructionCurrency($instructionCurrency);

    /**
     * @return float
     */
    public function getInstructionAmount();

    /**
     * @param float $instructionAmount
     * @return $this
     */
    public function setInstructionAmount($instructionAmount);

    /**
     * @return float
     */
    public function getInstructionPrice();

    /**
     * @param float $instructionPrice
     * @return $this
     */
    public function setInstructionPrice($instructionPrice);

    /**
     * @return string
     */
    public function getInstructionChannel();

    /**
     * @param string $instructionChannel
     * @return $this
     */
    public function setInstructionChanel($instructionChannel);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);
}
