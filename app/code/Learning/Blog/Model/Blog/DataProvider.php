<?php

namespace Learning\Blog\Model\Blog;

use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Helper\ImageHelper;
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
    protected $collection;

    /**
     * @var array
     */
    private $loadedData;

    /** @var ImageHelper */
    private $imageHelper;

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
        ImageHelper $imageHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection  = $collectionFactory->create();
        $this->imageHelper = $imageHelper;
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
            $this->loadedData[$blog->getId()] = $this->mapFields($blog->getData());
        }

        return $this->loadedData;
    }


    /**
     * @param array $item
     *
     * @return array
     */
    private function mapFields(array $item): array
    {
        // Map BlogInterface::IMAGE_URL field for display.
        $imageUrl = $item[BlogInterface::IMAGE_URL];
        unset($item[BlogInterface::IMAGE_URL]);
        $item[BlogInterface::IMAGE_URL][0] = [
            'name' => basename($imageUrl),
            'url'  => $this->imageHelper->getImageUrl($imageUrl),
            'type' => 'image',
            'size' => $this->imageHelper->getStat($imageUrl)['size'] ?? 0,
        ];

        return $item;
    }
}
