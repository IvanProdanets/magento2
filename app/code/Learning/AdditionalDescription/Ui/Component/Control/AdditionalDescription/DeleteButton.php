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
                          '\', \'' . $this->getBackUrl() . '\')',
            'class'    => 'delete',
        ];
    }
}
