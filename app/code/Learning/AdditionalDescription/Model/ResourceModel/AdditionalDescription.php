<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Additional description resource model.
 */
class AdditionalDescription extends AbstractDb
{
    const MAIN_TABLE = 'catalog_product_additional_description';
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
