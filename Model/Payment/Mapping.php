<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Model\Payment;

class Mapping
{
    /**
     * @param \DateTime $dateTime
     * @param \Magento\Framework\UrlInterface $url
     * @param \Internship\BinancePay\Model\Cache\Currency $currency
     */
    public function __construct(
        private readonly \DateTime $dateTime,
        private readonly \Magento\Framework\UrlInterface $url,
        private readonly \Internship\BinancePay\Model\Cache\Currency $currency
    ) {
    }

    /**
     * Map body for order creation.
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function mapOrderBody($quote)
    {
        try {
            $currencies = $this->currency->getCurrencies();

            if (!in_array($quote->getQuoteCurrencyCode(), $currencies)) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Currency is not supported.'));
            }

            return [
                'env' => [
                    'terminalType' => 'WEB'
                ],
                'orderTags' => [
                    'ifProfitSharing' => false

                ],
                'merchantTradeNo' => $this->generateUniqueMerchantTradeNo(),
                'fiatAmount' => $quote->getGrandTotal(),
                'fiatCurrency' => $quote->getQuoteCurrencyCode(),
                'description' => $this->getQuoteItemsDescription($quote->getItems()),
                'goodsDetails' => $this->generateGoods($quote->getItems()),
                'returnUrl' => $this->getReturnUrl() . '?quoteId=' . $quote->getId()
            ];
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }

    /**
     * Generates a description for the order based on the quote items.
     *
     * @param \Magento\Quote\Model\Quote\Item[] $items
     * @return string
     */
    private function getQuoteItemsDescription($items)
    {
        $productNames = array_map(static fn($item) => $item->getName(), $items);

        return strlen($description = implode(', ', $productNames)) > 256
            ? substr($description, 0, 253) . '...'
            : $description;
    }

    /**
     * Map body for order refund.
     *
     * @param array $transactionDetails
     * @return array
     */
    public function mapRefundBody($transactionDetails)
    {
        return [
            "refundRequestId" => $this->generateUniqueMerchantTradeNo(),
            "prepayId" => $transactionDetails['biz_id'],
            "refundAmount" => $transactionDetails['instruction_amount'],
            "refundReason" => ""
        ];
    }

    /**
     * Generates an array of goods for the order based on the quote items.
     *
     * @param array $quoteItems
     * @return array
     */
    private function generateGoods($quoteItems)
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

    /**
     * Generates a unique merchant trade number.
     *
     * @return string
     */
    private function generateUniqueMerchantTradeNo()
    {
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        return $this->dateTime->format('YmdHis') . $randomString;
    }

    /**
     * Retrieves the return URL for the BinancePay checkout success page.
     *
     * @return string
     */
    private function getReturnUrl()
    {
        return rtrim($this->url->getUrl('binancepay/checkout/success'), '/');
    }
}
