<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 *  Customer allow add description interface.
 */
interface AllowAddDescriptionInterface extends ExtensibleDataInterface
{
    const PERMISSION_ID = 'id';

    const ALLOW_ADD_DESCRIPTION = 'allow_add_description';

    const CUSTOMER_EMAIL = 'customer_email';

    /**
     * Retrieve permission id.
     *
     * @return int|null
     */
    public function getPermissionId(): ?int;

    /**
     * Set permission id.
     *
     * @param int|null $id
     *
     * @return AllowAddDescriptionInterface
     */
    public function setPermissionId(?int $id): AllowAddDescriptionInterface;

    /**
     * Retrieve permission to add description for customer.
     *
     * @return bool|null
     */
    public function getAllowAddDescription(): ?bool;

    /**
     * Set permission add description for customer.
     *
     * @param bool|null $allow
     *
     * @return AllowAddDescriptionInterface
     */
    public function setAllowAddDescription(?bool $allow): AllowAddDescriptionInterface;

    /**
     * Retrieve customer email.
     *
     * @return string|null
     */
    public function getCustomerEmail(): ?string;

    /**
     * Set customer email.
     *
     * @param string|null $email
     *
     * @return AllowAddDescriptionInterface
     */
    public function setCustomerEmail(?string $email): AllowAddDescriptionInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Learning\AdditionalDescription\Api\Data\AllowAddDescriptionExtensionInterface|null
     */
    public function getExtensionAttributes():
        ?\Learning\AdditionalDescription\Api\Data\AllowAddDescriptionExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Learning\AdditionalDescription\Api\Data\AllowAddDescriptionExtensionInterface $extensionAttributes
     *
     * @return AllowAddDescriptionInterface
     */
    public function setExtensionAttributes(
        \Learning\AdditionalDescription\Api\Data\AllowAddDescriptionExtensionInterface $extensionAttributes
    ): AllowAddDescriptionInterface;
}
