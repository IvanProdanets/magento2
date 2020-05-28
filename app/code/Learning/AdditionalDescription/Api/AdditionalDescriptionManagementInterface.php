<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Api;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;

/**
 * Additional description management model interface.
 */
interface AdditionalDescriptionManagementInterface
{
    /**
     * @param AdditionalDescriptionInterface $additionalDescription
     *
     * @return AdditionalDescriptionInterface|string
     */
    public function save(AdditionalDescriptionInterface $additionalDescription);
}
