<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Grid;

use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Collection as
    AdditionalDescriptionCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

class Collection extends AdditionalDescriptionCollection
{

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface        $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface       $eventManager
     * @param AdapterInterface|null  $connection
     * @param AbstractDb|null        $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Initialize select.
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
     * Join fields to entity.
     *
     * @return Collection
     */
    protected function _joinFields(): Collection
    {
        $productTable = $this->_resource->getTable('catalog_product_entity');

        $this->getSelect()
             ->join(
                 ['cpe' => $productTable],
                 'main_table.product_id = cpe.entity_id',
                 ['main_table.id', 'main_table.additional_description', 'main_table.customer_email', 'cpe.sku']
             );

        return $this;
    }

    /**
     * Add product filter.
     *
     * @param int $productId
     *
     * @return Collection
     */
    public function addProductFilter($productId): Collection
    {
        $this->getSelect()->where('main_table.product_id = ?', $productId);

        return $this;
    }
}
