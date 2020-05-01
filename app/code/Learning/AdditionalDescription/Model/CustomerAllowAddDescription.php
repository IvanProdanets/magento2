<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\CustomerAllowAddDescriptionInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

class CustomerAllowAddDescription implements CustomerAllowAddDescriptionInterface
{

    /**
     * @inheritDoc
     */
    public function getPermissionId(): ?int
    {
        // TODO: Implement getPermissionId() method.
    }

    /**
     * @inheritDoc
     */
    public function setPermissionId(?int $id): CustomerAllowAddDescriptionInterface
    {
        // TODO: Implement setPermissionId() method.
    }

    /**
     * @inheritDoc
     */
    public function getAllowAddDescription(): ?bool
    {
        // TODO: Implement getAllowAddDescription() method.
    }

    /**
     * @inheritDoc
     */
    public function setAllowAddDescription(?bool $allow): CustomerAllowAddDescriptionInterface
    {
        // TODO: Implement setAllowAddDescription() method.
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes(): ?ExtensionAttributesInterface
    {
        // TODO: Implement getExtensionAttributes() method.
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): CustomerAllowAddDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
