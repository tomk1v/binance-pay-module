<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

namespace Internship\BinancePay\Api\Data;

interface OrderPaymentSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get an item list.
     *
     * @return \Internship\BinancePay\Api\Data\OrderPaymentInterface[]
     */
    public function getItems();

    /**
     * Set an item list.
     *
     * @param \Internship\BinancePay\Api\Data\OrderPaymentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
