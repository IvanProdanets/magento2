<?php

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\TestFramework\Helper\Bootstrap;

/** @var $product Product */
$product = Bootstrap::getObjectManager()
                    ->create(Product::class);
$product
    ->setTypeId('simple')
    ->setId(1)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Product')
    ->setSku('simple')
    ->setPrice(10)
    ->setMetaTitle('meta title')
    ->setMetaKeyword('meta keyword')
    ->setMetaDescription('meta description')
    ->setVisibility(Visibility::VISIBILITY_BOTH)
    ->setStatus(Status::STATUS_ENABLED)
    ->setStockData(['use_config_manage_stock' => 0])
    ->save();

$customDesignProduct = Bootstrap::getObjectManager()
                                ->create(Product::class, ['data' => $product->getData()]);

$customDesignProduct->setUrlKey('custom-design-simple-product')
                    ->setId(2)
                    ->setRowId(2)
                    ->setSku('custom-design-simple-product')
                    ->setCustomDesign('Magento/blank')
                    ->save();
