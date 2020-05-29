<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Service;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Current user service.
 */
class CurrentUserService
{
    /** @var ManagerInterface */
    private $messageManager;

    /** @var CustomerInterface */
    private $currentCustomer;

    /** @var UserContextInterface */
    private $userContext;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /**
     * CurrentUserService constructor.
     *
     * @param UserContextInterface        $userContext
     * @param ManagerInterface            $messageManager
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        UserContextInterface $userContext,
        ManagerInterface $messageManager,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->userContext        = $userContext;
        $this->messageManager     = $messageManager;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get the logged in customer.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        if ($this->currentCustomer) {
            return $this->currentCustomer;
        }

        $customerId = $this->userContext->getUserId();
        if ($customerId === null) {
            return null;
        }

        try {
            $this->currentCustomer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->currentCustomer;
    }

    /**
     * @return bool
     */
    public function canUserAddDescription(): bool
    {
        switch ($this->userContext->getUserType()) {
            case UserContextInterface::USER_TYPE_ADMIN:
                $permission = $this->canAdminAddDescription();
                break;
            case UserContextInterface::USER_TYPE_CUSTOMER:
                $permission = $this->canCustomerAddDescription();
                break;
            default:
                $permission = false;
        }

        return $permission;
    }

    /**
     * @return bool
     */
    public function canCustomerAddDescription(): bool
    {
        if (!$customer = $this->getCustomer()) {
            return false;
        }

        $allowDescription = $customer->getExtensionAttributes()->getAllowAddDescription();

        return $allowDescription ? $allowDescription->getIsAllowed() : false;
    }

    /**
     * @return bool
     */
    public function canAdminAddDescription(): bool
    {
        return true;
    }
}
