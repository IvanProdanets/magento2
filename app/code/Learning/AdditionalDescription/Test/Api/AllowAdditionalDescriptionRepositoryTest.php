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

    /**
     * Test AllowAdditionalDescription endpoint return data.
     *
     * @magentoApiDataFixture loadCustomerWithPermission
     * @magentoApiDataFixture loadCustomerWithPermissionRollback
     */
    public function testAllowAdditionalDescriptionReturnData()
    {
        /** @var AllowAddDescription $allowAddDescription */
        $allowAddDescription = $this->allowAddDescriptionRepository->get('test1.customer@example.com');
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?id='. $allowAddDescription->getPermissionId(),
                'httpMethod'   => Request::HTTP_METHOD_GET,
            ],
        ];

        $this->_webApiCall($serviceInfo, ["id" => $allowAddDescription->getPermissionId()]);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertJson(json_encode([
            "permission_id"  => $allowAddDescription->getPermissionId(),
            "is_allowed"     => $allowAddDescription->getIsAllowed(),
            "customer_email" => $allowAddDescription->getCustomerEmail(),
        ]));
    }

    /**
     * Test AllowAdditionalDescription endpoint save data.
     *
     * @magentoApiDataFixture loadCustomer
     * @magentoApiDataFixture loadCustomerRollback
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
            "customer_email" => 'test.customer@example.com',
        ];

        $this->_webApiCall($serviceInfo, ['allowAddDescription' => $data]);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);
        /** @var AllowAddDescription $allowAddDescription */
        $allowAddDescription = $this->allowAddDescriptionRepository->get('test.customer@example.com');

        // Test allowAddDescription create new successful.
        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertEquals( $data['is_allowed'], $allowAddDescription->getIsAllowed());

        $data['is_allowed'] = false;
        $this->_webApiCall($serviceInfo, ['allowAddDescription' => $data]);

        $allowAddDescription = $this->allowAddDescriptionRepository->get('test.customer@example.com');

        // Test allowAddDescription update successful.
        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertEquals( $data['is_allowed'], $allowAddDescription->getIsAllowed());
    }
}
