<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\AdditionalDescriptionManagementInterface;
use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterfaceFactory;
use Learning\AdditionalDescription\Service\CurrentCustomerService;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Backup\Exception\NotEnoughPermissions;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class AdditionalDescriptionManagement implements AdditionalDescriptionManagementInterface
{
    /** @var CurrentCustomerService */
    private $customer;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var AdditionalDescriptionRepositoryInterface */
    private $descriptionRepository;

    /** @var AdditionalDescriptionInterfaceFactory */
    private $additionalDescriptionFactory;

    public function __construct(
        CurrentCustomerService $customerService,
        AdditionalDescriptionRepositoryInterface $descriptionRepository,
        ProductRepositoryInterface $productRepository,
        AdditionalDescriptionInterfaceFactory $additionalDescriptionFactory
    ) {
        $this->customer                     = $customerService;
        $this->descriptionRepository        = $descriptionRepository;
        $this->productRepository            = $productRepository;
        $this->additionalDescriptionFactory = $additionalDescriptionFactory;
    }

    /**
     * @param AdditionalDescriptionInterface $additionalDescription
     *
     * @return AdditionalDescriptionInterface|string
     */
    public function save(AdditionalDescriptionInterface $additionalDescription)
    {
        try {
            $this->validate();
            return $this->descriptionRepository->save($additionalDescription);
        } catch (NotEnoughPermissions|NoSuchEntityException|CouldNotSaveException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return bool
     * @throws NotEnoughPermissions
     */
    private function validate(): bool
    {
        if (!$this->customer->canUserAddDescription()) {
            throw new NotEnoughPermissions(__('You don\'t have permission to edit additional description'));
        }

        return true;
    }
}
