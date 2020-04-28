<?php

namespace Learning\HelloWorld\Test\Integration\Controller\Index;

use Magento\Framework\Webapi\Response;
use Magento\TestFramework\TestCase\AbstractController;

class IndexTest extends AbstractController
{
    /**
     * Test that response Controller return JSON with expected data.
     */
    public function testIndexControllerDisplayCorrectData()
    {
        $this->dispatch('hello/index/index');

        // Assert that response return 200 status code.
        $this->assertEquals(Response::HTTP_OK, $this->getResponse()->getHttpResponseCode());

        $expectedJson = json_encode([
            'data' => [
                'message' => '<h1>beforeHello World from Magento2 API!after</h1>'
            ]
        ]);
        $actualJson = $this->getResponse()->getBody();

        //Assert that response return json.
        $this->assertJson($actualJson);

        // Assert that response return expected data
        $this->assertJsonStringEqualsJsonString($expectedJson, $this->getResponse()->getBody());
    }
}
