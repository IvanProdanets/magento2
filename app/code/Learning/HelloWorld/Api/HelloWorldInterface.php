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
     * @api
     *
     * @return string|null
     */
    public function hello(): ?string;
}
