<?php

namespace Learning\HelloWorld\Model;

use Learning\HelloWorld\Api\HelloWorldInterface;

class HelloWorld implements HelloWorldInterface
{
    /**
     * Return 'hello' message.
     *
     * @api
     *
     * @return string|null
     */
    public function hello(): ?string
    {
        return __('Hello World from Magento2 API!');
    }
}
