<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Integration\Helper;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Model\AllowAddDescription;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\Math\Random;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class DataHelper
{
    /** @var ObjectManagerInterface */
    public $objectManager;

    /** @var Random */
    private $mathRandom;

    /**
     * DataHelper constructor.
     */
    public function __construct()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->mathRandom = $this->objectManager->create(Random::class);

    }

    /**
     * @param array $data
     *
     * @return CustomerInterface
     * @throws \Exception
     */
    public function createCustomer(array $data = []): CustomerInterface
    {
        /** @var Customer $customer */
        $customer = $this->objectManager->create(Customer::class);
        $customer->setWebsiteId(1)
                 ->setEmail($data['email'] ?? $this->getRandomString(7) . '@example.com')
                 ->setPassword($data['password'] ?? 'password')
                 ->setGroupId(1)
                 ->setStoreId(1)
                 ->setIsActive(1)
                 ->setPrefix('Mr.')
                 ->setFirstname('John')
                 ->setMiddlename('A')
                 ->setLastname('Smith')
                 ->setSuffix('Esq.')
                 ->setDefaultBilling(1)
                 ->setDefaultShipping(1)
                 ->setTaxvat('12')
                 ->setGender(0);
        $customer->isObjectNew(true);

        return $customer->save();
    }

    /**
     * @param array $data
     *
     * @return AllowAddDescriptionInterface
     * @throws \Exception
     */
    public function createAllowAddDecription(array $data = []): AllowAddDescriptionInterface
    {
        /** @var AllowAddDescription $allowAddDescription */
        $allowAddDescription = $this->objectManager->create(AllowAddDescription::class);
        $allowAddDescription->setCustomerEmail($data['customer_email'])
            ->setIsAllowed($data['is_allowed'] ?? true);
        $allowAddDescription->isObjectNew(true);

        return $allowAddDescription->save();
    }

    /**
     * @param array $data
     *
     * @return ProductInterface
     */
    public function createProduct(array $data = []): ProductInterface
    {
        $product = $this->objectManager->create(Product::class);
        $product->setTypeId($data['type'] ?? 'simple')
            ->setAttributeSetId(4)
            ->setWebsiteIds([1])
            ->setName($data['name'] ?? $this->getRandomString(5) . ' Simple Product')
            ->setSku($data['sku'] ?? $this->getRandomString(3) . 'simple')
            ->setPrice($data['price'] ?? 10)
            ->setMetaTitle('meta title')
            ->setMetaKeyword('meta keyword')
            ->setMetaDescription('meta description')
            ->setVisibility(Visibility::VISIBILITY_BOTH)
            ->setStatus(Status::STATUS_ENABLED)
            ->setStockData(['use_config_manage_stock' => 0]);

        return $product->save();
    }

    /**
     * @param array $data
     *
     * @return AdditionalDescriptionInterface
     * @throws \Exception
     */
    public function createAdditionalDescription(array $data = []): AdditionalDescriptionInterface
    {
        /** @var AdditionalDescription $additionalDescription */
        $additionalDescription = $this->objectManager->create(AdditionalDescription::class);
        $additionalDescription
            ->setCustomerEmail($data['customer_email'])
            ->setProductId($data['product_id'])
            ->setAdditionalDescription($data['additional_description'] ?? $this->getRandomString(50));

        return $additionalDescription->save();
    }

    /**
     * Generate Random string.
     *
     * @param      $length
     * @param null $chars
     *
     * @return string
     */
    public function getRandomString($length,  $chars = null): string
    {
        try {
            return $this->mathRandom->getRandomString($length, $chars);
        } catch (LocalizedException $e) {
            return '';
        }
    }

}
