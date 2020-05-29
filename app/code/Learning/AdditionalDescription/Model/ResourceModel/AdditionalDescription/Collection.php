<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription;

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription as AdditionalDescriptionResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Additional description collection.
 */
class Collection extends AbstractCollection
{
    /**
     * Resource initialization.
     */
    public function _construct(): void
    {
        $this->_init(AdditionalDescription::class, AdditionalDescriptionResource::class);
    }
}
