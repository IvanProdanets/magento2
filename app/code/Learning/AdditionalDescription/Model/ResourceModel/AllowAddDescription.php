<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Allow add description resource model.
 */
class AllowAddDescription extends AbstractDb
{
    const MAIN_TABLE = 'customer_allow_add_description';
    const ID_FIELD_NAME = 'id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
