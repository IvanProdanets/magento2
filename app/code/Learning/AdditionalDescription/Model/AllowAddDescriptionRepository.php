<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\AllowAddDescriptionSearchResultInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\AllowAddDescriptionSearchResultInterfaceFactory as
    SearchResultInterfaceFactory;
use Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription as ResourceModel;
use Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription\CollectionFactory;
use Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription\Collection;
use Magento\CatalogGraphQl\Model\Resolver\Products\DataProvider\Product\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class AllowAddDescriptionRepository implements AllowAddDescriptionRepositoryInterface
{
    /** @var AllowAddDescriptionFactory */
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
     * AllowAddDescriptionRepository constructor.
     *
     * @param AllowAddDescriptionFactory    $modelFactory
     * @param ResourceModel                 $resource
     * @param CollectionFactory             $collectionFactory
     * @param SearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface  $collectionProcessor
     */
    public function __construct(
        AllowAddDescriptionFactory $modelFactory,
        ResourceModel $resource,
        CollectionFactory $collectionFactory,
        SearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Create or update AllowAddDescription.
     *
     * @param AllowAddDescriptionInterface $allowAddDescription
     *
     * @return AllowAddDescriptionInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(AllowAddDescriptionInterface $allowAddDescription): AllowAddDescriptionInterface
    {
        try {
            $this->resource->save($allowAddDescription);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save customer allow add description: %1', $exception->getMessage()),
                $exception
            );
        }

        return $this->getById($allowAddDescription->getPermissionId());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): AllowAddDescriptionInterface
    {
        $allowAddDescription = $this->modelFactory->create();
        $this->resource->load($allowAddDescription, $id);
        if (!$allowAddDescription->getId()) {
            throw new NoSuchEntityException(
                __('Unable to find customer allow add description with ID "%1"', $id)
            );
        }

        return $allowAddDescription;
    }

    /**
     * Retrieve AllowAddDescription which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return AllowAddDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): AllowAddDescriptionSearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var AllowAddDescriptionSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete AllowAddDescription.
     *
     * @param AllowAddDescriptionInterface $allowAddDescription
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AllowAddDescriptionInterface $allowAddDescription): bool
    {
        try {
            $this->resource->delete($allowAddDescription);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete customer allow add description: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete AllowAddDescription by id.
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
