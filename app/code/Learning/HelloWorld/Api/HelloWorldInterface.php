<?php

namespace Learning\HelloWorld\Api;

/**
 * Interface HelloWorldInterface
 */
interface HelloWorldInterface
{
    /**
     * Return 'hello' message.
     *
     * @param string $message
     * @return string|null
     * @api
     *
     */
    public function hello(string $message = ''): ?string;
}
