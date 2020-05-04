<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface AllowAddDescriptionRepositoryInterface
{
    /**
     * Create or update AllowAddDescription.
     *
     * @param AllowAddDescriptionInterface $allowAddDescription
     *
     * @return AllowAddDescriptionInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(
        AllowAddDescriptionInterface $allowAddDescription
    ): AllowAddDescriptionInterface;

    /**
     * Retrieve AllowAddDescription by id.
     *
     * @param int $id
     * @return AllowAddDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): AllowAddDescriptionInterface;

    /**
     * Retrieve AllowAddDescription which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return AllowAddDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): AllowAddDescriptionSearchResultInterface;

    /**
     * Delete AllowAddDescription.
     *
     * @param AllowAddDescriptionInterface $allowAddDescription
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AllowAddDescriptionInterface $allowAddDescription): bool;

    /**
     * Delete AllowAddDescription by id.
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}
