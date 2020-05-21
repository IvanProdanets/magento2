<?php

use Magento\Catalog\Model\Product;
use Magento\TestFramework\Helper\Bootstrap;

/** @var Product $product */
$product = Bootstrap::getObjectManager()->create(Product::class);
$product->load($product->getIdBySku('simple_test'));
$product->delete();
