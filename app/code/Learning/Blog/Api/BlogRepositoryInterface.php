<?php
namespace Learning\Blog\Api;

use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Api\Data\BlogSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Blog CRUD interface.
 */
interface BlogRepositoryInterface
{
    /**
     * Create or update blog.
     *
     * @param BlogInterface $blog
     * @return BlogInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(BlogInterface $blog): BlogInterface;

    /**
     * Retrieve blog by id.
     *
     * @param int $id
     * @return BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): BlogInterface;

    /**
     * Retrieve blogs which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return BlogSearchResultInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $criteria): BlogSearchResultInterface;

    /**
     * Delete blog.
     *
     * @param BlogInterface $blog
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogInterface $blog): bool;

    /**
     * Delete blog by id.
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}
