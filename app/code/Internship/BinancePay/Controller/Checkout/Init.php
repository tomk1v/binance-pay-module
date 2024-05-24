<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Controller\Checkout;

class Init implements \Magento\Framework\App\ActionInterface
{
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig
     */
    public function __construct(
        protected \Magento\Framework\App\Action\Context            $context,
        protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        protected \Magento\Framework\HTTP\Client\CurlFactory       $curlFactory,
        protected \Magento\Framework\App\Request\Http              $request,
        protected \Internship\BinancePay\Helper\Adminhtml\Config   $adminConfig
    )
    {
    }

    /**
     * Execute controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $quoteData = $this->request->getParam('quoteData');
        $quoteItems = $this->request->getParam('quoteItems');
        $nonce = $this->generateNonce();
        $timestamp = round(microtime(true) * 1000);

        $request = [
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
            'goodsDetails' => $this->generateGoods($quoteItems),
//            'returnUrl' => 'https://2cf0-188-163-32-149.ngrok-free.app/binancepay/checkout/success',
//            'webhookUrl' => 'https://2cf0-188-163-32-149.ngrok-free.app/binancepay/checkout/webhook'
        ];

        $json_request = json_encode($request);
        $payload = $timestamp . "\n" . $nonce . "\n" . $json_request . "\n";

        $signature = strtoupper(hash_hmac('SHA512', $payload, $this->adminConfig->getSecretKey()));
        $headers = [
            "Content-Type" => "application/json",
            "BinancePay-Timestamp" => $timestamp,
            "BinancePay-Nonce" => $nonce,
            "BinancePay-Certificate-SN" => $this->adminConfig->getApiKey(),
            "BinancePay-Signature" => $signature
        ];

        /** @var \Magento\Framework\HTTP\Client\Curl $curl */
        $curl = $this->curlFactory->create();
        $curl->setHeaders($headers);
        $curl->post("https://bpay.binanceapi.com/binancepay/openapi/v3/order", $json_request);
        $result = $curl->getBody();

        $result = json_decode($result, true);

        if ($result['status'] == 'SUCCESS') {
            $result = ['success' => true, 'checkoutUrl' => $result['data']['checkoutUrl']];
        }

        $resultJson = $this->jsonFactory->create();
        $resultJson->setData($result);
        return $resultJson;
    }

    protected function generateNonce($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nonce = '';
        for ($i = 1; $i <= $length; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $char = $chars[$pos];
            $nonce .= $char;
        }
        return $nonce;
    }

    function generateUniqueMerchantTradeNo()
    {
        $datetime = new \DateTime();
        $timestamp = $datetime->format('YmdHis');
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

        $merchantTradeNo = $timestamp . $randomString;

        return $merchantTradeNo;
    }

    function generateGoods($quoteItems)
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
}
