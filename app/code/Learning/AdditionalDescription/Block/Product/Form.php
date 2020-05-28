<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Block\Product;

/**
 * Additional description Form template.
 */
class Form extends BaseTemplate
{
    /**
     * Get additional description post action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl(
            'additionalDescription/index/save'
        );
    }
}
