<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Test\Integration\Plugin\HelloWorld;

use Learning\HelloWorld\Api\HelloWorldInterface;
use Learning\HelloWorld\Plugin\HelloWorld\After;
use Learning\HelloWorld\Plugin\HelloWorld\Before;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class HelloWorldInterfaceTest extends TestCase
{
    /** @var HelloWorldInterface */
    private $helloService;

    /**
     * Bootstrap application before any test.
     */
    protected function setUp()
    {
        $this->helloService = Bootstrap::getObjectManager()->create(HelloWorldInterface::class);
        parent::setUp();
    }

    /**
     * Test that before plugin update the 'message' param.
     */
    public function testHelloWorldBeforePluginSuccess()
    {
        $result = $this->helloService->hello();
        $this->assertContains(Before::PREFIX, $result);
    }

    /**
     * Test that around plugin update.
     */
    public function testHelloWorldAroundPluginSuccess()
    {
        $result = $this->helloService->hello();
        $this->assertRegExp('/<h1>(.*?)<\/h1>/', $result);
    }

    /**
     * Test that after plugin update the 'message' param.
     */
    public function testHelloWorldAfterPluginSuccess()
    {
        $result = $this->helloService->hello();
        $this->assertContains(After::SUFFIX, $result);
    }

    /**
     * Test plugins order.
     */
    public function testPluginsOrderIsRight()
    {
        $result = $this->helloService->hello();
        $pattern = '/<h1>' . Before::PREFIX . '(.*?)'. After::SUFFIX. '<\/h1>/';
        $this->assertRegExp($pattern, $result);
    }

}
