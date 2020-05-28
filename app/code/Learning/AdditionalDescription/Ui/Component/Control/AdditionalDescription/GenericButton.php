<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Ui\Component\Control\AdditionalDescription;

use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Additional description base button class.
 */
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
     * Retrieve button-specified settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [];
    }
}
