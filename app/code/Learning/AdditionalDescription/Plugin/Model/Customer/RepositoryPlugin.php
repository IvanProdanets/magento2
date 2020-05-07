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
     * @param AllowAddDescriptionInterfaceFactory    $allowAddDescriptionFactory
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
        $extensionAttributes = $entity->getExtensionAttributes();
        $allowAddDescription = $extensionAttributes->getAllowAddDescription();

        $allowAddDescription = $this->saveAllowDescription($allowAddDescription, $entity);
        $extensionAttributes->setAllowAddDescription($allowAddDescription);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
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
     * Save AllowAddDescription in DB.
     *
     * @param AllowAddDescriptionInterface|null $allowAddDescription
     * @param CustomerInterface                 $customer
     *
     * @return AllowAddDescriptionInterface
     */
    private function saveAllowDescription(
        ?AllowAddDescriptionInterface $allowAddDescription,
        CustomerInterface $customer
    ): AllowAddDescriptionInterface {
        // Create AllowAddDescription if not exist.
        if ($allowAddDescription === null) {
            /** @var AllowAddDescription $allowAddDescription */
            $allowAddDescription = $this->allowAddDescriptionFactory->create();
            $allowAddDescription->setCustomerEmail($customer->getEmail());
        }

        // Update AllowAddDescription.
        $allowAddDescription->setAllowAddDescription($this->isAllowedAddDescription());

        try {
            $allowAddDescription = $this->allowAddDescriptionRepository->save($allowAddDescription);
        } catch (CouldNotSaveException|NoSuchEntityException $e) {
            // Do nothing.
        }

        return $allowAddDescription;
    }

    /**
     * Get AllowAddDescription from request. FALSE by default.
     *
     * @return bool
     */
    private function isAllowedAddDescription(): bool
    {
        $customerData = $this->request->getPostValue('customer');

        return (bool) (int) $customerData[AllowAddDescriptionInterface::ALLOW_ADD_DESCRIPTION] ?? false;
    }
}
