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
        protected \Magento\Framework\App\Action\Context $context,
        protected \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        protected \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
        protected \Magento\Framework\App\Request\Http $request,
        protected \Internship\BinancePay\Helper\Adminhtml\Config $adminConfig
    ){
    }

    /**
     * Execute controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $quoteData = $this->request->getParam('quoteData');

        $nonce = $this->generateNonce();
        $timestamp = round(microtime(true) * 1000);

        $request = [
            "env" => [
                "terminalType" => "APP"
            ],
            "merchantTradeNo" => mt_rand(982538, 9825382937292),
            "orderAmount" => floatval(0.001),
            "currency" => "USDT",
            "goods" => [
                "goodsType" => "01",
                "goodsCategory" => "D000",
                "referenceGoodsId" => "7876763A3B",
                "goodsName" => "Ice Cream",
                "goodsDetail" => "Greentea ice cream cone"
            ],
            "webhookUrl" => ''
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
        $curl->post("https://bpay.binanceapi.com/binancepay/openapi/v2/order", $json_request);
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
}
