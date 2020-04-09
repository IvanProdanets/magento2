<?php
namespace Learning\Blog\Model;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Api\Data\BlogSearchResultInterface;
use Learning\Blog\Api\Data\BlogSearchResultInterfaceFactory;
use Learning\Blog\Model\ResourceModel\Blog as BlogResource;
use Learning\Blog\Model\ResourceModel\Blog\Collection;
use Learning\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Blog entity repository interface implementation.
 */
class BlogRepository implements BlogRepositoryInterface
{
    /**
     * @var BlogFactory
     */
    private $blogFactory;

    /**
     * @var BlogResource
     */
    private $resource;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var BlogCollectionFactory
     */
    private $blogCollectionFactory;

    /**
     * @var BlogSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * BlogRepository constructor.
     * @param BlogFactory $blogFactory
     * @param BlogResource $blogResource
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param BlogSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        BlogFactory $blogFactory,
        BlogResource $blogResource,
        BlogCollectionFactory $blogCollectionFactory,
        BlogSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->blogFactory           = $blogFactory;
        $this->resource              = $blogResource;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultFactory   = $searchResultFactory;
        $this->collectionProcessor   = $collectionProcessor;
    }

    /**
     * Create or update blog.
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(BlogInterface $blog): BlogInterface
    {
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save blog: %1', $exception->getMessage()),
                $exception
            );
        }

        return $this->getById($blog->getBlogId());
    }

    /**
     * Retrieve blog by id.
     *
     * @param int $id
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): BlogInterface
    {
        $blog = $this->blogFactory->create();
        $this->resource->load($blog, $id);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(
                __('Unable to find blog with ID "%1"', $id)
            );
        }

        return $blog;
    }

    /**
     * Retrieve blogs which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return BlogSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): BlogSearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->blogCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var BlogSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete blog.
     *
     * @param BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog): bool
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the blog: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete blog by id.
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
