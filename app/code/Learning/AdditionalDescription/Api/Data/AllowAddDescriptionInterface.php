<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

/**
 *  Customer allow add description interface.
 */
interface AllowAddDescriptionInterface extends ExtensibleDataInterface
{
    const PERMISSION_ID = 'id';

    const ALLOW_ADD_DESCRIPTION = 'permission_id';

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
     * @return AllowAddDescriptionInterface
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): AllowAddDescriptionInterface;
}
