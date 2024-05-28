<?php

namespace Internship\BinancePay\Model;

class OrderCreationConsumer
{
    protected $orderFactory;
    protected $checkoutSession;
    protected $customerRepository;
    protected $cartRepository;
    protected $cartManagement;
    protected $searchCriteriaBuilder;
    protected $quotePaymentCollectionFactory;

    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        \Magento\Quote\Api\CartManagementInterface $cartManagement,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory $quotePaymentCollectionFactory
    ) {
        $this->orderFactory = $orderFactory;
        $this->checkoutSession = $checkoutSession;
        $this->customerRepository = $customerRepository;
        $this->cartRepository = $cartRepository;
        $this->cartManagement = $cartManagement;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->quotePaymentCollectionFactory = $quotePaymentCollectionFactory;
    }

    public function processMessage($message)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('text message');
//        $paymentData = json_decode($message->getBody(), true);
//        $this->createOrder($paymentData);
    }

    protected function createOrder(array $paymentData)
    {
        $payment = $this->quotePaymentCollectionFactory->create()
            ->addFieldToFilter('binance_prepay_id', $paymentData['bizIdStr'])
            ->getFirstItem();

        if ($payment) {
            $quote = $this->cartRepository->getActive($payment->getQuoteId());
            $orderId = $this->cartManagement->placeOrder($quote->getId());

            if (!$orderId) {
                throw new \Exception('Order could not be created');
            }
        }
    }
}
