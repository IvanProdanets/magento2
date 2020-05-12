<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Controller\Index;

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Response;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var AdditionalDescriptionRepository
     */
    private $repository;

    /**
     * Index constructor.
     *
     * @param Context                         $context
     * @param AdditionalDescriptionRepository $repository
     */
    public function __construct(
        Context $context,
        AdditionalDescriptionRepository $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /** @var Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $id = (int) $this->_request->getParam('id');

        if (!$id) {
            $result->setHttpResponseCode(Response::STATUS_CODE_500);
            $result->setData([
                'error' => __('Get param missing')
            ]);

            return $result;
        }

        try {
            /** @var AdditionalDescription $additionalDescription */
            $additionalDescription = $this->repository->getById($id);
            $data = [
                'data' => $additionalDescription->getData(),
            ];
            $statusCode = Response::HTTP_OK;
        } catch (NoSuchEntityException $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            $statusCode = Response::STATUS_CODE_500;
        }

        $result->setData($data);
        $result->setHttpResponseCode($statusCode);

        return $result;
    }
}
