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
        protected \Magento\Quote\Api\CartManagementInterface $cartManagement,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        protected \Magento\Quote\Model\ResourceModel\Quote\Payment\CollectionFactory $quotePaymentCollectionFactory,
        protected \Magento\Framework\MessageQueue\PublisherInterface $publisher,
        protected \Internship\BinancePay\Model\OrderCreationPublisher $orderCreationPublisher
    ){
    }

    /**
     * Execute controller action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $body = $this->request->getContent();
        $response = json_decode($body, true);

        if (isset($response['bizStatus']) && $response['bizStatus'] === 'PAY_SUCCESS') {
            try {
//                $this->publisher->publish('binance_order_creation', $response);
                $this->orderCreationPublisher->publish('test');
                return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'Order processing started']);
            } catch (\Exception $e) {
                return $resultJson->setData(['returnCode' => 'ERROR', "returnMessage" => $e->getMessage()]);
            }
        }

        return $resultJson->setData(['returnCode' => 'SUCCESS', "returnMessage" => 'No action taken']);
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
