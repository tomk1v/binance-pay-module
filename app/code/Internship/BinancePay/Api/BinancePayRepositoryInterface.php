<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

declare(strict_types=1);

namespace Internship\BinancePay\Api;

interface BinancePayRepositoryInterface
{
    /**
     * @param int $entityId
     * @return \Internship\BinancePay\Api\Data\BinancePayInterface
     */
    public function getById(int $entityId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Internship\BinancePay\Api\Data\BinancePayInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Internship\BinancePay\Api\Data\BinancePayInterface $binancePay
     * @return \Internship\BinancePay\Api\Data\BinancePayInterface
     */
    public function save(\Internship\BinancePay\Api\Data\BinancePayInterface $binancePay);

    /**
     * @param \Internship\BinancePay\Api\Data\BinancePayInterface $binancePay
     * @return bool
     */
    public function delete(\Internship\BinancePay\Api\Data\BinancePayInterface $binancePay);

    /**
     * @param int $entityId
     * @return bool
     */
    public function deleteById(int $entityId);
}
