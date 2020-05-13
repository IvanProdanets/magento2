<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription as AdditionalDescriptionResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Resource initialization.
     */
    public function _construct()
    {
        $this->_init(AdditionalDescription::class, AdditionalDescriptionResource::class);
    }

    /**
     * Add Product id filter.
     *
     * @param int $productId
     * @return $this
     */
    public function addProductFilter(int $productId): Collection
    {
        $this->addFieldToFilter(AdditionalDescriptionInterface::PRODUCT_ID, ['eq' => $productId]);

        return $this;
    }
}
