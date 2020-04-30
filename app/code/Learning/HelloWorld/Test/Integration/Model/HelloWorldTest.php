<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Test\Integration\Model;

use Learning\HelloWorld\Api\HelloWorldInterface;
use Learning\HelloWorld\Model\HelloWorld;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    /** @var HelloWorld */
    private $model;

    /** @var ObjectManagerInterface */
    private $objectManager;

    /**
     *
     */
    public function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->model = $this->objectManager->create(HelloWorld::class);
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * Check model instance.
     */
    public function testModelIsInstanceOfHelloWorldInterface()
    {
        $this->assertInstanceOf(HelloWorldInterface::class, $this->model);
    }

    /**
     * Test return type.
     */
    public function testHelloReturnString()
    {
        $this->assertTrue(is_string($this->model->hello()));
    }

    /**
     * Test if hello() return greeting.
     */
    public function testHelloReturnGreeting()
    {
        $this->assertContains('Hello World from Magento2!', $this->model->hello());
    }
}
