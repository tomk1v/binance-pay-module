<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api;

interface OrderRefundRepositoryInterface
{
    /**
     * Get entity by id.
     *
     * @param int $orderRefundId
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface
     */
    public function getById(int $orderRefundId);

    /**
     * Get list of binance pay refund.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Save binance pay refund entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface
     */
    public function save(\Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund);

    /**
     * Delete by entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund
     * @return bool
     */
    public function delete(\Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund);

    /**
     * Delete entity by id.
     *
     * @param int $orderRefundId
     * @return bool
     */
    public function deleteById(int $orderRefundId);
}
