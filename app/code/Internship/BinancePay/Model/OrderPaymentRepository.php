<?php
/**
 * @category Internship
 * @package Internship\BinancePay
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 Tomkiv
 */

namespace Internship\BinancePay\Model;

use Internship\BinancePay\Api\Data\OrderPaymentSearchResultInterfaceFactory;
use Internship\BinancePay\Model\ResourceModel\OrderPayment\CollectionFactory;

class OrderPaymentRepository implements \Internship\BinancePay\Api\OrderPaymentRepositoryInterface
{
    /**
     * @param ResourceModel\OrderPayment $resource
     * @param ResourceModel\OrderPaymentFactory $orderPaymentFactory
     * @param ResourceModel\OrderPayment\CollectionFactory $orderPaymentCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param OrderPaymentSearchResultInterfaceFactory $orderPaymentSearchResultFactory
     */
    public function __construct(
        private readonly \Internship\BinancePay\Model\ResourceModel\OrderPayment $resource,
        private readonly \Internship\BinancePay\Model\ResourceModel\OrderPaymentFactory $orderPaymentFactory,
        private readonly CollectionFactory $orderPaymentCollectionFactory,
        private readonly \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        private readonly OrderPaymentSearchResultInterfaceFactory  $orderPaymentSearchResultFactory
    ) {
    }

    /**
     * Delete entity by id.
     *
     * @param int $orderPaymentId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException|\Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $orderPaymentId): bool
    {
        return $this->delete($this->getById($orderPaymentId));
    }

    /**
     * Delete entity.
     *
     * @param \Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment): bool
    {
        try {
            $this->resource->delete($orderPayment);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __('Could not delete the Binance Pay: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Get entity by id.
     *
     * @param int $orderPaymentId
     * @return ResourceModel\OrderPayment
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $orderPaymentId): ResourceModel\OrderPayment
    {
        $orderPayment = $this->orderPaymentFactory->create();
        $this->resource->load($orderPayment, $orderPaymentId);

        if (!$orderPayment->getEntityId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The binancePay with the "%1" ID doesn\'t exist.', $orderPaymentId)
            );
        }

        return $orderPayment;
    }

    /**
     * List of binance pay payments.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Internship\BinancePay\Api\Data\OrderPaymentSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->orderPaymentCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->orderPaymentSearchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Save binance pay payment.
     *
     * @param \Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment
     * @return \Internship\BinancePay\Api\Data\OrderPaymentInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Internship\BinancePay\Api\Data\OrderPaymentInterface $orderPayment)
    {
        try {
            $this->resource->save($orderPayment);
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the binancePay: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the binancePay: %1', __('Something went wrong while saving the post.')),
                $exception
            );
        }
        return $orderPayment;
    }
}
