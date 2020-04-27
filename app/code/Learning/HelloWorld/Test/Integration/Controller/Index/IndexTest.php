<?php

namespace Learning\HelloWorld\Test\Integration\Controller\Index;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\TestCase\AbstractController;

class IndexTest extends AbstractController
{
    public function testIndexControllerDisplayCorrectData()
    {
        $this->dispatch('hello/index/index');

        $this->assertContains(''
//            [
//                'data' => [
//                    'message' => '<h1>beforeHello World from Magento2 API!after</h1>'
//                ]
//            ]
        , $this->getResponse()->getBody());
    }

}
