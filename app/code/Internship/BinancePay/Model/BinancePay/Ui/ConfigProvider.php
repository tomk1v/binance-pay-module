<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\BinancePay\Ui;

class ConfigProvider extends \Magento\Payment\Gateway\Config\Config
{
    public const METHOD_CODE = 'binancepay';
}
