<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Controller\Adminhtml\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action implements HttpGetActionInterface
{
    /** @var AdditionalDescriptionRepositoryInterface */
    private $descriptionRepository;

    /**
     * Edit constructor.
     *
     * @param Context                                $context
     * @param AdditionalDescriptionRepositoryInterface $descriptionRepository
     */
    public function __construct(
        Context $context,
        AdditionalDescriptionRepositoryInterface $descriptionRepository
    ) {
        parent::__construct($context);
        $this->descriptionRepository = $descriptionRepository;
    }

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(AdditionalDescriptionInterface::DESCRIPTION_ID, null);

        try {
            $this->descriptionRepository->getById((int)$id);
            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $result->getConfig()->getTitle()->prepend(__('Edit Additional description'));
        } catch (NoSuchEntityException $e) {
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Could not find Additional description'));

            return $result->setPath('*/*');
        }

        return $result;
    }
}
