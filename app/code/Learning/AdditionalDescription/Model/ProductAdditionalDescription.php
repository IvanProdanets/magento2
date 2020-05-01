<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\ProductAdditionalDescriptionInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

class ProductAdditionalDescription implements ProductAdditionalDescriptionInterface
{

    /**
     * Retrieve product additional description id.
     *
     * @return int|null
     */
    public function getAdditionalDescriptionId(): ?int
    {
        // TODO: Implement getAdditionalDescriptionId() method.
    }

    /**
     * Set product additional description id.
     *
     * @param int|null $id
     *
     * @return ProductAdditionalDescriptionInterface
     */
    public function setAdditionalDescriptionId(?int $id): ProductAdditionalDescriptionInterface
    {
        // TODO: Implement setAdditionalDescriptionId() method.
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
        // TODO: Implement getAdditionalDescription() method.
    }

    /**
     * @inheritDoc
     */
    public function setAdditionalDescription(?string $description): ProductAdditionalDescriptionInterface
    {
        // TODO: Implement setAdditionalDescription() method.
    }

    /**
     * @inheritDoc
     */
    public function getProductId(): ?int
    {
        // TODO: Implement getProductId() method.
    }

    /**
     * @inheritDoc
     */
    public function setProductId(): ProductAdditionalDescriptionInterface
    {
        // TODO: Implement setProductId() method.
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
    ): ProductAdditionalDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
