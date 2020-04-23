<?php

namespace Learning\Blog\Ui\Component\Listing\Column;

use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Helper\ImageHelper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail.
 */
class Thumbnail extends Column
{
    /** @var UrlInterface */
    private $urlBuilder;

    /** @var ImageHelper */
    private $imageHelper;

    /**
     * Thumbnail constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param ImageHelper        $imageHelper
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        ImageHelper $imageHelper,
        array $components = [],
        array $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->urlBuilder  = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url                            = $this->imageHelper->getImageUrl(
                    $item[BlogInterface::IMAGE_URL] ?? ''
                );
                $item[$fieldName . '_orig_src'] = $url;
                $item[$fieldName . '_src']      = $url;
                $item[$fieldName . '_alt']      = ImageHelper::DEFAULT_ALT;
                $item[$fieldName . '_link']     = $this->urlBuilder->getUrl(
                    'blog/blog/edit',
                    [BlogInterface::ID => $item[BlogInterface::ID]]
                );
            }
        }

        return $dataSource;
    }
}
