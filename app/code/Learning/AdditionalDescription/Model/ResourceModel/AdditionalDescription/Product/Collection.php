<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Product;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

//@TODO Remove if not needed.
class Collection extends ProductCollection
{
    /**
     * Initialize select
     *
     * @return Collection
     */
    protected function _initSelect(): Collection
    {
        parent::_initSelect();
        $this->_joinFields();

        return $this;
    }


    /**
     * Join fields to entity
     *
     * @return Collection
     */
    protected function _joinFields(): Collection
    {
        $reviewTable = $this->_resource->getTableName(AdditionalDescription::MAIN_TABLE);

        $this->addAttributeToSelect('name')->addAttributeToSelect('sku');

        $this->getSelect()->join(
            ['ad' => $reviewTable],
            'ad.product_id = e.entity_id',
            ['ad.id', 'ad.additional_description', 'ad.customer_email']
        );

        return $this;
    }

    /**
     * Add entity filter
     *
     * @param int $entityId
     *
     * @return Collection
     */
    public function addEntityFilter($entityId)
    {
        $this->addFieldToFilter('entity_id', ['eq' => $entityId]);

        return $this;
    }
}
