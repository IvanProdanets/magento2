<?php

namespace Learning\AdditionalDescription\Controller\Adminhtml\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save Blog Action class.
 */
class Save extends Action implements HttpPostActionInterface
{
    /** @var AdditionalDescriptionRepositoryInterface */
    private $repository;

    /**
     * Save constructor.
     *
     * @param Context                 $context
     * @param AdditionalDescriptionRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        AdditionalDescriptionRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*');

        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->messageManager->addErrorMessage('POST data is empty.');

            return $resultRedirect;
        }

        $id = $data['id'] ?? null;

        $additionalDescription = $this->repository->getById($id);
        $productId = $additionalDescription->getProductId();

        $additionalDescription->setAdditionalDescription($data[AdditionalDescriptionInterface::ADDITIONAL_DESCRIPTION]);
        $this->repository->save($additionalDescription);
        $redirect = $this->getUrl('catalog/product/edit', ['id' => $productId]);
        $resultRedirect->setPath($redirect);

        return $resultRedirect;
    }
}
