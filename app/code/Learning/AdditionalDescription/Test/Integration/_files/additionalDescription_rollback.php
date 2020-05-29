<?php

/** @var DataHelper $dataHelper */

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;

/** @var Registry $registry */
$registry = Bootstrap::getObjectManager()->get(Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

/** @var Product $product */
$product = Bootstrap::getObjectManager()->create(Product::class);
$product->load($product->getIdBySku('simple_test'));
/** @var AdditionalDescription $additionalDescription */
$additionalDescription = $dataHelper->getLatestDescription([
   'product_id'     => $product->getId(),
   'customer_email' => 'test1.customer@example.com',
]);
$additionalDescription->delete();

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

include __DIR__ . '/customerWithPermission_rollback.php';
include __DIR__ . '/product_rollback.php';
