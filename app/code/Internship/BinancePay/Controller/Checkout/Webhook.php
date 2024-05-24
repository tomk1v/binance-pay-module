<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Controller\Checkout;

class Webhook implements \Magento\Framework\App\ActionInterface, \Magento\Framework\App\CsrfAwareActionInterface
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
        protected \Internship\BinancePay\Helper\Adminhtml\Config   $adminConfig,
        protected \Magento\Sales\Model\OrderFactory $orderFactory,
        protected \Magento\Checkout\Model\Session $checkoutSession,
        protected \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        protected \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        protected \Magento\Quote\Api\CartManagementInterface $cartManagement
    ){
    }

    /**
     * Execute controller action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        // Get the JSON factory result
        $resultJson = $this->jsonFactory->create();

        // Get the body of the request
        $body = $this->request->getContent();
        $data = json_decode($body, true);

        // Check if the status is PAY_SUCCESS
        if (isset($data['bizStatus']) && $data['bizStatus'] === 'PAY_SUCCESS') {
            // Decode the inner JSON data
            $paymentData = json_decode($data['data'], true);

            try {
                // Create the order based on the payment data
                $this->createOrder($paymentData);
                return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'Order created successfully']);
            } catch (\Exception $e) {
                return $resultJson->setData(['returnCode' => 'ERROR', "returnMessage" => $e->getMessage()]);
            }
        }

        return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
    }

    /**
     * Create an order based on the payment data.
     *
     * @param array $paymentData
     * @throws \Exception
     */
    protected function createOrder(array $paymentData)
    {
        // Assuming $paymentData contains necessary information to create an order
        $quote = $this->cartRepository->getActive($this->checkoutSession->getQuoteId());

        // Set customer to quote if necessary
        $customer = $this->customerRepository->getById($paymentData['openUserId']);
        $quote->assignCustomer($customer);

        // Set payment method
        $quote->getPayment()->setMethod('binancepay');

        // Collect totals & save quote
        $quote->collectTotals()->save();

        // Submit the quote and create the order
        $orderId = $this->cartManagement->placeOrder($quote->getId());

        if (!$orderId) {
            throw new \Exception('Order could not be created');
        }
    }

    public function createCsrfValidationException(\Magento\Framework\App\RequestInterface $request): ? \Magento\Framework\App\Request\InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(\Magento\Framework\App\RequestInterface $request): ?bool
    {
        return true;
    }
}
