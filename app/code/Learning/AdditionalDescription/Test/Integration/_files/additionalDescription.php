<?php

use Learning\AdditionalDescription\Model\AdditionalDescription;
use Magento\TestFramework\Helper\Bootstrap;

include __DIR__ . '/customerWithPermission.php';
include __DIR__ . '/product.php';

$objectManager = Bootstrap::getObjectManager();

/** @var AdditionalDescription $additionalDescription */
$additionalDescription = $objectManager->create(AdditionalDescription::class);

$additionalDescription
    ->setAdditionalDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ut dignissim diam,
        sit amet maximus urna. Etiam posuere odio in tristique volutpat. Maecenas cursus quis erat in eleifend.
        Maecenas sagittis odio eget lorem dignissim posuere. Cras luctus in leo sit amet tempor.
        Morbi efficitur ante in dui pretium, ac vulputate sem mollis. Pellentesque ut quam velit.
        Suspendisse mollis libero nisl, quis hendrerit lorem dictum in. Cras sed nisi nec odio molestie congue.
        Donec sollicitudin dictum erat, et consequat nunc efficitur et. Vivamus rutrum id sapien eu aliquet.
        Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.')
    ->setProductId($product->getId())
    ->setCustomerEmail($customer->getEmail())
    ->save();
