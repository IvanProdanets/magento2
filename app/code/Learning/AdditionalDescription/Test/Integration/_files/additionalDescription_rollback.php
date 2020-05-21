<?php

/** @var DataHelper $dataHelper */

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\Catalog\Model\Product;
use Magento\TestFramework\Helper\Bootstrap;

$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

$product = Bootstrap::getObjectManager()->create(Product::class);
/** @var AdditionalDescription $additionalDescription */
$additionalDescription = $dataHelper->getLatestDescription([
   'product_id'     => $product->getIdBySku('simple_test'),
   'customer_email' => 'test1.customer@example.com',
]);
$additionalDescription->delete();

include __DIR__ . '/customerWithPermission_rollback.php';
include __DIR__ . '/product_rollback.php';
