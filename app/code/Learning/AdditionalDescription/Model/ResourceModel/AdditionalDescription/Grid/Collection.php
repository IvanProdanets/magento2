<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Grid;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Collection as
    AdditionalDescriptionCollection;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

class Collection extends AdditionalDescriptionCollection
{
    /** @var Config */
    private $eavConfig;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Config $eavConfig,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->eavConfig = $eavConfig;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Initialize select.
     *
     * @return Collection
     * @throws LocalizedException
     */
    protected function _initSelect(): Collection
    {
        parent::_initSelect();
        $this->_joinFields();

        return $this;
    }

    /**
     * Join fields to entity.
     *
     * @return Collection
     */
    protected function _joinFields(): Collection
    {
        $prodNameAttrId = $this->eavConfig->getAttribute(Product::ENTITY, ProductInterface::NAME)
                                          ->getAttributeId();
        $productTable = $this->_resource->getTable('catalog_product_entity');
        $productVarCharTable = $this->_resource->getTable('catalog_product_entity_varchar');

        $this->getSelect()
             ->join(
                 ['cpe' => $productTable],
                 'main_table.product_id = cpe.entity_id',
                 ['main_table.id', 'main_table.additional_description', 'main_table.customer_email', 'cpe.sku']
             )
            ->join(
                ['cpev' => $productVarCharTable],
                'cpev.entity_id = cpe.entity_id AND cpev.attribute_id=' . $prodNameAttrId,
                ['name' => 'cpev.value']
            );

        return $this;
    }
    /**
     * Add entity filter
     *
     * @param int $productId
     *
     * @return Collection
     */
    public function addProductFilter($productId): Collection
    {
        $this->addFieldToFilter(AdditionalDescriptionInterface::PRODUCT_ID, ['eq' => $productId]);

        return $this;
    }
}
