<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Service;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class CurrentCustomerService
{
    /** @var ManagerInterface */
    private $messageManager;

    /** @var Session */
    private $customerSession;

    /** @var CustomerInterface */
    private $currentCustomer;

    /**
     * CurrentCustomerService constructor.
     *
     * @param Session          $customerSession
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Session $customerSession,
        ManagerInterface $messageManager
    ) {
        $this->messageManager  = $messageManager;
        $this->customerSession = $customerSession;
    }

    /**
     * Get the logged in customer
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        if (!$this->customerSession->isLoggedIn()) {
            return null;
        }

        if ($this->currentCustomer) {
            return $this->currentCustomer;
        }

        try {
            $this->currentCustomer = $this->customerSession->getCustomerData();
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->currentCustomer = null;

            return null;
        }

        return $this->currentCustomer;
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
}
