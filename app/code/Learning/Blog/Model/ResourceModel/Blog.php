<?php
namespace Learning\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Index
 */
class Blog extends AbstractDb
{
    const MAIN_TABLE    = 'learning_blog_blog';
    const ID_FIELD_BANE = 'id';

    /**
     * Resource initialization.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_BANE);
    }
}
