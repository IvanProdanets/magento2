<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Model;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\ResourceModel\AdditionalDescription as AdditionalDescriptionResourceModel;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractModel;

class AdditionalDescription extends AbstractModel implements AdditionalDescriptionInterface
{
    /**
     * Model initialization.
     */
    protected function _construct()
    {
        $this->_init(AdditionalDescriptionResourceModel::class);
    }

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

    /**
     * Retrieve customer email.
     *
     * @return string|null
     */
    public function getCustomerEmail(): ?string
    {
        // TODO: Implement getCustomerEmail() method.
    }

    /**
     * Set customer email.
     *
     * @param string|null $email
     *
     * @return AdditionalDescriptionInterface
     */
    public function setCustomerEmail(?string $email): AdditionalDescriptionInterface
    {
        // TODO: Implement setCustomerEmail() method.
    }

    /**
     * Get product additional description.
     *
     * @return string|null
     */
    public function getAdditionalDescription(): ?string
    {
        return $this->getData(self::ADDITIONAL_DESCRIPTION);
    }

    /**
     * Set product additional description.
     *
     * @param string|null $description
     *
     * @return AdditionalDescriptionInterface
     */
    public function setAdditionalDescription(?string $description): AdditionalDescriptionInterface
    {
        return $this->setData(self::ADDITIONAL_DESCRIPTION, $description);
    }

    /**
     * Retrieve product entity id.
     *
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set product entity id.
     *
     * @param int $id
     *
     * @return AdditionalDescriptionInterface
     */
    public function setProductId(int $id): AdditionalDescriptionInterface
    {
        return $this->setData(self::PRODUCT_ID, $id);
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
     * @return AdditionalDescriptionInterface
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ): AdditionalDescriptionInterface {
        // TODO: Implement setExtensionAttributes() method.
    }
}
