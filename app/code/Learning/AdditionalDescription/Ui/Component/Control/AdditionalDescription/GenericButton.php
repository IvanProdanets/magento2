<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class GenericButton implements ButtonProviderInterface
{
    /** @var Context */
    protected $context;

    /**
     * BaseButton constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * Get URL for back.
     *
     * @return string
     */
    protected function getBackUrl(): string
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

    /**
     * Retrieve button-specified settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [];
    }
}
