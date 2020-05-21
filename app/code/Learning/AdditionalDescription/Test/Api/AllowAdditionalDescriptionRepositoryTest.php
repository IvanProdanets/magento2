<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Api;

use Learning\AdditionalDescription\Model\AllowAddDescription;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Webapi\Response;
use Magento\Framework\Webapi\Rest\Request;

/**
 * @magentoDbIsolation enabled
 */
class AllowAdditionalDescriptionRepositoryTest extends BaseWebApi
{
    const RESOURCE_PATH = '/V1/customers/allowAddDescription';

    public static function loadCustomerWithPermission(): void
    {
        include __DIR__ . '/../Integration/_files/customerWithPermission.php';
    }

    public static function loadCustomerWithPermissionRollback(): void
    {
        include __DIR__ . '/../Integration/_files/customerWithPermission_rollback.php';
    }

    /**
     * Test AllowAdditionalDescription endpoint return data.
     * @magentoApiDataFixture loadCustomerWithPermission
     * @magentoApiDataFixture loadCustomerWithPermissionRollback
     */
    public function testAllowAdditionalDescriptionReturnData()
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
        $this->assertJson(json_encode([
            "permission_id"  => 1,
            "is_allowed"     => true,
            "customer_email" => 'customer2@example.com',
        ]));
    }

    /**
     * Test AllowAdditionalDescription endpoint return data.
     * @magentoApiDataFixture Magento/Customer/_files/customer.php
     * @magentoApiDataFixture Magento/Customer/_files/customer_rollback.php
     */
    public function testAllowAdditionalSaveSuccessful()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_POST,
            ],
        ];

        $data = [
            "is_allowed"     => true,
            "customer_email" => 'customer@example.com',
        ];

        $this->_webApiCall($serviceInfo, ['allowAddDescription' => $data]);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);
        /** @var AllowAddDescription $allowAddDescription */
        $allowAddDescription = $this->allowAddDescriptionRepository->get('customer@example.com');

        // Test New allowAddDescription save successful.
        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertEquals( $data['is_allowed'], $allowAddDescription->getIsAllowed());

        $data['is_allowed'] = false;
        $this->_webApiCall($serviceInfo, ['allowAddDescription' => $data]);

        $allowAddDescription = $this->allowAddDescriptionRepository->get('customer@example.com');

        // Test allowAddDescription update successful.
        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertEquals( $data['is_allowed'], $allowAddDescription->getIsAllowed());
    }
}
