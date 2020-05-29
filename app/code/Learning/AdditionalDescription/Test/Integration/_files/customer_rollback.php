<?php

use Learning\AdditionalDescription\Model\AllowAddDescriptionRepository;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Integration\Model\Oauth\Token\RequestThrottler;

/** @var Registry $registry */
$registry = Bootstrap::getObjectManager()->get(Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var CustomerRepository $customerRepository */
$customerRepository = Bootstrap::getObjectManager()->create(CustomerRepository::class);
try {
    $customer = $customerRepository->get('test.customer@example.com');
    $customerRepository->deleteById($customer->getId());
} catch (NoSuchEntityException|LocalizedException $e) {
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

/* Unlock account if it was locked for tokens retrieval */
/** @var RequestThrottler $throttler */
$throttler = Bootstrap::getObjectManager()->create(RequestThrottler::class);
$throttler->resetAuthenticationFailuresCount('test.customer@example.com', RequestThrottler::USER_TYPE_CUSTOMER);
