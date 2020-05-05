<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Customer;

use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class RepositoryPlugin
{
    /** @var AllowAddDescriptionRepositoryInterface */
    private $allowAddDescriptionRepository;

    /**
     * RepositoryPlugin constructor.
     *
     * @param AllowAddDescriptionRepositoryInterface $allowAddDescriptionRepository
     */
    public function __construct(AllowAddDescriptionRepositoryInterface $allowAddDescriptionRepository)
    {
        $this->allowAddDescriptionRepository = $allowAddDescriptionRepository;
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
        $data = $extensionAttributes->getAllowAddDescription();
        $this->allowAddDescriptionRepository->save($data);

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
}
