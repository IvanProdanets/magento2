<?php

include __DIR__ . '/customerWithPermission.php';
include __DIR__ . '/product.php';

use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\TestFramework\Helper\Bootstrap;

/** @var DataHelper $dataHelper */
$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

$additionalDescription = $dataHelper->createAdditionalDescription([
    'customer_email' => $customer->getEmail(),
    'product_id'     => $product->getId(),
]);
