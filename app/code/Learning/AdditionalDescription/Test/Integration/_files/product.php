<?php

use Magento\Catalog\Model\Product;
use Magento\TestFramework\Helper\Bootstrap;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;

/** @var DataHelper $dataHelper */
$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

/** @var Product $product */
$product = $dataHelper->createProduct(['sku' => 'simple_test']);
