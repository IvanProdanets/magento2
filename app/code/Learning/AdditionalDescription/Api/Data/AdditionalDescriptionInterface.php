<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 *  Product additional description entity interface.
 */
interface AdditionalDescriptionInterface extends ExtensibleDataInterface
{
    const DESCRIPTION_ID = 'id';

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
     * Set product additional description id.
     *
     * @param int|null $id
     *
     * @return AdditionalDescriptionInterface
     */
    public function setAdditionalDescriptionId(?int $id): AdditionalDescriptionInterface;

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
     * @return AdditionalDescriptionInterface
     */
    public function setCustomerEmail(?string $email): AdditionalDescriptionInterface;

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
     * @return AdditionalDescriptionInterface
     */
    public function setAdditionalDescription(?string $description): AdditionalDescriptionInterface;

    /**
     * Retrieve product entity id.
     *
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set product entity id.
     *
     * @param int $id
     *
     * @return AdditionalDescriptionInterface
     */
    public function setProductId(int $id): AdditionalDescriptionInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Learning\AdditionalDescription\Api\Data\AdditionalDescriptionExtensionInterface
     * $extensionAttributes|null
     */
    public function getExtensionAttributes():
        ?\Learning\AdditionalDescription\Api\Data\AdditionalDescriptionExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Learning\AdditionalDescription\Api\Data\AdditionalDescriptionExtensionInterface $extensionAttributes
     *
     * @return AdditionalDescriptionInterface
     */
    public function setExtensionAttributes(
        \Learning\AdditionalDescription\Api\Data\AdditionalDescriptionExtensionInterface $extensionAttributes
    ): AdditionalDescriptionInterface;
}
