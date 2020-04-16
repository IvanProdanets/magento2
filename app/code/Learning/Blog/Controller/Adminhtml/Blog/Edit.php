<?php
namespace Learning\Blog\Controller\Adminhtml\Blog;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action implements HttpGetActionInterface
{
    /** @var BlogRepositoryInterface */
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
     * Edit blog action.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam(BlogInterface::ID) ?? null;

        try {
            $this->blogRepository->getById($id);
            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $result->getConfig()->getTitle()->prepend(__('Edit Blog'));
        } catch (NoSuchEntityException $e) {
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Could not find blog'));
            $result->setPath('*/*');
        }

        return $result;
    }
}
