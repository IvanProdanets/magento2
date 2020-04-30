<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Model;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * HelloWorld entity interface implementation.
 */
class HelloWorld implements HelloWorldInterface
{
    /**
     * Return greeting text.
     *
     * @param string $message
     * @return string|null
     *
     */
    public function hello(string $message = ''): ?string
    {
        return __($message . 'Hello World from Magento2!')->render();
    }
}
