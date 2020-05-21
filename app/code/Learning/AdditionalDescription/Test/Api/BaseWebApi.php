<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Api;

use Learning\AdditionalDescription\Api\AllowAddDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterface;
use Learning\AdditionalDescription\Api\Data\AllowAddDescriptionInterfaceFactory;
use Learning\AdditionalDescription\Model\AllowAddDescription;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\Integration\Api\CustomerTokenServiceInterface;
use Magento\TestFramework\Helper\Bootstrap as BootstrapHelper;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\TestFramework\Helper\Customer as CustomerHelper;

class BaseWebApi extends WebapiAbstract
{
    const DEFAULT_ADMIN_NAME = 'admin';
    const DEFAULT_ADMIN_PASSWORD = 'Password123';
    /**
     * Overwrite const from CustomerHelper
     */
    const PASSWORD = 'Password123';


    /** @var ObjectManagerInterface */
    protected $objectManager;

    /** @var string|null */
    protected $customerToken;

    /** @var CustomerHelper */
    protected $customerHelper;

    /** @var AdminTokenServiceInterface */
    protected $adminTokenService;

    /** @var CustomerTokenServiceInterface */
    protected $customerTokenService;

    /** @var AllowAddDescriptionInterface */
    protected $allowAddDescriptionFactory;

    /** @var AllowAddDescriptionRepositoryInterface */
    protected $allowAddDescriptionRepository;

    /** @var DataHelper */
    protected $dataHelper;

    /**
     * Bootstrap application before any test.
     */
    protected function setUp()
    {
        $this->objectManager                 = BootstrapHelper::getObjectManager();
        $this->customerHelper                = $this->objectManager->create(CustomerHelper::class);
        $this->adminTokenService             = $this->objectManager->create(AdminTokenServiceInterface::class);
        $this->customerTokenService          = $this->objectManager->create(CustomerTokenServiceInterface::class);
        $this->allowAddDescriptionRepository = $this->objectManager->create(
            AllowAddDescriptionRepositoryInterface::class
        );
        $this->allowAddDescriptionFactory    = $this->objectManager->create(AllowAddDescriptionInterfaceFactory::class);
        $this->dataHelper                    = $this->objectManager->create(DataHelper::class);

        parent::setUp();
    }

    /**
     * @param array|null $additionalData
     * @return array|bool|float|int|string
     */
    protected function createCustomer(?array $additionalData = [])
    {
        return $this->customerHelper->createSampleCustomer($additionalData);
    }

    /**
     * @param string $customerEmail
     *
     * @return AllowAddDescriptionInterface
     * @throws CouldNotSaveException|NoSuchEntityException
     */
    protected function createAllowAddDescription(string $customerEmail): AllowAddDescriptionInterface
    {
        /** @var AllowAddDescription $allowAddDescription */
        $allowAddDescription = $this->allowAddDescriptionFactory->create();
        $allowAddDescription->setCustomerEmail($customerEmail);
        $allowAddDescription->setIsAllowed(true);
        $allowAddDescription->isObjectNew(true);

        return $this->allowAddDescriptionRepository->save($allowAddDescription);
    }

    /**
     * @param string|null $username
     * @param string|null $password
     *
     * @return string|null
     * @throws AuthenticationException|InputException|LocalizedException
     */
    protected function getAdminToken(string $username = '', string $password = ''): ?string
    {
        if (!$username && !$password) {
            $username = self::DEFAULT_ADMIN_NAME;
            $password = self::DEFAULT_ADMIN_PASSWORD;
        }

        return $this->adminTokenService->createAdminAccessToken($username, $password);
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return string|null
     * @throws AuthenticationException
     */
    protected function getCustomerToken(string $username, string $password): ?string
    {
        return $this->customerTokenService->createCustomerAccessToken($username, $password);
    }

    public static function loadCustomerWithPermission(): void
    {
        include __DIR__ . '/../Integration/_files/customerWithPermission.php';
    }

    public static function loadCustomerWithPermissionRollback(): void
    {
        include __DIR__ . '/../Integration/_files/customerWithPermission_rollback.php';
    }

    public static function loadCustomer(): void
    {
        include __DIR__ . '/../Integration/_files/customer.php';
    }

    public static function loadCustomerRollback(): void
    {
        include __DIR__ . '/../Integration/_files/customer_rollback.php';
    }
}
