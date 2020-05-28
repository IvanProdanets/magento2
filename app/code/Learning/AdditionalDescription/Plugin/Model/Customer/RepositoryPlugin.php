<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Customer;

use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterfaceFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Customer Repository plugin.
 */
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
     * @param CustomerInterface           $result
     * @param CustomerInterface           $customer
     *
     * @return CustomerInterface
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer
    ) {
        $extensionAttributes = $customer->getExtensionAttributes();
        $allowAddDescription = $extensionAttributes->getAllowAddDescription();

        // Nothing to save.
        if (!($allowAddDescription && $this->isAllowedAddDescription())) {
            return $result;
        }

        $allowAddDescription = $this->saveAllowDescription($allowAddDescription, $result);
        $extensionAttributes->setAllowAddDescription($allowAddDescription);
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * Plugin around delete customer that delete allowAddDescription if exist.
     *
     * @param CustomerRepositoryInterface $subject
     * @param callable                    $deleteCustomerById Function we are wrapping around
     * @param int                         $customerId         Input to the function
     *
     * @return bool
     * @throws NoSuchEntityException|CouldNotDeleteException|LocalizedException
     */
    public function aroundDeleteById(
        CustomerRepositoryInterface $subject,
        callable $deleteCustomerById,
        $customerId
    ) {
        $customer            = $subject->getById($customerId);
        $result              = $deleteCustomerById($customerId);
        $allowAddDescription = $customer->getExtensionAttributes()->getAllowAddDescription();

        if ($allowAddDescription && $permissionId = $allowAddDescription->getPermissionId()) {
            $this->allowAddDescriptionRepository->deleteById($permissionId);
        }

        return $result;
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
        // Get allow add description if exist.
        try {
            $newAllowAddDescription = $this->allowAddDescriptionRepository->get($customer->getEmail());
        } catch (NoSuchEntityException $e) {
            $newAllowAddDescription = $this->allowAddDescriptionFactory->create();
            $newAllowAddDescription->setCustomerEmail($customer->getEmail());
        }
        $newAllowAddDescription->setIsAllowed($allowAddDescription->getIsAllowed() ?? false);

        // Update AllowAddDescription.
        if ($this->isAllowedAddDescription()) {
            $newAllowAddDescription->setIsAllowed(true);
        }

        try {
            $newAllowAddDescription = $this->allowAddDescriptionRepository->save($newAllowAddDescription);
        } catch (NoSuchEntityException|CouldNotSaveException $e) {
            // Do nothing.
        }

        return $newAllowAddDescription;
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
