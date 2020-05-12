<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;

interface AdditionalDescriptionManagementInterface
{
    /**
     * @param AdditionalDescriptionInterface $additionalDescription
     *
     * @return AdditionalDescriptionInterface|string
     */
    public function save(AdditionalDescriptionInterface $additionalDescription);
}
