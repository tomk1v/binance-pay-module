<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model;

class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'binancepay';
}
