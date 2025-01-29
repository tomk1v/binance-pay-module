<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2025 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api\Data;

interface OrderRefundSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get an item list.
     *
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface[]
     */
    public function getItems();

    /**
     * Set an item list.
     *
     * @param \Internship\BinancePay\Api\Data\OrderRefundInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
