<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Test\Api;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Webapi\Response;
use Magento\Framework\Webapi\Rest\Request;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

class HelloWorldInterfaceTest extends WebapiAbstract
{
    const RESOURCE_PATH = '/V1/hello';

    /** @var ObjectManagerInterface  */
    private $objectManager;

    /**
     * Bootstrap application before any test
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        parent::setUp();
    }

    /**
     * Test web-api endpoint.
     */
    public function testHelloEndpointReturnData()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_GET,
            ],
        ];

        $responseData = $this->_webApiCall($serviceInfo, []);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertContains('beforeHello World from Magento2!after', $responseData);
    }
}
