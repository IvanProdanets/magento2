<?php
namespace Learning\Blog\Block;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;

class Display extends Template
{
    /**
     * Display constructor.
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }


    public function sayHello(): Phrase
    {
        return __('Hello from Index module!');
    }
}
