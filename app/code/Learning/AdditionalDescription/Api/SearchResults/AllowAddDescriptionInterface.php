<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\SearchResults;

use Magento\Framework\Api\SearchResultsInterface;

interface AllowAddDescriptionInterface extends SearchResultsInterface
{
    /**
     * Get AllowAddDescription list.
     *
     * @return AllowAddDescriptionInterface[]
     */
    public function getItems();

    /**
     * Set AllowAddDescriptionInterface list.
     *
     * @param AllowAddDescriptionInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
