<?php

use Learning\AdditionalDescription\Model\AllowAddDescription;
use Magento\TestFramework\Helper\Bootstrap;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\Customer\Model\Customer;

/** @var DataHelper $dataHelper */
$dataHelper = Bootstrap::getObjectManager()->create(DataHelper::class);

/** @var Customer $customer */
$customer = $dataHelper->createCustomer([
    'email'    => 'test1.customer@example.com',
    'password' => 'password',
]);

/** @var AllowAddDescription $allowAddDescription */
$allowAddDescription = $dataHelper->createAllowAddDecription(['customer_email' => $customer->getEmail()]);
