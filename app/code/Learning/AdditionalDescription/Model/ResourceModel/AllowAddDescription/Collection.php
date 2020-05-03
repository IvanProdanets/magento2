<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription;

use Learning\AdditionalDescription\Model\AllowAddDescription;
use Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription as AllowAddDescriptionResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Resource initialization.
     */
    public function _construct()
    {
        $this->_init(AllowAddDescription::class, AllowAddDescriptionResource::class);
    }
}
