<?php

namespace Internship\BinancePay\Model;

use Examples\FirstModule\Api\Data\PostInterface;
use Examples\FirstModule\Api\Data\PostInterfaceFactory;
use Examples\FirstModule\Api\Data\PostSearchResultsInterface;
use Examples\FirstModule\Api\Data\PostSearchResultsInterfaceFactory;
use Examples\FirstModule\Model\ResourceModel\Post as ResourcePost;
use Examples\FirstModule\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
/**
 * Post repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BinancePayRepository implements \Internship\BinancePay\Api\BinancePayRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourcePost
     */
    private $resource;
    /**
     * @var PostCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var PostInterfaceFactory
     */
    private $postInterfaceFactory;
    /**
     * @var PostSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @param ResourcePost $resource
     * @param PostFactory $postFactory
     * @param PostInterfaceFactory $postInterfaceFactory
     * @param PostCollectionFactory $collectionFactory
     * @param PostSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePost                      $resource,
        PostFactory                       $postFactory,
        PostInterfaceFactory              $postInterfaceFactory,
        PostCollectionFactory             $collectionFactory,
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->postInterfaceFactory = $postInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }
    /**
     * @param int $postId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $postId): bool
    {
        return $this->delete($this->getById($postId));
    }
    /**
     * @param PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post): bool
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the post: %1', $exception->getMessage())
            );
        }
        return true;
    }
    /**
     * @param int $postId
     * @return PostInterface
     */
    public function getById(int $postId): PostInterface
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $postId));
        }
        return $post;
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->resource->save($post);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', __('Something went wrong while saving the post.')),
                $exception
            );
        }
        return $post;
    }
}
