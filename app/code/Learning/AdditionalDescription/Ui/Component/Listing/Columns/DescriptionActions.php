<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Listing\Columns;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class DescriptionActions extends Column
{

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['edit'] = [
                'href'   => $this->context->getUrl(
                    'additionalDescription/product/edit',
                    [
                        AdditionalDescriptionInterface::DESCRIPTION_ID =>
                            $item[AdditionalDescriptionInterface::DESCRIPTION_ID]
                    ]
                ),
                'label'  => __('Edit'),
                'hidden' => false,
            ];
        }

        return $dataSource;
    }
}
