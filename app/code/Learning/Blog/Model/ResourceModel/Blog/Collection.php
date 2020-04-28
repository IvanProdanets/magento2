<?php
namespace Learning\Blog\Model\ResourceModel\Blog;

use Learning\Blog\Model\Blog;
use Learning\Blog\Model\ResourceModel\Blog as BlogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Resource initialization.
     */
    public function _construct()
    {
        $this->_init(Blog::class, BlogResourceModel::class);
    }
}
