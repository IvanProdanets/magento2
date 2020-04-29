<?php

namespace Learning\HelloWorld\Test\Integration\Block;

use Learning\HelloWorld\Api\HelloWorldInterface;
use Learning\HelloWorld\Block\HelloWorld;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    /** @var HelloWorldInterface */
    private $helloService;

    /** @var HelloWorld */
    private $block;

    /**
     * Sets up the fixture, for example, open a network connection.
     */
    public function setUp()
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->helloService = $objectManager->create(HelloWorldInterface::class);
        $this->block = $objectManager->create(HelloWorld::class);
        parent::setUp();
    }

    /**
     * Test if block return greeting.
     */
    public function testBlockReturnGreeting()
    {
        $this->assertContains('Hello World from Magento2!', $this->block->sayHello());
    }

    /**
     * Test that block use HelloWorldInterface for say greeting.
     * @see HelloWorld::sayHello()
     * @see HelloWorldInterface::hello()
     */
    public function testBlocksUseHelloWorldInterface()
    {
        $this->assertEquals($this->helloService->hello(), $this->block->sayHello());
    }

}
