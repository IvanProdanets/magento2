<?php

namespace Learning\AdditionalDescription\Plugin\Catalog\Model\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class RepositoryPlugin
{
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $ourCustomData = $this->customDataRepository->get($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();
        /** get current extension attributes from entity **/
        $extensionAttributes->setOurCustomData($ourCustomData);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
    }

    public function afterSave
    (
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes(); /** get current extension attributes from entity **/
        $ourCustomData = $extensionAttributes->getOurCustomData();
        $this->customDataRepository->save($ourCustomData);

        return $entity;
    }
}
