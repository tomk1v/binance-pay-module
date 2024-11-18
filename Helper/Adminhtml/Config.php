<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Helper\Adminhtml;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Get module status.
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
     * Get api key.
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
     * Get secret key.
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->scopeConfig->getValue(
            'payment/binancepay/secret_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get crypto symbol.
     *
     * @return string
     */
    public function getCryptoSymbol()
    {
        return $this->scopeConfig->getValue(
            'payment/binancepay/crypto_symbol',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
