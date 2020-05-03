<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\SearchResults;

use Magento\Framework\Api\SearchResultsInterface;

interface AdditionalDescriptionInterface extends SearchResultsInterface
{
    /**
     * Get AdditionalDescription list.
     *
     * @return AdditionalDescriptionInterface[]
     */
    public function getItems();

    /**
     * Set AllowAddDescriptionInterface list.
     *
     * @param AdditionalDescriptionInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
