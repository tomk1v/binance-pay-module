<?php

declare(strict_types=1);

namespace Internship\BinancePay\Helper\Adminhtml;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Cookie\Helper\Cookie
     */
    protected $cookieHelper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Cookie\Helper\Cookie $cookieHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cookie\Helper\Cookie $cookieHelper
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->cookieHelper = $cookieHelper;
        parent::__construct($context);
    }

    /**
     * Get module status
     *
     * @return mixed
     */
    public function getModuleStatus()
    {
        return $this->scopeConfig->getValue(
            'payment/binancepay/status',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get api key
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->scopeConfig->getValue(
            'payment/binancepay/api_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get secret key
     *
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->scopeConfig->getValue(
            'payment/binancepay/secret_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
