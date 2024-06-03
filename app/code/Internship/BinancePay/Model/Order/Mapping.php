<?php
/**
 * @author Barwenock
 * @copyright Copyright (c) Barwenock
 * @package Social Authorizes for Magento 2
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Order;

class Mapping
{
    /**
     * @param \DateTime $dateTime
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        protected \DateTime $dateTime,
        protected \Magento\Framework\UrlInterface $url
    ) {
    }

    public function mapRequestBody($quote)
    {
        return [
            'env' => [
                'terminalType' => 'WEB'
            ],
            'orderTags' => [
                'ifProfitSharing' => false
            ],
            'merchantTradeNo' => $this->generateUniqueMerchantTradeNo(),
            'orderAmount' => '0.00000001',
            'currency' => 'USDT',
            'description' => 'very good Ice Cream',
            'goodsDetails' => $this->generateGoods($quote->getItems()),
            'returnUrl' => $this->getReturnUrl() . '?quoteId=' . $quote->getId()
        ];
    }

    protected function generateGoods($quoteItems)
    {
        $goodsArray = [];

        foreach ($quoteItems as $item) {
            $goodsArray[] = [
                'goodsType' => '01',
                'goodsName' => $item['name'],
                'referenceGoodsId' => $item['sku']
            ];
        }

        return $goodsArray;
    }

    protected function generateUniqueMerchantTradeNo()
    {
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        return $this->dateTime->format('YmdHis') . $randomString;
    }

    protected function getReturnUrl()
    {
        return rtrim($this->url->getUrl('binancepay/checkout/success'), '/');
    }
}
