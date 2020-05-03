<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractModel;

class AllowAddDescription extends AbstractModel implements AllowAddDescriptionInterface
{

    /**
     * @inheritDoc
     */
    public function getPermissionId(): ?int
    {
        return $this->getData(self::PERMISSION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPermissionId(?int $id): AllowAddDescriptionInterface
    {
        return $this->setData(self::PERMISSION_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getAllowAddDescription(): ?bool
    {
        return $this->getData(self::ALLOW_ADD_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setAllowAddDescription(?bool $allow): AllowAddDescriptionInterface
    {
        return $this->setData(self::ALLOW_ADD_DESCRIPTION, $allow);
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
    ): AllowAddDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
