<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model;

class BinancePay extends \Magento\Framework\Model\AbstractModel
    implements \Internship\BinancePay\Api\Data\BinancePayInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = \Internship\BinancePay\Api\Data\BinancePayInterface::ENTITY_ID; //@codingStandardsIgnoreLine

    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(\Internship\BinancePay\Model\ResourceModel\BinancePay::class);
    }

    /**
     * Get biz by id
     *
     * @return int
     */
    public function getBizId()
    {
        return $this->getData(self::BIZ_ID);
    }

    /**
     * Set biz id
     *
     * @param int $bizId
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setBizId($bizId)
    {
        return $this->setData(self::BIZ_ID, $bizId);
    }

    /**
     * Get a biz type
     *
     * @return int
     */
    public function getBizType()
    {
        return $this->getData(self::BIZ_TYPE);
    }

    /**
     * Set biz id
     *
     * @param int $bizType
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setBizType($bizType)
    {
        return $this->setData(self::BIZ_ID, $bizType);
    }

    /**
     * Get biz id str
     *
     * @return string
     */
    public function getBizIdStr()
    {
        return $this->getData(self::BIZ_ID_STR);
    }

    /**
     * Set biz id str
     *
     * @param string $bizIdStr
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setBizIdStr($bizIdStr)
    {
        return $this->setData(self::BIZ_ID_STR, $bizIdStr);
    }

    /**
     * Get biz status
     *
     * @return string
     */
    public function getBizStatus()
    {
        return $this->getData(self::BIZ_STATUS);
    }

    /**
     * Set biz status
     *
     * @param string $bizStatus
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setBizStatus($bizStatus)
    {
        return $this->setData(self::BIZ_STATUS, $bizStatus);
    }

    /**
     * Get merchantTradeNo
     *
     * @return string
     */
    public function getMerchantTradeNo()
    {
        return $this->getData(self::MERCHANT_TRADE_NO);
    }

    /**
     * Set merchantTradeNo
     *
     * @param string $merchantTradeNo
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setMerchantTradeNo($merchantTradeNo)
    {
        return $this->setData(self::MERCHANT_TRADE_NO, $merchantTradeNo);
    }

    /**
     * Get productType
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->getData(self::PRODUCT_TYPE);
    }

    /**
     * @param string $productType
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setProductType($productType)
    {
        return $this->setData(self::PRODUCT_TYPE, $productType);
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * Set productName
     *
     * @param string $productName
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setProductName($productName)
    {
        return $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * Get transactTime
     *
     * @return int
     */
    public function getTransactTime()
    {
        return $this->getData(self::TRANSACT_TIME);
    }

    /**
     * Set transactTime
     *
     * @param string $transactTime
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setTransactTime($transactTime)
    {
        return $this->setData(self::TRANSACT_TIME, $transactTime);
    }

    /**
     * Get transactTime
     *
     * @return string
     */
    public function getTradeType()
    {
        return $this->getData(self::TRADE_TYPE);
    }

    /**
     * Set tradeType
     *
     * @param string $tradeType
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setTradeType($tradeType)
    {
        return $this->setData(self::TRADE_TYPE, $tradeType);
    }

    /**
     * Get totalFee
     *
     * @return float
     */
    public function getTotalFee()
    {
        return $this->getData(self::TOTAL_FEE);
    }

    /**
     * Set totalFee
     *
     * @param float $totalFee
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setTotalFee($totalFee)
    {
        return $this->setData(self::TOTAL_FEE, $totalFee);
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getData(self::CURRENCY);
    }

    /**
     * Set currency
     *
     * @param $currency
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setCurrency($currency)
    {
        return $this->setData(self::CURRENCY, $currency);
    }

    /**
     * Get transactionId
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getData(self::TRANSACTION_ID);
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setTransactionId($transactionId)
    {
        return $this->setData(self::TRANSACTION_ID, $transactionId);
    }

    /**
     * Get openUserId
     *
     * @return string
     */
    public function getOpenUserId()
    {
        return $this->getData(self::OPEN_USER_ID);
    }

    /**
     * Set openUserId
     *
     * @param string $openUserId
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setOpenUserId($openUserId)
    {
        return $this->setData(self::OPEN_USER_ID, $openUserId);
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->getData(self::COMMISSION);
    }

    /**
     * Set commission
     *
     * @param string $commission
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setCommission($commission)
    {
        return $this->setData(self::COMMISSION, $commission);
    }

    /**
     * Get payerId
     *
     * @return string
     */
    public function getPayerId()
    {
        return $this->getData(self::PAYER_ID);
    }

    /**
     * Set payerId
     *
     * @param string $payerId
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setPayerId($payerId)
    {
        return $this->setData(self::PAYER_ID, $payerId);
    }

    /**
     * Get payMethod
     *
     * @return string
     */
    public function getPayMethod()
    {
        return $this->getData(self::PAY_METHOD);
    }

    /**
     * Set payMethod
     *
     * @param string $payMethod
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setPayMethod($payMethod)
    {
        return $this->setData(self::PAY_METHOD, $payMethod);
    }

    /**
     * Get instructionCurrency
     *
     * @return string
     */
    public function getInstructionCurrency()
    {
        return $this->getData(self::INSTRUCTION_CURRENCY);
    }

    /**
     * Set instructionCurrency
     *
     * @param string $instructionCurrency
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setInstructionCurrency($instructionCurrency)
    {
        return $this->setData(self::INSTRUCTION_CURRENCY, $instructionCurrency);
    }

    /**
     * Get instructionAmount
     *
     * @return float
     */
    public function getInstructionAmount()
    {
        return $this->getData(self::INSTRUCTION_AMOUNT);
    }

    /**
     * Set commission
     *
     * @param float $instructionAmount
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setInstructionAmount($instructionAmount)
    {
        return $this->setData(self::INSTRUCTION_AMOUNT, $instructionAmount);
    }

    /**
     * Get instructionPrice
     *
     * @return float
     */
    public function getInstructionPrice()
    {
        return $this->getData(self::INSTRUCTION_PRICE);
    }

    /**
     * Set instructionPrice
     *
     * @param float $instructionPrice
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setInstructionPrice($instructionPrice)
    {
        return $this->setData(self::INSTRUCTION_PRICE, $instructionPrice);
    }

    /**
     * Get instructionChannel
     *
     * @return string
     */
    public function getInstructionChannel()
    {
        return $this->getData(self::INSTRUCTION_CHANNEL);
    }

    /**
     * Set instructionChannel
     *
     * @param string $instructionChannel
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setInstructionChanel($instructionChannel)
    {
        return $this->setData(self::INSTRUCTION_CHANNEL, $instructionChannel);
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set createdAt
     *
     * @param string $createdAt
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updatedAt
     *
     * @param string $updatedAt
     * @return \Internship\BinancePay\Model\BinancePay
     */
    public function setUpdatedAt(string $updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
