<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Fieldset;

class AdditionalDescriptionsTab extends AbstractModifier
{
    const DESCRIPTION_FIELDSET_NAME = 'additional_descriptions_grid_fieldset';
    const DESCRIPTION_FIELD_NAME = 'additional_descriptions_grid';
    const GROUP_CONTENT = 'content';
    const SORT_ORDER = 10;

    /** @var LocatorInterface */
    protected $locator;

    /** @var UrlInterface */
    protected $urlBuilder;

    /** @var array */
    protected $meta = [];

    /**
     * CustomTab constructor.
     *
     * @param LocatorInterface $locator
     * @param UrlInterface     $urlBuilder
     */
    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder
    ) {
        $this->locator    = $locator;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @param array $meta
     *
     * @return array
     */
    public function modifyMeta(array $meta): array
    {
        // Hide tab on Add Product page.
        if (!$this->locator->getProduct()->getId()) {
            return $meta;
        }

        $this->meta = $meta;
        $this->addAdditionalDescriptionsTab();

        return $this->meta;
    }

    /**
     * Add "Additional Descriptions" Tab to meta data.
     */
    protected function addAdditionalDescriptionsTab(): void
    {
        $this->meta = array_merge_recursive(
            $this->meta,
            [
                static::DESCRIPTION_FIELDSET_NAME => $this->getTabConfig(),
            ]
        );
    }

    /**
     * Get "Additional Descriptions" Tab config.
     *
     * @return array
     */
    protected function getTabConfig()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label'         => __('Additional Descriptions'),
                        'componentType' => Fieldset::NAME,
                        'provider'      => static::FORM_NAME . '.product_form_data_source',
                        'collapsible'   => true,
                        'opened'        => false,
                        'sortOrder' =>
                            $this->getNextGroupSortOrder(
                                $this->meta,
                                static::GROUP_CONTENT,
                                static::SORT_ORDER
                            ),
                    ],
                ],
            ],
            'children'  => [
                static::DESCRIPTION_FIELD_NAME => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'autoRender'         => true,
                                'componentType'      => 'insertListing',
                                'dataScope'          => 'additional_descriptions_grid_listing',
                                'externalProvider'   => 'additional_descriptions_grid_listing.additional_descriptions_grid_listing_data_source',
                                'selectionsProvider' => 'additional_descriptions_grid_listing.additional_descriptions_grid_listing.product_columns.ids',
                                'ns'                 => 'additional_descriptions_grid_listing',
                                'render_url'         => $this->urlBuilder->getUrl('mui/index/render'),
                                'realTimeLink'       => false,
                                'behaviourType'      => 'simple',
                                'externalFilterMode' => true,
                                'imports'            => [
                                    'productId' => '${ $.provider }:data.product.current_product_id'
                                ],
                                'exports'            => [
                                    'productId' => '${ $.externalProvider }:params.current_product_id'
                                ],

                            ],
                        ],
                    ],
                    'children'  => [],
                ],
            ],
        ];
    }
}
