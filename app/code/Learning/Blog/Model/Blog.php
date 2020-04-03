<?php
namespace Learning\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Learning\Blog\Model\ResourceModel\Blog as BlogResourceModel;

/**
 * Class Blog
 * @package Learning\Blog\Model
 */
class Blog extends AbstractModel
{
    /**
     * Model initialization.
     */
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}
