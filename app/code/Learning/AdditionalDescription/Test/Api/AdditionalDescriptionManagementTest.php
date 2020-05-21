<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Api;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Webapi\Response;
use Magento\Framework\Webapi\Rest\Request;

///**
// * @magentoDbIsolation enabled
// */
class AdditionalDescriptionManagementTest extends BaseWebApi
{
    const RESOURCE_PATH = '/V1/products/additionalDescription';

    public static function additionalDescription(): void
    {
        include __DIR__ . '/../Integration/_files/additionalDescription.php';
    }

    public static function additionalDescriptionRollback(): void
    {
        include __DIR__ . '/../Integration/_files/additionalDescription_rollback.php';
    }

    /**
     * Test AdditionalDescription endpoint return data.
     */
    public function testAdditionalDescriptionReturnData()
    {

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?id='. 1,
                'httpMethod'   => Request::HTTP_METHOD_GET,
            ],
        ];

        $this->_webApiCall($serviceInfo, ["id" => 1]);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
//        $this->assertJson(json_encode([
//            "permission_id"  => 1,
//            "is_allowed"     => true,
//            "customer_email" => 'customer2@example.com'
//        ]));
    }
}
