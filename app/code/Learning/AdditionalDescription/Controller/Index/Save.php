<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Controller\Index;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterfaceFactory;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Learning\AdditionalDescription\Service\CurrentCustomerService;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends Action implements HttpPostActionInterface
{
    /** @var AdditionalDescriptionRepository */
    private $repository;

    /** @var SearchCriteriaBuilder */
    private $criteriaBuilder;

    /** @var AdditionalDescriptionInterface */
    private $additionalDescription;

    /** @var CurrentCustomerService */
    private $customerService;

    public function __construct(
        Context $context,
        AdditionalDescriptionRepository $repository,
        SearchCriteriaBuilder $criteriaBuilder,
        AdditionalDescriptionInterfaceFactory $factory,
        CurrentCustomerService $customerService
    ) {
        parent::__construct($context);
        $this->additionalDescription = $factory;
        $this->repository            = $repository;
        $this->criteriaBuilder       = $criteriaBuilder;
        $this->customerService       = $customerService;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NoSuchEntityException|CouldNotSaveException
     */
    public function execute()
    {
        $redirectUrl = $this->_redirect->getRefererUrl();

        if (!$this->customerService->canCustomerAddDescription()) {
            return $this->_redirect($redirectUrl);
        }

        $value = $this->_request->getParam('additional_description');
        if ($id = $this->_request->getParam('description_id')) {
            $additionalDescription = $this->repository->getById((int) $id);
        } else {
            $additionalDescription = $this->additionalDescription->create();
            $additionalDescription->setCustomerEmail($this->customerService->getCustomer()->getEmail());
        }
        $additionalDescription->setAdditionalDescription($value);

        $this->repository->save($additionalDescription);

        return $this->_redirect($redirectUrl);
    }
}
