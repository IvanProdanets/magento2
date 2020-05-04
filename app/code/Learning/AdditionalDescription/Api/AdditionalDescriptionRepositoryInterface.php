<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AdditionalDescriptionRepositoryInterface
{
    /**
     * Create or update AdditionalDescription.
     *
     * @param AdditionalDescriptionInterface $additionalDescription
     *
     * @return AdditionalDescriptionInterface
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function save(
        AdditionalDescriptionInterface $additionalDescription
    ): AdditionalDescriptionInterface;

    /**
     * Retrieve AdditionalDescription by id.
     *
     * @param int $id
     * @return AdditionalDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): AdditionalDescriptionInterface;

    /**
     * Retrieve AdditionalDescription which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return AdditionalDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): AdditionalDescriptionSearchResultInterface;

    /**
     * Delete AdditionalDescription.
     *
     * @param AdditionalDescriptionInterface $additionalDescription
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AdditionalDescriptionInterface $additionalDescription): bool;

    /**
     * Delete AdditionalDescription by id.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool;
}
