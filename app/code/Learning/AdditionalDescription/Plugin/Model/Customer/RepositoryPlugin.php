<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Customer;

use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterfaceFactory;
use Learning\AdditionalDescription\Model\AllowAddDescription;
use Learning\AdditionalDescription\Model\AllowAddDescriptionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class RepositoryPlugin
{
    /** @var AllowAddDescriptionRepositoryInterface */
    private $allowAddDescriptionRepository;

    /** @var AllowAddDescriptionInterface */
    private $allowAddDescriptionFactory;

    /** @var Http */
    private $request;

    /**
     * RepositoryPlugin constructor.
     *
     * @param AllowAddDescriptionRepositoryInterface $allowAddDescriptionRepository
     * @param AllowAddDescriptionFactory    $allowAddDescriptionFactory
     */
    public function __construct(
        AllowAddDescriptionRepositoryInterface $allowAddDescriptionRepository,
        AllowAddDescriptionInterfaceFactory $allowAddDescriptionFactory
    ) {
        $this->allowAddDescriptionRepository = $allowAddDescriptionRepository;
        $this->allowAddDescriptionFactory = $allowAddDescriptionFactory;
        $this->request = ObjectManager::getInstance()->get(Http::class);
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     */
    public function afterGet(
        CustomerRepositoryInterface $subject,
        CustomerInterface $entity
    ) {
        return $this->extendCustomer($entity);
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     */
    public function afterGetById(
        CustomerRepositoryInterface $subject,
        CustomerInterface $entity
    ) {
        return $this->extendCustomer($entity);
    }

    /**
     * @param CustomerRepositoryInterface    $subject
     * @param CustomerSearchResultsInterface $searchCriteria
     *
     * @return CustomerSearchResultsInterface
     */
    public function afterGetList(
        CustomerRepositoryInterface $subject,
        CustomerSearchResultsInterface $searchCriteria
    ): CustomerSearchResultsInterface {
        $customers = [];

        foreach ($searchCriteria->getItems() as $entity) {
            $customers[] = $this->extendCustomer($entity);
        }

        $searchCriteria->setItems($customers);

        return $searchCriteria;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $entity
    ) {
        return $this->createOrUpdateAllowDescription($entity);
    }

    /**
     * Add extension attribute to model.
     *
     * @param CustomerInterface $customer
     *
     * @return CustomerInterface
     */
    private function extendCustomer(CustomerInterface $customer): CustomerInterface
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getAllowAddDescription()) {
            return $customer;
        }

        try {
            /** @var AllowAddDescriptionInterface $allowAddDescription */
            $allowAddDescription = $this->allowAddDescriptionRepository->get($customer->getEmail());
        } catch (NoSuchEntityException $e) {
            return $customer;
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        $extensionAttributes->setAllowAddDescription($allowAddDescription);
        $customer->setExtensionAttributes($extensionAttributes);

        return $customer;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return CustomerInterface
     */
    private function createOrUpdateAllowDescription(CustomerInterface $customer): CustomerInterface
    {
        $customerData = $this->request->getPostValue('customer');
        $allowAddDescriptionValue =
            (bool)(int)$customerData[AllowAddDescriptionInterface::ALLOW_ADD_DESCRIPTION] ?? false;
        $extensionAttributes = $customer->getExtensionAttributes();
        $allowAddDescription = $extensionAttributes->getAllowAddDescription();

        // Create AllowAddDescription if not exist
        if ($allowAddDescription === null) {
            /** @var AllowAddDescription $allowAddDescription */
            $allowAddDescription = $this->allowAddDescriptionFactory->create();
            $allowAddDescription->setCustomerEmail($customer->getEmail());
        }

        // Update AllowAddDescription
        $allowAddDescription->setAllowAddDescription($allowAddDescriptionValue);
        try {
            $allowAddDescription = $this->allowAddDescriptionRepository->save($allowAddDescription);
            $extensionAttributes->setAllowAddDescription($allowAddDescription);
            $customer->setExtensionAttributes($extensionAttributes);
        } catch (CouldNotSaveException|NoSuchEntityException $e) {
            return $customer;
        }

        return $customer;
    }
}
