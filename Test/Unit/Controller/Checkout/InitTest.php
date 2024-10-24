<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Test\Unit\Controller\Checkout;

class InitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $jsonFactory;

    /**
     * @var \Magento\Checkout\Model\Session|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $checkoutSession;

    /**
     * @var \Magento\Quote\Api\PaymentMethodManagementInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $paymentMethodManagement;

    /**
     * @var \Internship\BinancePay\Service\BinancePay|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $binancePayService;

    /**
     * @var \Internship\BinancePay\Model\Payment\Mapping|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $mapping;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private \PHPUnit\Framework\MockObject\MockObject $serializer;

    /**
     * @var \Internship\BinancePay\Controller\Checkout\Init
     */
    private \Internship\BinancePay\Controller\Checkout\Init $controller;

    protected function setUp(): void
    {
        $this->jsonFactory = $this->createMock(\Magento\Framework\Controller\Result\JsonFactory::class);
        $this->checkoutSession = $this->createMock(\Magento\Checkout\Model\Session::class);
        $this->paymentMethodManagement = $this->createMock(\Magento\Quote\Api\PaymentMethodManagementInterface::class);
        $this->binancePayService = $this->createMock(\Internship\BinancePay\Service\BinancePay::class);
        $this->mapping = $this->createMock(\Internship\BinancePay\Model\Payment\Mapping::class);
        $this->serializer = $this->createMock(\Magento\Framework\Serialize\SerializerInterface::class);

        $this->controller = new \Internship\BinancePay\Controller\Checkout\Init(
            $this->jsonFactory,
            $this->checkoutSession,
            $this->paymentMethodManagement,
            $this->binancePayService,
            $this->mapping,
            $this->serializer
        );
    }

    public function testExecuteSuccess()
    {
        $quoteId = 1;
        $grandTotal = 100.0;
        $returnUrl = 'https://example.com/return';
        $prepayId = '123456789';
        $checkoutUrl = 'https://binancepay.com/checkout';
        $mappedOrderBody = [
            'env' => [
                'terminalType' => 'WEB'
            ],
            'orderTags' => [
                'ifProfitSharing' => false
            ],
            'merchantTradeNo' => 'unique_merchant_trade_no',
            'orderAmount' => $grandTotal,
            'currency' => 'USDT',
            'description' => 'Test description',
            'goodsDetails' => [],
            'returnUrl' => $returnUrl . '?quoteId=' . $quoteId
        ];

        $serializedBody = json_encode($mappedOrderBody);
        $response = ['status' => 'SUCCESS', 'data' => ['prepayId' => $prepayId, 'checkoutUrl' => $checkoutUrl]];

        $quoteMock = $this->createMock(\Magento\Quote\Model\Quote::class);
        $paymentMethodMock = $this->createMock(\Magento\Quote\Model\Quote\Payment::class);
        $resultJsonMock = $this->createMock(\Magento\Framework\Controller\Result\Json::class);

        $this->checkoutSession->method('getQuote')->willReturn($quoteMock);
        $quoteMock->method('getId')->willReturn($quoteId);
        $this->mapping->method('mapOrderBody')->with($quoteMock)->willReturn($mappedOrderBody);
        $this->serializer->method('serialize')->with($mappedOrderBody)->willReturn($serializedBody);
        $this->binancePayService->method('buildOrder')->with($serializedBody)->willReturn($response);
        $this->paymentMethodManagement->method('get')->with($quoteId)->willReturn($paymentMethodMock);
        $paymentMethodMock->expects($this->once())->method('setData')
            ->with('binance_prepay_id', $prepayId)->willReturnSelf();
        $paymentMethodMock->expects($this->once())->method('save');
        $this->jsonFactory->method('create')->willReturn($resultJsonMock);
        $resultJsonMock->expects($this->once())->method('setData')
            ->with(['success' => true, 'checkoutUrl' => $checkoutUrl]);

        $result = $this->controller->execute();
        $this->assertSame($resultJsonMock, $result);
    }

    public function testExecuteFailure()
    {
        $quoteId = 1;
        $grandTotal = 100.0;
        $returnUrl = 'https://example.com/return';

        $mappedOrderBody = [
            'env' => [
                 'terminalType' => 'WEB'
            ],
            'orderTags' => [
                'ifProfitSharing' => false
            ],
            'merchantTradeNo' => 'unique_merchant_trade_no',
            'orderAmount' => $grandTotal,
            'currency' => 'USDT',
            'description' => 'Test description',
            'goodsDetails' => [],
            'returnUrl' => $returnUrl . '?quoteId=' . $quoteId
        ];

        $serializedBody = json_encode($mappedOrderBody);
        $response = ['status' => 'FAIL'];

        $quoteMock = $this->createMock(\Magento\Quote\Model\Quote::class);
        $resultJsonMock = $this->createMock(\Magento\Framework\Controller\Result\Json::class);

        $this->checkoutSession->method('getQuote')->willReturn($quoteMock);
        $quoteMock->method('getId')->willReturn($quoteId);
        $this->mapping->method('mapOrderBody')->with($quoteMock)->willReturn($mappedOrderBody);
        $this->serializer->method('serialize')->with($mappedOrderBody)->willReturn($serializedBody);
        $this->binancePayService->method('buildOrder')->with($serializedBody)->willReturn($response);
        $this->jsonFactory->method('create')->willReturn($resultJsonMock);

        $result = $this->controller->execute();
        $this->assertSame($resultJsonMock, $result);
        $resultJsonMock->expects($this->never())->method('setData')->with(['success' => true]);
    }

    public function testExecuteExceptionHandling()
    {
        $this->checkoutSession->method('getQuote')->willThrowException(new \Exception('An error occurred'));

        $this->expectException(\Magento\Framework\Exception\LocalizedException::class);
        $this->expectExceptionMessage('An error occurred');

        $this->controller->execute();
    }
}
