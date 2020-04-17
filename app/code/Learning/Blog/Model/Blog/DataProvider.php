<?php

namespace Learning\Blog\Model\Blog;

use Learning\Blog\Api\Data\BlogInterface;
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
//
//        foreach ($items as $brand) {
//            $brandData = $brand->getData();
//            $brand_img = $brandData['brand_image'];
//            $brand_img_url = $brandData['brand_image_url'];
//            unset($brandData['brand_image']);
//            unset($brandData['brand_image_url']);
//            $brandData['brand_image'][0]['name'] = $brand_img;
//            $brandData['brand_image'][0]['url'] = $brand_img_url;
//            $this->_loadedData[$brand->getEntityId()] = $brandData;
//        }

        /** @var Blog $blog */
        foreach ($items as $blog) {
//            $this->loadedData[$blog->getId()] = $this->mapFields($blog->getData());
            $this->loadedData[$blog->getId()] = $blog->getData();
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
        $imageUrl = $item[BlogInterface::IMAGE_URL];
        unset($item[BlogInterface::IMAGE_URL]);
        $item[BlogInterface::IMAGE_URL][]['name'] = $imageUrl;
        $item[BlogInterface::IMAGE_URL][]['url']  = $imageUrl;

        return $item;
    }
}
