<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\AdditionalDescription;

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Collection;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * DataProvider constructor.
     *
     * @param                   $name
     * @param                   $primaryFieldName
     * @param                   $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array             $meta
     * @param array             $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data.
     *
     * @return array[]
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var AdditionalDescription $additionalDescription */
        foreach ($items as $additionalDescription) {
            $this->loadedData[$additionalDescription->getAdditionalDescriptionId()] = $additionalDescription->getData();
        }

        return $this->loadedData;
    }
}
