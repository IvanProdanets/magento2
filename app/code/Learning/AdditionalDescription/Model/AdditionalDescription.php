<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractModel;

class AdditionalDescription extends AbstractModel implements AdditionalDescriptionInterface
{

    /**
     * Retrieve product additional description id.
     *
     * @return int|null
     */
    public function getAdditionalDescriptionId(): ?int
    {
        return $this->getData(self::DESCRIPTION_ID);
    }

    /**
     * Set product additional description id.
     *
     * @param int|null $id
     *
     * @return AdditionalDescriptionInterface
     */
    public function setAdditionalDescriptionId(?int $id): AdditionalDescriptionInterface
    {
        return $this->setData(self::DESCRIPTION_ID, $id);
    }

//    /**
//     * @inheritDoc
//     */
//    public function getCustomerEmail(): ?string
//    {
//        // TODO: Implement getCustomerEmail() method.
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function setCustomerEmail(?string $email): ProductAdditionalDescriptionInterface
//    {
//        // TODO: Implement setCustomerEmail() method.
//    }

    /**
     * @inheritDoc
     */
    public function getAdditionalDescription(): ?string
    {
        return $this->getData(self::ADDITIONAL_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setAdditionalDescription(?string $description): AdditionalDescriptionInterface
    {
        return $this->setData(self::ADDITIONAL_DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getProductId(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId(int $id): AdditionalDescriptionInterface
    {
        return $this->setData(self::PRODUCT_ID, $id);
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
    ): AdditionalDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
