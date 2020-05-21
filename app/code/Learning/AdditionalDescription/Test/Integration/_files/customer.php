<?php

use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Customer;

/** @var DataHelper $dataHelper */
$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

/** @var Customer $customer */
$customer = $dataHelper->createCustomer([
    'email' => 'test.customer@example.com',
    'password' => 'password',
]);
