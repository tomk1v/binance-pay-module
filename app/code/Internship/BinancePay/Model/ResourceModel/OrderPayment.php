<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\ResourceModel;

class OrderPayment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    private const TABLE_NAME = 'binancepay_order_payment';

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(self::TABLE_NAME, \Internship\BinancePay\Api\Data\OrderPaymentInterface::ENTITY_ID);
    }
}
