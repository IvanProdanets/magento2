<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\DataProvider\Product;

use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Grid\Collection;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription\Grid\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

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
        $this->request           = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData(): array
    {
        $productId = $this->request->getParam('current_product_id');
        if ($productId) {
            $this->getCollection()->addProductFilter((int)$productId);
        }

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

        if (in_array($field, ['id', 'additional_description', 'customer_email'])) {
            $filter->setField('main_table.' . $field);
        }

        if (in_array($field, ['sku'])) {
            $filter->setField('cpe.' . $field);
        }

        if ($field === 'name') {
            $filter->setField('cpev.value');
        }

        parent::addFilter($filter);
    }
}
