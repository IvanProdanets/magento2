<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Api;

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Webapi\Response;
use Magento\Framework\Webapi\Rest\Request;

class AdditionalDescriptionManagementTest extends BaseWebApi
{
    const RESOURCE_PATH = '/V1/products/additionalDescription';

    /**
     * Test AdditionalDescription endpoint return data.
     *
     * @magentoApiDataFixture loadAdditionalDescription
     */
    public function testAdditionalDescriptionReturnData()
    {
        /** @var Product $product */
        $product = $this->objectManager->create(Product::class);
        $product->load($product->getIdBySku('simple_test'));
        $additionalDescription = $this->dataHelper->getLatestDescription([
            'customer_email' => 'test1.customer@example.com',
            'product_id'     => $product->getId(),
        ]);

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH . '?id='. $additionalDescription->getAdditionalDescriptionId(),
                'httpMethod'   => Request::HTTP_METHOD_GET,
            ],
        ];

        $this->_webApiCall($serviceInfo, ["id" => $additionalDescription->getAdditionalDescriptionId()]);

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertJson(json_encode([
            'additional_description_id' => $additionalDescription->getAdditionalDescriptionId(),
            'customer_email'            => 'test1.customer@example.com',
            'additionalDescription'     => $additionalDescription->getAdditionalDescription(),
            'product_id'                => $product->getId(),
        ]));
    }

    /**
     * Test AdditionalDescription endpoint save data.
     *
     * @magentoApiDataFixture loadCustomerWithPermission
     * @magentoApiDataFixture loadProduct
     */
    public function testSaveAdditionalDescription()
    {
        /** @var Product $product */
        $product = $this->objectManager->create(Product::class);
        $product->load($product->getIdBySku('simple_test'));

        /** @var Customer $customer */
        $customer = $this->objectManager->create(Customer::class);
        $customer->setWebsiteId(1)->loadByEmail('test1.customer@example.com');

        $additionalDescription = [
            'customer_email'         => $customer->getEmail(),
            'product_id'             => $product->getIdBySku('simple_test'),
            'additional_description' => $this->dataHelper->getRandomString(255),
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_POST,
                'token'        => $this->getCustomerToken($customer->getEmail()),
            ],
        ];

        $this->_webApiCall($serviceInfo, ["additionalDescription" => $additionalDescription]);

        /** @var AdditionalDescription $additionalDescription */
        $additionalDescriptionFromDB = $this->dataHelper->getLatestDescription([
           'customer_email'         => 'test1.customer@example.com',
           'product_id'             => $product->getIdBySku('simple_test'),
        ]);
        $additionalDescriptionFromDB = $additionalDescriptionFromDB->getData();

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertArraySubset($additionalDescription, $additionalDescriptionFromDB);

        $updatedAdditionalDescription = [
            'customer_email'         => 'test1.customer@example.com',
            'product_id'             => $product->getId(),
            'additional_description' => $this->dataHelper->getRandomString(255),
        ];

        $this->_webApiCall($serviceInfo, ["additionalDescription" => $updatedAdditionalDescription]);

        /** @var AdditionalDescription $additionalDescription */
        $updatedAdditionalDescriptionFromDB = $this->dataHelper->getLatestDescription([
            'customer_email' => 'test1.customer@example.com',
            'product_id'     => $product->getId(),
        ])->getData();

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertArraySubset($updatedAdditionalDescription, $updatedAdditionalDescriptionFromDB);
    }

    /**
     * Test admin can save AdditionalDescription.
     *
     * @magentoApiDataFixture loadAdditionalDescription
     */
    public function testAdminCanEditAdditionalDescription()
    {
        /** @var Product $product */
        $product = $this->objectManager->create(Product::class);
        $product->load($product->getIdBySku('simple_test'));

        /** @var Customer $customer */
        $customer = $this->objectManager->create(Customer::class);
        $customer->setWebsiteId(1)->loadByEmail('test1.customer@example.com');

        $additionalDescription = [
            'customer_email'         => $customer->getEmail(),
            'product_id'             => $product->getIdBySku('simple_test'),
            'additional_description' => $this->dataHelper->getRandomString(255),
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_POST,
                'token'        => $this->getAdminToken()
            ],
        ];

        $this->_webApiCall($serviceInfo, ["additionalDescription" => $additionalDescription]);

        /** @var AdditionalDescription $additionalDescription */
        $additionalDescriptionFromDB = $this->dataHelper->getLatestDescription(
            [
                'customer_email' => 'test1.customer@example.com',
                'product_id'     => $product->getIdBySku('simple_test'),
            ]);
        $additionalDescriptionFromDB = $additionalDescriptionFromDB->getData();

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertArraySubset($additionalDescription, $additionalDescriptionFromDB);
    }
    /**
     * Test that customer without permission cant add additional description.
     *
     * @magentoApiDataFixture loadCustomer
     * @magentoApiDataFixture loadProduct
     */
    public function testOnlyCustomerWithPermissionCanEditDescription()
    {
        /** @var Product $product */
        $product = $this->objectManager->create(Product::class);
        $product->load($product->getIdBySku('simple_test'));

        /** @var Customer $customer */
        $customer = $this->objectManager->create(Customer::class);
        $customer->setWebsiteId(1)->loadByEmail('test.customer@example.com');

        $additionalDescription = [
            'customer_email'         => $customer->getEmail(),
            'product_id'             => $product->getId(),
            'additional_description' => $this->dataHelper->getRandomString(255),
        ];

        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod'   => Request::HTTP_METHOD_POST,
                'token'        => $this->getAdminToken()
            ],
        ];

        $this->_webApiCall($serviceInfo, ["additionalDescription" => $additionalDescription]);

        /** @var AdditionalDescription $additionalDescription */
        $additionalDescriptionFromDB = $this->dataHelper->getLatestDescription(
            [
                'customer_email' => $customer->getEmail(),
                'product_id'     => $product->getId(),
            ]);
        $additionalDescriptionFromDB = $additionalDescriptionFromDB->getData();

        /** @var ResponseInterface $response */
        $response = $this->objectManager->create(ResponseInterface::class);

        $this->assertNotEmpty($response);
        $this->assertEquals($response->getHttpResponseCode(), Response::HTTP_OK);
        $this->assertArraySubset($additionalDescription, $additionalDescriptionFromDB);
    }
}
