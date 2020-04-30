<?php

declare(strict_types=1);

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
     *
     */
    public function hello(string $message = ''): ?string;
}
