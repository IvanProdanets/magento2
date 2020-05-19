<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Integration\Controller\Index;

use Learning\AdditionalDescription\Test\Integration\Controller\BaseTestController;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Webapi\Response;
use Magento\TestFramework\Request;

class SaveTest extends BaseTestController
{
    /**
     * Test that Save action validation work successful.
     *
     * @magentoDbIsolation enabled
     * @magentoDataFixture loadCustomer
     */
    public function testSaveActionValidationSuccess()
    {
        $this->getRequest()->setMethod(Request::METHOD_POST);

        // Test that request required params not empty.
        $this->dispatch('additionalDescription/index/save');
        $this->assertEquals(Response::STATUS_CODE_500, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode(['error' => __('Invalid request params')]));

        // Test that 'form_key' validation successful
        $this->prepareRequestData(['product_id', 1]);
        $this->dispatch('additionalDescription/index/save');
        $this->assertEquals(Response::STATUS_CODE_500, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode(['error' => __('Invalid form data')]));

        // Test that customer without permission cant save description
        $customer = $this->accountManagement->authenticate('customer@example.com', 'password');
        $this->prepareRequestData([
            'form_key'               => $this->formKey->getFormKey(),
            'additional_description' => 'Test additional description',
            'customer_email'         => $customer->getEmail(),
            'product_id'             => 1,
        ]);
        $this->dispatch('additionalDescription/index/save');
        $this->assertEquals(Response::STATUS_CODE_500, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode([
            'error' => __('You dont have right permission to edit additional description')
        ]));
    }

    /**
     * Test that Save action save additional description.
     *
     * @magentoDbIsolation enabled
     * @magentoDataFixture loadAdditionalDescription
     */
    public function testSaveActionCreateDescription()
    {
        $customer = $this->logAsCustomerWithPermission();
        $data = [
            'form_key'               => $this->formKey->getFormKey(),
            'additional_description' => 'New Additional description',
            'product_id'             => 1,
        ];
        $this->prepareRequestData($data);
        $this->dispatch('additionalDescription/index/save');

        $this->assertEquals(Response::HTTP_OK, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode(['success' => __('Additional description has been saved')]));

        $lastDescription = $this->getLatestDescription()->getData();
        unset($lastDescription['id']);
        unset($data['form_key']);
        $data['customer_email'] = $customer->getEmail();
        $this->assertEquals($lastDescription, $data);
    }

    /**
     * Test that Save action save additional description.
     *
     * @magentoDbIsolation enabled
     * @magentoDataFixture loadAdditionalDescription
     */
    public function testSaveActionUpdateDescription()
    {
        $customer = $this->logAsCustomerWithPermission();
        $additionalDescription = $this->additionalDescriptionRepository->getById(1);

        $data = [
            'form_key'               => $this->formKey->getFormKey(),
            'additional_description' => $additionalDescription->getAdditionalDescription() . 'Updated',
            'product_id'             => $additionalDescription->getProductId(),
        ];
        $this->prepareRequestData($data);
        $this->dispatch('additionalDescription/index/save');

        $this->assertEquals(Response::HTTP_OK, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode(['success' => __('Additional description has been saved')]));

        $lastDescription = $this->getLatestDescription()->getData();
        unset($lastDescription['id']);
        unset($data['form_key']);
        $data['customer_email'] = $customer->getEmail();

        $this->assertEquals($lastDescription, $data);
    }

    /**
     * @param array $postData
     * @return void
     */
    private function prepareRequestData($postData): void
    {
        $this->getRequest()->setMethod(Request::METHOD_POST);
        $this->getRequest()->setPostValue($postData);
    }

    /**
     * @return CustomerInterface
     * @throws LocalizedException
     */
    private function logAsCustomerWithPermission(): CustomerInterface
    {
        $customer = $this->accountManagement->authenticate('customer2@example.com', 'password');
        $this->session->setCustomerDataAsLoggedIn($customer);

        return $customer;
    }
}
