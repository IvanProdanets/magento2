<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Product;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Product attributes load plugin.
 */
class AttributesLoad
{
    /** @var ProductExtensionFactory */
    private $extensionFactory;

    /**
     * CustomerAttributesLoad constructor.
     *
     * @param ProductExtensionFactory $extensionFactory
     */
    public function __construct(ProductExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Loads product entity extension attributes.
     *
     * @param ProductInterface $entity
     * @param ProductExtensionInterface|null $extension
     * @return ProductExtensionInterface
     */
    public function afterGetExtensionAttributes(
        ProductInterface $entity,
        ProductExtensionInterface $extension = null
    ): ProductExtensionInterface {
        return $extension ?? $this->extensionFactory->create();
    }
}
