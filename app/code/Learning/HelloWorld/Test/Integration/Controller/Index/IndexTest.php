<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Test\Integration\Controller\Index;

use Learning\HelloWorld\Block\HelloWorld;
use Magento\TestFramework\TestCase\AbstractController;

class IndexTest extends AbstractController
{
    /**
     * Test index action.
     */
    public function testIndexAction()
    {
        $this->dispatch('hello/index/index');

        $this->assertContains('Hello World from Magento2!', $this->getResponse()->getBody());
    }

    /**
     * Test that Hello block displayed on index page.
     * @see HelloWorld
     */
    public function testHelloBlockDisplayed()
    {
        $this->dispatch('hello/index/index');
        $this->assertContains('<div class="hello-block">', $this->getResponse()->getContent());
    }
}
