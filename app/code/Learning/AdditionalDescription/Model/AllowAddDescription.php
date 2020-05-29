<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionExtensionInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Model\ResourceModel\AllowAddDescription as AllowAddDescriptionResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Allow add description model.
 */
class AllowAddDescription extends AbstractExtensibleModel implements AllowAddDescriptionInterface
{

    /**
     * Model initialization.
     */
    protected function _construct(): void
    {
        $this->_init(AllowAddDescriptionResourceModel::class);
    }

    /**
     * Retrieve permission id.
     *
     * @return int|null
     */
    public function getPermissionId(): ?int
    {
        return (int)$this->getData(self::PERMISSION_ID);
    }

    /**
     * Set permission id.
     *
     * @param int|null $id
     *
     * @return AllowAddDescriptionInterface
     */
    public function setPermissionId(?int $id): AllowAddDescriptionInterface
    {
        return $this->setData(self::PERMISSION_ID, $id);
    }

    /**
     * Retrieve permission to add description for customer.
     *
     * @return bool|null
     */
    public function getIsAllowed(): ?bool
    {
        return (bool)$this->getData(self::ALLOW_ADD_DESCRIPTION);
    }

    /**
     * Set permission add description for customer.
     *
     * @param bool|null $allow
     *
     * @return AllowAddDescriptionInterface
     */
    public function setIsAllowed(?bool $allow): AllowAddDescriptionInterface
    {
        return $this->setData(self::ALLOW_ADD_DESCRIPTION, $allow);
    }


    /**
     * Retrieve customer email.
     *
     * @return string|null
     */
    public function getCustomerEmail(): ?string
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer email.
     *
     * @param string|null $email
     *
     * @return AllowAddDescriptionInterface
     */
    public function setCustomerEmail(?string $email): AllowAddDescriptionInterface
    {
        return $this->setData(self::CUSTOMER_EMAIL, $email);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return AllowAddDescriptionExtensionInterface|null
     */
    public function getExtensionAttributes(): ?AllowAddDescriptionExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param AllowAddDescriptionExtensionInterface $extensionAttributes
     *
     * @return AllowAddDescriptionInterface
     */
    public function setExtensionAttributes(
        AllowAddDescriptionExtensionInterface $extensionAttributes
    ): AllowAddDescriptionInterface {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
