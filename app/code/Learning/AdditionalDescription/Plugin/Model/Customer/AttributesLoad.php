<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Customer;

use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Customer attributes load plugin.
 */
class AttributesLoad
{
    /** @var CustomerExtensionFactory */
    private $extensionFactory;

    /**
     * CustomerAttributesLoad constructor.
     *
     * @param CustomerExtensionFactory $extensionFactory
     */
    public function __construct(CustomerExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Loads customer entity extension attributes
     *
     * @param CustomerInterface $entity
     * @param CustomerExtensionInterface|null $extension
     * @return CustomerExtensionInterface
     */
    public function afterGetExtensionAttributes(
        CustomerInterface $entity,
        CustomerExtensionInterface $extension = null
    ) {
        return $extension ?? $this->extensionFactory->create();
    }
}
