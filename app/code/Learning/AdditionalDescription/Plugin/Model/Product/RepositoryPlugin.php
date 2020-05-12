<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Product;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Service\CurrentCustomerService;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class RepositoryPlugin
{
    /** @var AdditionalDescriptionRepositoryInterface */
    private $additionalDescriptionRepository;

    /** @var SearchCriteriaBuilder */
    private $criteriaBuilder;

    /** @var CurrentCustomerService */
    private $customerService;

    /** @var ManagerInterface */
    private $messageManager;

    /**
     * RepositoryPlugin constructor.
     *
     * @param AdditionalDescriptionRepositoryInterface $additionalDescriptionRepository
     * @param SearchCriteriaBuilder                    $criteriaBuilder
     * @param CurrentCustomerService                   $customerService
     */
    public function __construct(
        AdditionalDescriptionRepositoryInterface $additionalDescriptionRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        CurrentCustomerService $customerService,
        ManagerInterface $messageManager
    ) {
        $this->additionalDescriptionRepository = $additionalDescriptionRepository;
        $this->criteriaBuilder                 = $criteriaBuilder;
        $this->customerService                 = $customerService;
        $this->messageManager                  = $messageManager;
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

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface           $entity
     *
     * @return ProductInterface
     */
    public function afterSave(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes();
        $additionalDescriptions = $extensionAttributes->getAdditionalDescriptions();

        $additionalDescriptions = $this->saveAdditionalDescriptions($additionalDescriptions, $entity);
        $extensionAttributes->setAdditionalDescriptions($additionalDescriptions);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
    }

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
        if ($extensionAttributes && !empty($extensionAttributes->getAdditionalDescriptions())) {
            return $product;
        }

        $extensionAttributes = $product->getExtensionAttributes();

        $extensionAttributes->setAdditionalDescriptions($this->getDescriptions($product));
        $product->setExtensionAttributes($extensionAttributes);

        return $product;
    }

    /**
     * @param ProductInterface $product
     *
     * @return ProductInterface[]
     */
    private function getDescriptions(ProductInterface $product): array
    {
        try {
            $criteria = $this->criteriaBuilder
                ->addFilter(AdditionalDescriptionInterface::PRODUCT_ID, $product->getId())
                ->create();

            return $this->additionalDescriptionRepository->getList($criteria)->getItems();
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }

    /**
     * @param array            $additionalDescriptions
     * @param ProductInterface $entity
     *
     * @return ProductInterface[]
     */
    private function saveAdditionalDescriptions(array $additionalDescriptions, ProductInterface $entity): array
    {
        foreach ($additionalDescriptions as $additionalDescription) {
            if ($additionalDescription instanceof AdditionalDescriptionInterface) {
                try {
                    $this->additionalDescriptionRepository->save($additionalDescription);
                } catch (NoSuchEntityException|CouldNotSaveException $e) {
                    $this->messageManager->addErrorMessage(
                        __(
                            'Could not save additionalDescription with ID %1',
                            $additionalDescription->getAdditionalDescriptionId()
                        )
                    );
                    continue;
                }
            }
        }

        return $this->getDescriptions($entity);
    }
}
