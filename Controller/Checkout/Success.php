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
    private const SUCCESS_ROUTE = 'checkout/onepage/success';
    private const CART_ROUTE = 'checkout/cart/index';

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private readonly \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        private readonly \Magento\Framework\App\RequestInterface $request,
        private readonly \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        private readonly \Magento\Checkout\Model\Session $checkoutSession,
        private readonly \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    /**
     * Redirection to success page.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        try {
            $quoteId = $this->request->getParam('quoteId');
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('quote_id', $quoteId)->create();
            $order = $this->orderRepository->getList($searchCriteria)->getFirstItem();

            if ($order->getId()) {
                $this->checkoutSession->clearQuote();
                $this->checkoutSession->setLastOrderId($order->getId());
                $this->checkoutSession->setLastRealOrderId($order->getIncrementId());
                $this->checkoutSession->setLastSuccessQuoteId($order->getQuoteId());
                $this->checkoutSession->setLastQuoteId($order->getQuoteId());

                return $this->resultRedirectFactory->create()->setPath(self::SUCCESS_ROUTE);
            }

            return $this->resultRedirectFactory->create()->setPath(self::CART_ROUTE);
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            throw new \Magento\Framework\Exception\LocalizedException(__($exception->getMessage()));
        }
    }
}
