<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

/**
 *  Product additional description entity interface.
 */
interface ProductAdditionalDescriptionInterface extends ExtensibleDataInterface
{
    const ADDITIONAL_DESCRIPTION_ID = 'id';

    const CUSTOMER_EMAIL = 'customer_email';

    const ADDITIONAL_DESCRIPTION = 'additional_description';

    const PRODUCT_ID = 'product_id';

    /**
     * Retrieve product additional description id.
     *
     * @return int|null
     */
    public function getAdditionalDescriptionId(): ?int;

    /**
     * Set product additional description id
     *
     * @param int|null $id
     *
     * @return ProductAdditionalDescriptionInterface
     */
    public function setAdditionalDescriptionId(?int $id): ProductAdditionalDescriptionInterface;

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
     * @return ProductAdditionalDescriptionInterface
     */
    public function setCustomerEmail(?string $email): ProductAdditionalDescriptionInterface;

    /**
     * Get product additional description.
     *
     * @return string|null
     */
    public function getAdditionalDescription(): ?string;

    /**
     * Set product additional description.
     *
     * @param string|null $description
     *
     * @return ProductAdditionalDescriptionInterface
     */
    public function setAdditionalDescription(?string $description): ProductAdditionalDescriptionInterface;

    /**
     * Retrieve product entity id.
     *
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set product entity id.
     *
     * @return ProductAdditionalDescriptionInterface
     */
    public function setProductId(): ProductAdditionalDescriptionInterface;

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
     * @return ProductAdditionalDescriptionInterface
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): ProductAdditionalDescriptionInterface;
}
