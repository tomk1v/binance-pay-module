<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\ResourceModel\BinancePay;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(\Internship\BinancePay\Model\BinancePay::class,
            \Internship\BinancePay\Model\ResourceModel\BinancePay::class);
    }
}

