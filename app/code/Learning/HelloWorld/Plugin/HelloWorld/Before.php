<?php

namespace Learning\HelloWorld\Plugin\HelloWorld;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * Class Before.
 */
class Before
{
    const PREFIX = 'before';

    /**
     * Before Hello handler.
     *
     * @param HelloWorldInterface $subject
     * @param string              $message
     *
     * @return array
     */
    public function beforeHello(HelloWorldInterface $subject, string $message): array
    {
        return [ self::PREFIX . $message ];
    }
}
