<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Config\Source;

class CryptoSymbols implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Provide options for cryptocurrency symbols.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'btcusdt', 'label' => __('BTC/USDT')],
            ['value' => 'ethusdt', 'label' => __('ETH/USDT')],
            ['value' => 'solusdt', 'label' => __('SOL/USDT')],
            ['value' => 'xrpusdt', 'label' => __('XRP/USDT')],
            ['value' => 'bnbusdt', 'label' => __('BNB/USDT')],
            ['value' => 'dogeusdt', 'label' => __('DOGE/USDT')],
        ];
    }
}
