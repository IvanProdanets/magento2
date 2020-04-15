<?php

namespace Learning\Blog\Controller\Adminhtml\Blog;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Model\Blog;
use Learning\Blog\Model\BlogFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends Action implements HttpPostActionInterface
{
    private $blogRepository;
    private $blogFactory;

    public function __construct(Context $context, BlogRepositoryInterface $blogRepository, BlogFactory $blogFactory)
    {
        $this->blogRepository = $blogRepository;
        $this->blogFactory = $blogFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
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


        if ($data) {
            try {
                $id = (int) $this->getRequest()->getParam(BlogInterface::ID);

            } catch (\Exception $exception) {
            }
        }

        return $resultRedirect;
    }
}
