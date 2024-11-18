<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Block;

class CryptoPrice extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Internship\BinancePay\Helper\Adminhtml\Config $adminhtmlConfig
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        private readonly \Internship\BinancePay\Helper\Adminhtml\Config $adminhtmlConfig,
        private readonly \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @var \Magento\Catalog\Model\Product|null
     */
    private ?\Magento\Catalog\Model\Product $product = null;

    /**
     * Set the product for this block.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return $this
     */
    public function setProduct(\Magento\Catalog\Model\Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get the product object.
     *
     * @return \Magento\Catalog\Model\Product|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProduct(): ?\Magento\Catalog\Model\Product
    {
        if ($this->product) {
            return $this->product;
        }

        return $this->getData('product') ?: $this->getLayout()->getBlock('product.info')->getProduct();
    }

    /**
     * Get crypto html.
     *
     * @return string
     */
    public function getCryptoPriceHtml()
    {
        return "Crypto Price: Loading...";
    }

    /**
     * Get product final price.
     *
     * @return float
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAmount()
    {
        return $this->getProduct()->getFinalPrice();
    }

    /**
     * Get crypto symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->adminhtmlConfig->getCryptoSymbol();
    }

    /**
     * Get current currency.
     *
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreCurrency()
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }
}
