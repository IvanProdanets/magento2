<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Plugin\Model\Customer;

use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\NoSuchEntityException;

class DataProviderPlugin
{
    /** @var AllowAddDescriptionRepositoryInterface */
    private $allowAddDescriptionRepository;

    /** @var Http */
    private $request;

    /**
     * RepositoryPlugin constructor.
     *
     * @param AllowAddDescriptionRepositoryInterface  $allowAddDescriptionRepository
     */
    public function __construct(
        AllowAddDescriptionRepositoryInterface $allowAddDescriptionRepository
    ) {
        $this->allowAddDescriptionRepository = $allowAddDescriptionRepository;
        $this->request = ObjectManager::getInstance()->get(Http::class);
    }

    /**
     * @param DataProviderWithDefaultAddresses $subject
     * @param array                            $data
     *
     * @return array
     */
    public function afterGetData(
        DataProviderWithDefaultAddresses $subject,
        array $data
    ) {
        if (!$customerId = $this->request->getParam('id')) {
            return $data;
        }

        if (!isset($data[$customerId]['customer']) && !isset($data[$customerId]['customer']['email'])) {
            return $data;
        }

        try {
            $allowAddDescription = $this->allowAddDescriptionRepository->get($data[$customerId]['customer']['email']);
            $allowAddDescription = $allowAddDescription->getAllowAddDescription();

            if (is_bool($allowAddDescription)) {
                // for proper work of form and grid (for example for Yes/No properties)
                $allowAddDescription = (string)(int)$allowAddDescription;
            }

            $data[$customerId]['customer'][AllowAddDescriptionInterface::ALLOW_ADD_DESCRIPTION] = $allowAddDescription;
        } catch (NoSuchEntityException $e) {
        }

        return $data;
    }
}
