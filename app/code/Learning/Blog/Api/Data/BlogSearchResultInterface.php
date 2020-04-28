<?php
namespace Learning\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for blog search results.
 */
interface BlogSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get blogs list.
     *
     * @return BlogInterface[]
     */
    public function getItems();

    /**
     * Set blogs list.
     *
     * @param BlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
