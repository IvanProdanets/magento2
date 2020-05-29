<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * Additional description search result interface.
 */
interface AdditionalDescriptionSearchResultInterface extends SearchResultsInterface
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
