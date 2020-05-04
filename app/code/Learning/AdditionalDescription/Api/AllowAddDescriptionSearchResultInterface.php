<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface AllowAddDescriptionSearchResultInterface extends SearchResultsInterface
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
