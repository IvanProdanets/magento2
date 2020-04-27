<?php

namespace Learning\HelloWorld\Plugin\HelloWorld;

use Learning\HelloWorld\Api\HelloWorldInterface;

/**
 * Class Around.
 */
class Around
{
    /**
     * Around Hello handler.
     *
     * @param HelloWorldInterface $subject
     * @param callable            $proceed
     * @param string              $message
     *
     * @return string
     */
    public function aroundHello(HelloWorldInterface $subject, callable $proceed, string $message='')
    {
        return '<h1>' . $proceed($message) . '</h1>';
    }

}
