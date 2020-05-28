<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Controller\Index;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterfaceFactory;
use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Learning\AdditionalDescription\Service\CurrentCustomerService;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Webapi\Response;

/**
 * Storefront Save action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /** @var AdditionalDescriptionRepository */
    private $repository;

    /** @var AdditionalDescriptionInterface */
    private $additionalDescription;

    /** @var CurrentCustomerService */
    private $customerService;

    /** @var Validator */
    private $validator;

    /**
     * Save constructor.
     *
     * @param Context                               $context
     * @param AdditionalDescriptionRepository       $repository
     * @param AdditionalDescriptionInterfaceFactory $factory
     * @param CurrentCustomerService                $customerService
     * @param Validator                             $validator
     */
    public function __construct(
        Context $context,
        AdditionalDescriptionRepository $repository,
        AdditionalDescriptionInterfaceFactory $factory,
        CurrentCustomerService $customerService,
        Validator $validator
    ) {
        parent::__construct($context);
        $this->additionalDescription = $factory;
        $this->repository            = $repository;
        $this->customerService       = $customerService;
        $this->validator             = $validator;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /** @var Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $this->validateRequest();
        } catch (AuthenticationException|ValidationException $e) {
            $result->setHttpResponseCode(Response::STATUS_CODE_500);
            $result->setData([ 'error' => $e->getMessage() ]);

            return $result;
        }

        try {
            $value = $this->_request->getParam(AdditionalDescriptionInterface::ADDITIONAL_DESCRIPTION);
            if ($id = $this->_request->getParam('description_id')) {
                $additionalDescription = $this->repository->getById((int) $id);
            } else {
                /** @var AdditionalDescription $additionalDescription */
                $additionalDescription = $this->additionalDescription->create();
                $additionalDescription->setCustomerEmail($this->customerService->getCustomer()->getEmail());
                $additionalDescription->setProductId((int) $this->_request->getParam('product_id', 0));
            }
            $additionalDescription->setAdditionalDescription($value);

            $this->repository->save($additionalDescription);
            $result->setHttpResponseCode(Response::HTTP_OK);
            $result->setData(['success' => __('Additional description has been saved')]);
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            $result->setHttpResponseCode(Response::STATUS_CODE_500);
            $result->setData([ 'error' => $e->getMessage() ]);
        }

        return $result;
    }

    /**
     * @throws AuthenticationException
     * @throws ValidationException
     */
    private function validateRequest(): void
    {
        if (!$this->validator->validate($this->_request)) {
            throw new ValidationException(__('Invalid form data'));
        }

        if (!$this->_request->getParam('product_id')) {
            throw new ValidationException(__('Invalid request params'));
        }

        if (!$this->customerService->canCustomerAddDescription()) {
            throw new AuthenticationException(
                __('You dont have right permission to edit additional description')
            );
        }
    }
}
