<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Block\Product;

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
            'additional/index/save',
            [ 'id' => $this->getProduct()->getId() ]
        );
    }
}
