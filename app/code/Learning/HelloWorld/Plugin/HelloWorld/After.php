<?php

namespace Learning\HelloWorld\Plugin\HelloWorld;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * Class After.
 */
class After
{
    const SUFFIX = 'after';

    /**
     * After Hello handler.
     *
     * @param HelloWorldInterface $subject
     * @param string              $result
     *
     * @return string
     */
    public function afterHello(HelloWorldInterface $subject, string $result): string
    {
        return $result . self::SUFFIX;
    }
}
