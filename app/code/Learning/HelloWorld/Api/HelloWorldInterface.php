<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Api;

/**
 * HelloWorld entity interface.
 */
interface HelloWorldInterface
{
    /**
     * Return greeting text.
     *
     * @param string $message
     * @return string|null
     *
     */
    public function hello(string $message = ''): ?string;
}
