<?php

namespace Learning\Blog\Model\Blog;

use Learning\Blog\Model\Blog;
use Learning\Blog\Model\ResourceModel\Blog\Collection;
use Learning\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider.
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    private $collection;

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

        /** @var Blog $blog */
        foreach ($items as $blog) {
            $this->loadedData[$blog->getId()] = $blog->getData();
        }

        return $this->loadedData;
    }
}
