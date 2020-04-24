<?php

namespace Learning\HelloWorld\Model;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * Class HelloWorld.
 */
class HelloWorld implements HelloWorldInterface
{
    /**
     * Return 'hello' message.
     *
     * @param string $message
     * @return string|null
     * @api
     *
     */
    public function hello(string $message = ''): ?string
    {
        return __($message . 'Hello World from Magento2 API!');
    }
}
