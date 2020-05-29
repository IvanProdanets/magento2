<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Additional description grid save button.
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * Retrieve button-specified settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label'          => __('Save'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
        ];
    }
}
