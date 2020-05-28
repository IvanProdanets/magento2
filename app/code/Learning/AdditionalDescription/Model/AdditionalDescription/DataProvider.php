<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model\AdditionalDescription;

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Additional Description data provider.
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * DataProvider constructor.
     *
     * @param string            $name
     * @param string            $primaryFieldName
     * @param string            $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array             $meta
     * @param array             $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
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
            $this->loadedData[$additionalDescription->getId()] = $additionalDescription->getData();
        }

        return $this->loadedData;
    }
}
