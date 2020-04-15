<?php
namespace Learning\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $pageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Learning_Blog::blog_manage');

        //Set the header title of grid
        $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Learning'), __('Learning'));
        $resultPage->addBreadcrumb(__('Blog'), __('Manage Blogs'));

        return $resultPage;
    }
}
