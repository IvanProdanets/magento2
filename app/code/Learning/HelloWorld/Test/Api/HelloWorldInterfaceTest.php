<?php

namespace Learning\HelloWorld\Test\Api;

use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Assert\AssertArrayContains;
use Magento\TestFramework\TestCase\WebapiAbstract;

class HelloWorldInterfaceTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/hello';

    public function testHelloEndpointReturnData()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_GET,
            ],
        ];
        $this->assertTrue(true);
        $response = $this->_webApiCall($serviceInfo, []);

        $this->assertNotEmpty($response);
//        $expectedData = [
//
//        ];
//        AssertArrayContains::assert($expectedData, $this-);
    }
}
