<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Catalog\Model\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

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

    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $additionalDescription = $this->additionalDescriptionRepository->getById($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();
        /** get current extension attributes from entity **/
        $extensionAttributes->setOurCustomData($additionalDescription);
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
