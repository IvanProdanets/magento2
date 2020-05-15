<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

class BackButton extends GenericButton
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label'          => __('Back'),
            'class'          => 'action- back scalable',
            'url'            => $this->getBackUrl(),
        ];
    }
}
