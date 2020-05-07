<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class RepositoryPlugin
{
    /** @var AdditionalDescriptionRepositoryInterface */
    private $additionalDescriptionRepository;

    /**
     * RepositoryPlugin constructor.
     *
     * @param AdditionalDescriptionRepositoryInterface $additionalDescriptionRepository
     */
    public function __construct(AdditionalDescriptionRepositoryInterface $additionalDescriptionRepository)
    {
        $this->additionalDescriptionRepository = $additionalDescriptionRepository;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface           $entity
     *
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        return $this->extendProduct($entity);
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface           $entity
     *
     * @return ProductInterface
     */
    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        return $this->extendProduct($entity);
    }

//    /**
//     * @param ProductRepositoryInterface $subject
//     * @param ProductInterface           $entity
//     *
//     * @return ProductInterface
//     */
//    public function afterSave
//    (
//        ProductRepositoryInterface $subject,
//        ProductInterface $entity
//    ) {
//        $extensionAttributes = $entity->getExtensionAttributes(); /** get current extension attributes from entity **/
//        $ourCustomData = $extensionAttributes->getOurCustomData();
//        $this->customDataRepository->save($ourCustomData);
//
//        return $entity;
//    }

    /**
     * Add extension attribute to model.
     *
     * @param ProductInterface $product
     *
     * @return ProductInterface
     */
    private function extendProduct(ProductInterface $product): ProductInterface
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if ($extensionAttributes && $extensionAttributes->getAdditionalDescription()) {
            return $product;
        }

        try {
            /** @var AdditionalDescriptionInterface $additionalDescription */
            $additionalDescription = $this->additionalDescriptionRepository->get($product->getId());
        } catch (NoSuchEntityException $e) {
            return $product;
        }

        $extensionAttributes = $product->getExtensionAttributes();
        $extensionAttributes->setAdditionalDescription($additionalDescription);
        $product->setExtensionAttributes($extensionAttributes);

        return $product;
    }
}
