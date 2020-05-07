<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Block;

use Learning\HelloWorld\Api\HelloWorldInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Block used to send greeting to view.
 */
class HelloWorld extends Template
{
    /** @var HelloWorldInterface */
    private $helloService;

    /**
     * HelloWorld constructor.
     *
     * @param Context             $context
     * @param HelloWorldInterface $helloWorld
     * @param array               $data
     */
    public function __construct(
        Context $context,
        HelloWorldInterface $helloWorld,
        array $data = []
    ) {
        $this->helloService = $helloWorld;
        parent::__construct($context, $data);
    }

    /**
     * Get greeting.
     *
     * @return string
     */
    public function sayHello(): string
    {
        return $this->helloService->hello() ?? '';
    }
}
