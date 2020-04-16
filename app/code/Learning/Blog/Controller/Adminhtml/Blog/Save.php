<?php

namespace Learning\Blog\Controller\Adminhtml\Blog;

use Learning\Blog\Api\BlogRepositoryInterface;
use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Model\Blog;
use Learning\Blog\Model\BlogFactory;
use Learning\Blog\Model\BlogRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Learning_Blog::blog_save';

    /** @var Blog */
    private $blogFactory;

    /** @var BlogRepository */
    private $blogRepository;

    /**
     * Save constructor.
     *
     * @param Context                 $context
     * @param BlogFactory             $blogFactory
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(
        Context $context,
        BlogFactory $blogFactory,
        BlogRepositoryInterface $blogRepository
    ) {
        $this->blogFactory    = $blogFactory;
        $this->blogRepository = $blogRepository;
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

        $id = $this->getRequest()->getParam(BlogInterface::ID, null);
        $this->save($data, $id);

        return $resultRedirect;
    }

    /**
     * Prepare data from request to save in DB.
     *
     * @param array $data
     *
     * @return array
     */
    private function prepareData(array &$data): array
    {
        if (isset($data['form_key'])) {
            unset($data['form_key']);
        }

        return array_filter(
            $data,
            function ($value) {
                return $value !== '';
            }
        );
    }

    /**
     * Update or create blog in DB.
     *
     * @param array    $data
     * @param int|null $id
     *
     * @return BlogInterface
     */
    private function save(array &$data, ?int $id = null): BlogInterface
    {
        $blog = null;
        $data = $this->prepareData($data);

        try {
            $blog = $id ? $this->blogRepository->getById($id) : $this->blogFactory->create();
            $blog->setData($data);
            $blog = $this->blogRepository->save($blog);
            $this->messageManager->addSuccessMessage(__('The Blog has been saved.'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving blog.'));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Could not find blog'));
        }

        return $blog;
    }
}
