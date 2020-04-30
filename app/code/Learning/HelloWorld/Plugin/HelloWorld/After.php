<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Plugin\HelloWorld;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * After plugins implementation.
 */
class After
{
    const SUFFIX = 'after';

    /**
     * After Hello handler.
     *
     * @param HelloWorldInterface $subject
     * @param string|null              $result
     *
     * @return string
     */
    public function afterHello(HelloWorldInterface $subject, ?string $result): string
    {
        return $result . self::SUFFIX;
    }
}
