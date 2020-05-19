<?php

use Learning\AdditionalDescription\Model\AllowAddDescription;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerRegistry;
use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();
$customer = $objectManager->create(Customer::class);
/** @var CustomerRegistry $customerRegistry */
$customerRegistry = $objectManager->get(CustomerRegistry::class);
/** @var Customer $customer */
$customer->setWebsiteId(1)
    ->setId(2)
    ->setEmail('customer2@example.com')
    ->setPassword('password')
    ->setGroupId(1)
    ->setStoreId(1)
    ->setIsActive(1)
    ->setPrefix('Mr.')
    ->setFirstname('John1')
    ->setMiddlename('A1')
    ->setLastname('Smith1')
    ->setSuffix('Esq.')
    ->setDefaultBilling(2)
    ->setDefaultShipping(2)
    ->setTaxvat('12')
    ->setGender(0);


$customer->isObjectNew(true);
$customer->save();
$customerRegistry->remove($customer->getId());

/** @var AllowAddDescription $allowAddDescription */
$allowAddDescription = $objectManager->create(AllowAddDescription::class);
$allowAddDescription
    ->setCustomerEmail($customer->getEmail())
    ->setIsAllowed(true);
$allowAddDescription->isObjectNew(true);
$allowAddDescription->save();
