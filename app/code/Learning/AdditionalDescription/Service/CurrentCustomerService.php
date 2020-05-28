<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Service;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Current customer service.
 */
class CurrentCustomerService
{
    /** @var ManagerInterface */
    private $messageManager;

    /** @var Session */
    private $customerSession;

    /** @var CustomerInterface */
    private $currentCustomer;

    /** @var UserContextInterface */
    private $userContext;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /**
     * CurrentCustomerService constructor.
     *
     * @param UserContextInterface        $userContext
     * @param Session                     $customerSession
     * @param ManagerInterface            $messageManager
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        UserContextInterface $userContext,
        Session $customerSession,
        ManagerInterface $messageManager,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->userContext        = $userContext;
        $this->customerSession    = $customerSession;
        $this->messageManager     = $messageManager;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get the logged in customer
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {

        if ($this->currentCustomer) {
            return $this->currentCustomer;
        }

        if ($customerId = $this->userContext->getUserId())
        {
            try {
                $this->currentCustomer = $this->customerRepository->getById($customerId);

                return $this->currentCustomer;
            } catch (NoSuchEntityException|LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        if (!$this->customerSession->isLoggedIn()) {
            return null;
        }

        try {
            $this->currentCustomer = $this->customerSession->getCustomerData();
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return null;
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

        if ($allowDescription = $customer->getExtensionAttributes()->getAllowAddDescription()) {
            return $allowDescription->getIsAllowed();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function canAdminAddDescription(): bool
    {
        return true;
    }
}
