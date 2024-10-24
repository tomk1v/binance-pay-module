<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

namespace Test\Unit\Service;

class BinancePayTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\HTTP\Client\CurlFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private $curlFactoryMock;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl|\PHPUnit\Framework\MockObject\MockObject
     */
    private $curlMock;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json|\PHPUnit\Framework\MockObject\MockObject
     */
    private $jsonSerializerMock;

    /**
     * @var \Magento\Framework\Url\DecoderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $decoderMock;

    /**
     * @var \Internship\BinancePay\Helper\Adminhtml\Config|\PHPUnit\Framework\MockObject\MockObject
     */
    private $adminConfigMock;

    /**
     * @var \Internship\BinancePay\Service\BinancePay
     */
    private $binancePay;

    protected function setUp(): void
    {
        $this->curlFactoryMock = $this->createMock(\Magento\Framework\HTTP\Client\CurlFactory::class);
        $this->curlMock = $this->createMock(\Magento\Framework\HTTP\Client\Curl::class);
        $this->jsonSerializerMock = $this->createMock(\Magento\Framework\Serialize\Serializer\Json::class);
        $this->decoderMock = $this->createMock(\Magento\Framework\Url\DecoderInterface::class);
        $this->adminConfigMock = $this->createMock(\Internship\BinancePay\Helper\Adminhtml\Config::class);

        $this->curlFactoryMock->expects($this->any())
            ->method('create')
            ->willReturn($this->curlMock);

        $this->adminConfigMock->expects($this->any())
            ->method('getApiKey')
            ->willReturn('testApiKey');

        $this->adminConfigMock->expects($this->any())
            ->method('getSecretKey')
            ->willReturn('testSecretKey');

        $this->binancePay = new \Internship\BinancePay\Service\BinancePay(
            $this->adminConfigMock,
            $this->curlFactoryMock,
            $this->decoderMock,
            $this->jsonSerializerMock
        );
    }

    public function testBuildOrderSuccess()
    {
        $body = '{"amount": 100}';
        $response = ['status' => 'success'];

        $this->curlMock->expects($this->once())
            ->method('setHeaders')
            ->with($this->isType('array'));

        $this->curlMock->expects($this->once())
            ->method('post')
            ->with(\Internship\BinancePay\Service\BinancePay::BASE_URL .
                \Internship\BinancePay\Service\BinancePay::BUILD_ORDER_ENDPOINT, $body);

        $this->curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode($response));

        $this->jsonSerializerMock->expects($this->once())
            ->method('unserialize')
            ->with(json_encode($response))
            ->willReturn($response);

        $result = $this->binancePay->buildOrder($body);

        $this->assertEquals($response, $result);
    }

    public function testBuildRefundSuccess()
    {
        $body = '{"refund": 50}';
        $response = ['status' => 'success'];

        $this->curlMock->expects($this->once())
            ->method('setHeaders')
            ->with($this->isType('array'));

        $this->curlMock->expects($this->once())
            ->method('post')
            ->with(\Internship\BinancePay\Service\BinancePay::BASE_URL .
                \Internship\BinancePay\Service\BinancePay::BUILD_REFUND_ENDPOINT, $body);

        $this->curlMock->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode($response));

        $this->jsonSerializerMock->expects($this->once())
            ->method('unserialize')
            ->with(json_encode($response))
            ->willReturn($response);

        $result = $this->binancePay->buildRefund($body);

        $this->assertEquals($response, $result);
    }

    public function testSendRequestException()
    {
        $this->curlMock->expects($this->once())
            ->method('setHeaders')
            ->with($this->isType('array'));

        $this->curlMock->expects($this->once())
            ->method('post')
            ->willThrowException(new \Exception('Request error'));

        $this->expectException(\Magento\Framework\Exception\LocalizedException::class);
        $this->expectExceptionMessage('Request failed: Request error');

        $this->binancePay->buildOrder('{"amount": 100}');
    }
}
