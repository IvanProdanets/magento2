<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractModel;

class AllowAddDescription extends AbstractModel implements AllowAddDescriptionInterface
{

    /**
     * Retrieve permission id.
     *
     * @return int|null
     */
    public function getPermissionId(): ?int
    {
        return $this->getData(self::PERMISSION_ID);
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
    public function getAllowAddDescription(): ?bool
    {
        return $this->getData(self::ALLOW_ADD_DESCRIPTION);
    }

    /**
     * Set permission add description for customer.
     *
     * @param bool|null $allow
     *
     * @return AllowAddDescriptionInterface
     */
    public function setAllowAddDescription(?bool $allow): AllowAddDescriptionInterface
    {
        return $this->setData(self::ALLOW_ADD_DESCRIPTION, $allow);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return ExtensionAttributesInterface|null
     */
    public function getExtensionAttributes(): ?ExtensionAttributesInterface
    {
        // TODO: Implement getExtensionAttributes() method.
    }

    /**
     * Set an extension attributes object.
     *
     * @param ExtensionAttributesInterface $extensionAttributes
     *
     * @return AllowAddDescriptionInterface
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): AllowAddDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
