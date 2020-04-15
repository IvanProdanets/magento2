<?php

namespace Learning\Blog\Controller\Adminhtml\Blog;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Action implements HttpGetActionInterface
{
    private $blogRepository;

    /**
     * Edit constructor.
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
     * Blog edit action.
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam(BlogInterface::ID);

        try {
            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $this->blogRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                __('Could not find blog with ID %1.', $id)
            );
            $result->setPath('*/*');
        }

        $result->getConfig()->getTitle()->prepend(__('Edit Blog'));

        return $result;
    }
}
