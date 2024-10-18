<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

namespace Internship\BinancePay\Model;

use Internship\BinancePay\Api\Data\OrderRefundSearchResultInterfaceFactory;
use Internship\BinancePay\Model\ResourceModel\OrderRefund\CollectionFactory;

class OrderRefundRepository implements \Internship\BinancePay\Api\OrderRefundRepositoryInterface
{
    /**
     * @param ResourceModel\OrderRefund $resource
     * @param ResourceModel\OrderRefundFactory $orderRefundFactory
     * @param ResourceModel\OrderRefund\CollectionFactory $orderRefundCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param OrderRefundSearchResultInterfaceFactory $orderRefundSearchResultFactory
     */
    public function __construct(
        private readonly \Internship\BinancePay\Model\ResourceModel\OrderRefund $resource,
        private readonly \Internship\BinancePay\Model\ResourceModel\OrderRefundFactory $orderRefundFactory,
        private readonly CollectionFactory $orderRefundCollectionFactory,
        private readonly \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        private readonly OrderRefundSearchResultInterfaceFactory $orderRefundSearchResultFactory
    ) {
    }

    /**
     * Delete entity by id.
     *
     * @param int $orderRefundId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException|\Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $orderRefundId): bool
    {
        return $this->delete($this->getById($orderRefundId));
    }

    /**
     * Delete by entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund): bool
    {
        try {
            $this->resource->delete($orderRefund);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __('Could not delete the Binance Pay refund: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Get entity by id.
     *
     * @param int $orderRefundId
     * @return ResourceModel\OrderRefund
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $orderRefundId): ResourceModel\OrderRefund
    {
        $orderRefund = $this->orderRefundFactory->create();
        $this->resource->load($orderRefund, $orderRefundId);

        if (!$orderRefund->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The Binance Pay refund with the "%1" ID doesn\'t exist.', $orderRefundId)
            );
        }

        return $orderRefund;
    }

    /**
     * Get list of binance pay refund.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->orderRefundCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->orderRefundSearchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Save binance pay refund entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund
     * @return \Internship\BinancePay\Api\Data\OrderRefundInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Internship\BinancePay\Api\Data\OrderRefundInterface $orderRefund)
    {
        try {
            $this->resource->save($orderRefund);
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the Binance Pay refund: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the Binance Pay refund: %1', __('Something went wrong while saving the post.')),
                $exception
            );
        }
        return $orderRefund;
    }
}
