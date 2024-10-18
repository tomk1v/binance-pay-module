<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api;

interface OrderPaymentRepositoryInterface
{
    /**
     * Get entity by id.
     *
     * @param int $orderPaymentId
     * @return \Internship\BinancePay\Api\Data\OrderPaymentInterface
     */
    public function getById(int $orderPaymentId);

    /**
     * List of binance pay payments.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Internship\BinancePay\Api\Data\OrderPaymentInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Save binance pay payment.
     *
     * @param \Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment
     * @return \Internship\BinancePay\Api\Data\OrderPaymentInterface
     */
    public function save(\Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment);

    /**
     * Delete entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment
     * @return bool
     */
    public function delete(\Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment);

    /**
     * Delete entity by id.
     *
     * @param int $orderPaymentId
     * @return bool
     */
    public function deleteById(int $orderPaymentId);
}
