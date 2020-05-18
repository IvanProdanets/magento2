<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

class DeleteButton extends GenericButton
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label'    => __('Delete'),
            'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this description?') .
                          '\', \'' . $this->getDeleteUrl() . '\')',
            'class'    => 'delete',
        ];
    }

    /**
     * Get URL for delete.
     *
     * @return string
     */
    private function getDeleteUrl(): string
    {
        $id = $this->context->getRequestParam('id', 0);
        $productId = $this->context->getRequestParam('productId', 0);
        return $this->context->getUrl(
            'additionalDescription/product/delete',
            ['id' => $id, 'productId' => $productId]
        );
    }
}
