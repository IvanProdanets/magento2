<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Integration\Controller\Index;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Learning\AdditionalDescription\Test\Integration\Controller\BaseTestController;
use Magento\Framework\Webapi\Response;

class IndexTest extends BaseTestController
{
    /**
     * Test index action return error if param missed.
     */
    public function testIndexActionReturnErrorOnEmptyParam()
    {
        $this->dispatch('additionalDescription/index/index');
        $this->assertEquals(Response::STATUS_CODE_500, $this->getResponse()->getStatusCode());
        $this->assertJson(json_encode(['error' => __('Get param missing')]));
    }

    /**
     * Test if index action return expected data.
     *
     * @magentoDbIsolation enabled
     * @magentoDataFixture loadAdditionalDescription
     */
    public function testIndexActionReturnData()
    {
        $id = 1;
        $this->getRequest()->setParam('id', $id);
        $this->dispatch('additionalDescription/index/index');
        $response = $this->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        /** @var AdditionalDescriptionRepositoryInterface $repository */
        $repository = $this->_objectManager->get(AdditionalDescriptionRepository::class);
        $additionalDescription = $repository->getById($id);
        $this->assertJson($response->getContent(), $additionalDescription->getData());
    }
}
