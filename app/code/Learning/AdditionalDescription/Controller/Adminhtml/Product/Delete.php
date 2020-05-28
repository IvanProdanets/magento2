<?php

namespace Learning\AdditionalDescription\Controller\Adminhtml\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Delete Additional description Action class.
 */
class Delete extends Action implements HttpGetActionInterface
{
    /** @var AdditionalDescriptionRepositoryInterface */
    private $repository;

    /**
     * Delete constructor.
     *
     * @param Context                                  $context
     * @param AdditionalDescriptionRepositoryInterface $repository
     */
    public function __construct(Context $context, AdditionalDescriptionRepositoryInterface $repository)
    {
        $this->repository = $repository;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $id = $this->getRequest()->getParam(AdditionalDescriptionInterface::DESCRIPTION_ID, null);
        if (!$id) {
            $this->messageManager->addErrorMessage('Empty "id" not allowed');

            return $resultRedirect;
        }

        try {
            $productId = $this->getRequest()->getParam('productId', null) ?? $this->repository->getById($id);
            $redirect  = $this->getUrl('catalog/product/edit', ['id' => $productId]);
            $resultRedirect->setPath($redirect);
            $this->repository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You\'ve deleted the product additional description.'));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Could not find the product additional description ID %1.', $id));
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(
                __('Could not delete the product additional description with ID %1.', $id)
            );
        }

        return $resultRedirect;
    }
}
