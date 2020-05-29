<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\AdditionalDescriptionManagementInterface;
use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Service\CurrentUserService;
use Magento\Framework\Backup\Exception\NotEnoughPermissions;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class AdditionalDescriptionManagement implements AdditionalDescriptionManagementInterface
{
    /** @var CurrentUserService */
    private $customer;

    /** @var AdditionalDescriptionRepositoryInterface */
    private $descriptionRepository;

    /**
     * AdditionalDescriptionManagement constructor.
     *
     * @param CurrentUserService                       $currentUser
     * @param AdditionalDescriptionRepositoryInterface $descriptionRepository
     */
    public function __construct(
        CurrentUserService $currentUser,
        AdditionalDescriptionRepositoryInterface $descriptionRepository
    ) {
        $this->customer              = $currentUser;
        $this->descriptionRepository = $descriptionRepository;
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
