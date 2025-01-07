<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2025 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level.
     *
     * @var int
     */
    protected $loggerType = \Monolog\Logger::DEBUG;

    /**
     * File name.
     *
     * @var string
     */
    protected $fileName = '/var/log/binance-pay.log';
}
