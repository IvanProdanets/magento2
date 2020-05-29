<?php

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Model\StockRegistryStorage;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;

/** @var Registry $registry */
$registry = Bootstrap::getObjectManager()->get(Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var Product $product */
$product = Bootstrap::getObjectManager()->create(Product::class);
$product->load($product->getIdBySku('simple_test'));
$product->delete();


/** @var StockRegistryStorage $stockRegistryStorage */
$stockRegistryStorage = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(StockRegistryStorage::class);
$stockRegistryStorage->clean();

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);
