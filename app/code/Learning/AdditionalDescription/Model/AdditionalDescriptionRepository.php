<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Api\AdditionalDescriptionSearchResultInterfaceFactory as SearchResultInterfaceFactory;
use Learning\AdditionalDescription\Api\AdditionalDescriptionSearchResultInterface;
use Learning\AdditionalDescription\Model\AdditionalDescriptionFactory;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription as ResourceModel;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\CollectionFactory;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class AdditionalDescriptionRepository implements AdditionalDescriptionRepositoryInterface
{
    /** @var AdditionalDescriptionFactory */
    private $modelFactory;

    /** @var ResourceModel */
    private $resource;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var SearchResultInterfaceFactory */
    private $searchResultFactory;

    /**
     * AdditionalDescriptionRepository constructor.
     *
     * @param AdditionalDescriptionFactory  $model
     * @param ResourceModel                 $resource
     * @param CollectionFactory             $collection
     * @param SearchResultInterfaceFactory $searchResult
     * @param CollectionProcessorInterface  $collectionProcessor
     */
    public function __construct(
        AdditionalDescriptionFactory $model,
        ResourceModel $resource,
        CollectionFactory $collection,
        SearchResultInterfaceFactory $searchResult,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->modelFactory        = $model;
        $this->resource            = $resource;
        $this->collectionFactory   = $collection;
        $this->searchResultFactory = $searchResult;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Create or update AdditionalDescription.
     *
     * @param AdditionalDescriptionInterface $additionalDescription
     *
     * @return AdditionalDescriptionInterface
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function save(AdditionalDescriptionInterface $additionalDescription): AdditionalDescriptionInterface
    {
        try {
            $this->resource->save($additionalDescription);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save product additional description: %1', $exception->getMessage()),
                $exception
            );
        }

        return $this->getById($additionalDescription->getAdditionalDescriptionId());
    }

    /**
     * Retrieve AdditionalDescription by id.
     *
     * @param int $id
     * @return AdditionalDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): AdditionalDescriptionInterface
    {
        $additionalDescription = $this->modelFactory->create();
        $this->resource->load($additionalDescription, $id);
        if (!$additionalDescription->getId()) {
            throw new NoSuchEntityException(
                __('Unable to find product additional description with ID "%1"', $id)
            );
        }

        return $additionalDescription;
    }

    /**
     * Retrieve AdditionalDescription which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return AdditionalDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): AdditionalDescriptionSearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var AdditionalDescriptionSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete AdditionalDescription.
     *
     * @param AdditionalDescriptionInterface $additionalDescription
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AdditionalDescriptionInterface $additionalDescription): bool
    {
        try {
            $this->resource->delete($additionalDescription);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete product additional description: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete AdditionalDescription by id.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
