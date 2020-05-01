<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

/**
 *  Customer allow add description interface.
 */
interface CustomerAllowAddDescriptionInterface extends ExtensibleDataInterface
{
    const PERMISSION_ID = 'permission_id';

    const ALLOW_ADD_DESCRIPTION = 'allow_add_description';

//    const CUSTOMER_EMAIL = 'customer_email';

    const CUSTOMER_ID = 'customer_id';

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
     * @return CustomerAllowAddDescriptionInterface
     */
    public function setPermissionId(?int $id): CustomerAllowAddDescriptionInterface;

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
     * @return CustomerAllowAddDescriptionInterface
     */
    public function setAllowAddDescription(?bool $allow): CustomerAllowAddDescriptionInterface;

//    public function getCustomerEmail(): ?string;
//
//    public function setCustomerEmail(?string $email): CustomerAllowAddDescriptionInterface;


//    /**
//     * Retrieve customer email.
//     *
//     * @return string|null
//     */
//    public function getCustomerEmail(): ?string;
//
//    /**
//     * Set customer email.
//     *
//     * @param string|null $email
//     *
//     * @return ProductAdditionalDescriptionInterface
//     */
//    public function setCustomerEmail(?string $email): ProductAdditionalDescriptionInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return ExtensionAttributesInterface|null
     */
    public function getExtensionAttributes(): ?ExtensionAttributesInterface;

    /**
     * Set an extension attributes object.
     *
     * @param ExtensionAttributesInterface $extensionAttributes
     *
     * @return CustomerAllowAddDescriptionInterface
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): CustomerAllowAddDescriptionInterface;
}
