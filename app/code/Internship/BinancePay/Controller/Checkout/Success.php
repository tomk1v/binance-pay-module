<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Controller\Checkout;

class Success implements \Magento\Framework\App\ActionInterface
{

    public function __construct(
        protected \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        protected \Magento\Framework\App\RequestInterface $request,
        protected \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        protected \Magento\Checkout\Model\Session $checkoutSession,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    /**
     * Execute controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->request->getParams();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('quote_id', $params['quoteId'])->create();
        $order = $this->orderRepository->getList($searchCriteria)->getFirstItem();

        $this->checkoutSession->setLastOrderId($order->getId());
        $this->checkoutSession->setLastRealOrderId($order->getIncrementId());
        $this->checkoutSession->setLastSuccessQuoteId($order->getQuoteId());
        $this->checkoutSession->setLastQuoteId($order->getQuoteId());

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('checkout/onepage/success');
        return $resultRedirect;
    }
}
