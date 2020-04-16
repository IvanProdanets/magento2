<?php
namespace Learning\Blog\Controller\Blog;

use Learning\Blog\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action
{
    /** @var BlogCollectionFactory  */
    private $blogCollectionFactory;

    /** @var PageFactory  */
    private $pageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param BlogCollectionFactory $blogFactory
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        BlogCollectionFactory $blogFactory,
        PageFactory $pageFactory
    ) {
        $this->blogCollectionFactory = $blogFactory;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     */
    public function execute()
    {
        $collection = $this->blogCollectionFactory->create();
        foreach ($collection as $item) {
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        exit();

        return $this->pageFactory->create();
    }
}
