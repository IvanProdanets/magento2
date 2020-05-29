<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

/**
 * Additional description grid back button.
 */
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

    /**
     * Get URL for back.
     *
     * @return string
     */
    private function getBackUrl(): string
    {

        $id = $this->context->getRequestParam('productId');
        if ($id) {
            return $this->context->getUrl(
                'catalog/product/edit',
                ['id' => $id]
            );
        }

        return $this->context->getUrl('*/*/');
    }
}
