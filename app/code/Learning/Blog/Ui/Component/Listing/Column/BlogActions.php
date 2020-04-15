<?php

namespace Learning\Blog\Ui\Component\Listing\Column;

use Learning\Blog\Api\Data\BlogInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class BlogActions.
 */
class BlogActions extends Column
{

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * BlogActions constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                '*/*/edit',
                                [ BlogInterface::ID => $item[BlogInterface::ID] ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href'  => $this->urlBuilder->getUrl(
                                '*/*/delete',
                                [ BlogInterface::ID => $item[BlogInterface::ID] ]
                            ),
                            'label' => __('Delete')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
