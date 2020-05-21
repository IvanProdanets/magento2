<?php

use Magento\Customer\Model\Customer;
use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Integration\Model\Oauth\Token\RequestThrottler;

/** @var Registry $registry */
$registry = Bootstrap::getObjectManager()->get(Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var Customer $customer */
$customer = Bootstrap::getObjectManager()->create(Customer::class);
$customer = $customer->setWebsiteId(1)->loadByEmail('test.customer@example.com');
$customer->delete();

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

/* Unlock account if it was locked for tokens retrieval */
/** @var RequestThrottler $throttler */
$throttler = Bootstrap::getObjectManager()->create(RequestThrottler::class);
$throttler->resetAuthenticationFailuresCount('test.customer@example.com', RequestThrottler::USER_TYPE_CUSTOMER);
