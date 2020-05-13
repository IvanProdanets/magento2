<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\DataProvider\Product;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Collection;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /** * @var Collection */
    protected $collectionFactory;

    /** * @var RequestInterface */
    protected $request;

    /**
     * @param string            $name
     * @param string            $primaryFieldName
     * @param string            $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface  $request
     * @param array             $meta
     * @param array             $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collectionFactory = $collectionFactory;
        $this->collection        = $this->collectionFactory->create();
        $this->request           = $request;
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData(): array
    {
        $this->getCollection()->addProductFilter((int)$this->request->getParam('current_product_id', 0));

        $arrItems = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items'        => [],
        ];

        foreach ($this->getCollection() as $item) {
            $arrItems['items'][] = $item->toArray([]);
        }

        return $arrItems;
    }

    /**
     * Add field filter to collection.
     *
     * @param Filter $filter
     *
     * @return mixed
     */
    public function addFilter(Filter $filter)
    {
        $field = $filter->getField();

        if (in_array(
            $field,
            [
                AdditionalDescriptionInterface::DESCRIPTION_ID,
                AdditionalDescriptionInterface::CUSTOMER_EMAIL,
                AdditionalDescriptionInterface::PRODUCT_ID,
            ]
        )) {
            $filter->setField($field);
        }

        parent::addFilter($filter);
    }
}
