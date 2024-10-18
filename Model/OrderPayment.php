<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model;

class OrderPayment extends \Magento\Framework\Model\AbstractModel implements
    \Internship\BinancePay\Api\Data\OrderPaymentInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = \Internship\BinancePay\Api\Data\OrderPaymentInterface::ENTITY_ID; //@codingStandardsIgnoreLine

    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(\Internship\BinancePay\Model\ResourceModel\OrderPayment::class);
    }

    /**
     * Get biz by id.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Get biz by id.
     *
     * @return int
     */
    public function getBizId()
    {
        return $this->getData(self::BIZ_ID);
    }

    /**
     * Set biz id.
     *
     * @param int $bizId
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setBizId($bizId)
    {
        return $this->setData(self::BIZ_ID, $bizId);
    }

    /**
     * Get a biz type.
     *
     * @return int
     */
    public function getBizType()
    {
        return $this->getData(self::BIZ_TYPE);
    }

    /**
     * Set biz id.
     *
     * @param int $bizType
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setBizType($bizType)
    {
        return $this->setData(self::BIZ_TYPE, $bizType);
    }

    /**
     * Get biz id str.
     *
     * @return string
     */
    public function getBizIdStr()
    {
        return $this->getData(self::BIZ_ID_STR);
    }

    /**
     * Set biz id str.
     *
     * @param string $bizIdStr
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setBizIdStr($bizIdStr)
    {
        return $this->setData(self::BIZ_ID_STR, $bizIdStr);
    }

    /**
     * Get biz status.
     *
     * @return string
     */
    public function getBizStatus()
    {
        return $this->getData(self::BIZ_STATUS);
    }

    /**
     * Set biz status.
     *
     * @param string $bizStatus
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setBizStatus($bizStatus)
    {
        return $this->setData(self::BIZ_STATUS, $bizStatus);
    }

    /**
     * Get merchant trade no.
     *
     * @return string
     */
    public function getMerchantTradeNo()
    {
        return $this->getData(self::MERCHANT_TRADE_NO);
    }

    /**
     * Set merchant trade no.
     *
     * @param string $merchantTradeNo
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setMerchantTradeNo($merchantTradeNo)
    {
        return $this->setData(self::MERCHANT_TRADE_NO, $merchantTradeNo);
    }

    /**
     * Get a product type.
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->getData(self::PRODUCT_TYPE);
    }

    /**
     * Set a product type.
     *
     * @param string $productType
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setProductType($productType)
    {
        return $this->setData(self::PRODUCT_TYPE, $productType);
    }

    /**
     * Get product name.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * Set product name.
     *
     * @param string $productName
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * Get transact time.
     *
     * @return int
     */
    public function getTransactTime()
    {
        return $this->getData(self::TRANSACT_TIME);
    }

    /**
     * Set transact time.
     *
     * @param string $transactTime
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setTransactTime($transactTime)
    {
        return $this->setData(self::TRANSACT_TIME, $transactTime);
    }

    /**
     * Get a trade type.
     *
     * @return string
     */
    public function getTradeType()
    {
        return $this->getData(self::TRADE_TYPE);
    }

    /**
     * Set a trade type.
     *
     * @param string $tradeType
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setTradeType($tradeType)
    {
        return $this->setData(self::TRADE_TYPE, $tradeType);
    }

    /**
     * Get total fee.
     *
     * @return float
     */
    public function getTotalFee()
    {
        return $this->getData(self::TOTAL_FEE);
    }

    /**
     * Set total fee.
     *
     * @param float $totalFee
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setTotalFee($totalFee)
    {
        return $this->setData(self::TOTAL_FEE, $totalFee);
    }

    /**
     * Get currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getData(self::CURRENCY);
    }

    /**
     * Set currency.
     *
     * @param string $currency
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setCurrency($currency)
    {
        return $this->setData(self::CURRENCY, $currency);
    }

    /**
     * Get transaction id.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getData(self::TRANSACTION_ID);
    }

    /**
     * Set transaction id.
     *
     * @param string $transactionId
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setTransactionId($transactionId)
    {
        return $this->setData(self::TRANSACTION_ID, $transactionId);
    }

    /**
     * Get open user id.
     *
     * @return string
     */
    public function getOpenUserId()
    {
        return $this->getData(self::OPEN_USER_ID);
    }

    /**
     * Set open user id.
     *
     * @param string $openUserId
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setOpenUserId($openUserId)
    {
        return $this->setData(self::OPEN_USER_ID, $openUserId);
    }

    /**
     * Get commission.
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->getData(self::COMMISSION);
    }

    /**
     * Set commission.
     *
     * @param string $commission
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setCommission($commission)
    {
        return $this->setData(self::COMMISSION, $commission);
    }

    /**
     * Get payer id.
     *
     * @return string
     */
    public function getPayerId()
    {
        return $this->getData(self::PAYER_ID);
    }

    /**
     * Set payer id.
     *
     * @param string $payerId
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setPayerId($payerId)
    {
        return $this->setData(self::PAYER_ID, $payerId);
    }

    /**
     * Get pay method.
     *
     * @return string
     */
    public function getPayMethod()
    {
        return $this->getData(self::PAY_METHOD);
    }

    /**
     * Set pay method.
     *
     * @param string $payMethod
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setPayMethod($payMethod)
    {
        return $this->setData(self::PAY_METHOD, $payMethod);
    }

    /**
     * Get instruction currency.
     *
     * @return string
     */
    public function getInstructionCurrency()
    {
        return $this->getData(self::INSTRUCTION_CURRENCY);
    }

    /**
     * Set instruction currency.
     *
     * @param string $instructionCurrency
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setInstructionCurrency($instructionCurrency)
    {
        return $this->setData(self::INSTRUCTION_CURRENCY, $instructionCurrency);
    }

    /**
     * Get instruction amount.
     *
     * @return float
     */
    public function getInstructionAmount()
    {
        return $this->getData(self::INSTRUCTION_AMOUNT);
    }

    /**
     * Set commission.
     *
     * @param float $instructionAmount
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setInstructionAmount($instructionAmount)
    {
        return $this->setData(self::INSTRUCTION_AMOUNT, $instructionAmount);
    }

    /**
     * Get instruction price.
     *
     * @return float
     */
    public function getInstructionPrice()
    {
        return $this->getData(self::INSTRUCTION_PRICE);
    }

    /**
     * Set instruction price.
     *
     * @param float $instructionPrice
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setInstructionPrice($instructionPrice)
    {
        return $this->setData(self::INSTRUCTION_PRICE, $instructionPrice);
    }

    /**
     * Get channel.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->getData(self::CHANNEL);
    }

    /**
     * Set channel.
     *
     * @param string $channel
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setChannel($channel)
    {
        return $this->setData(self::CHANNEL, $channel);
    }

    /**
     * Get order id.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set order id.
     *
     * @param string $orderId
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at.
     *
     * @param string $createdAt
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at.
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at.
     *
     * @param string $updatedAt
     * @return \Internship\BinancePay\Model\OrderPayment
     */
    public function setUpdatedAt(string $updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
