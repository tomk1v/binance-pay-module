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
     * @return bool
     */
    public function execute()
    {
        $quoteData = $this->request->getParams();
        $quoteItems = $this->request->getParam('quoteItems');

        return 'true';
    }
}
