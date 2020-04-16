<?php

namespace Learning\Blog\Controller\Adminhtml\Blog;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Model\BlogRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Learning_Blog::blog_delete';

    /** @var BlogRepository */
    private $blogRepository;

    /**
     * Save constructor.
     *
     * @param Context                 $context
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(Context $context, BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*');
        $id = $this->getRequest()->getParam(BlogInterface::ID, null);

        if (!$id) {
            $this->messageManager->addErrorMessage('Empty "id" not allowed');

            return $resultRedirect;
        }

        try {
            $this->blogRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You\'ve deleted the blog.'));
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(__('Could not delete blog with ID %1.', $id));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Could not find blog with ID %1.', $id));
        }

        return $resultRedirect;
    }
}
