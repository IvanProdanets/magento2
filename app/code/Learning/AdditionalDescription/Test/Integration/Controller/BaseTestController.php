<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Integration\Controller;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\InputException;
use Magento\TestFramework\TestCase\AbstractController;

class BaseTestController extends AbstractController
{
    /** @var FormKey */
    protected $formKey;

    /** @var AccountManagementInterface */
    protected $accountManagement;

    /** @var Session; */
    protected $session;

    /** @var AdditionalDescriptionRepositoryInterface */
    protected $additionalDescriptionRepository;

    /** @var SortOrder */
    protected $sortOrder;

    /** @var SearchCriteriaBuilder */
    protected $criteriaBuilder;


    /**
     * Bootstrap application before any test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formKey                         = $this->_objectManager->get(FormKey::class);
        $this->accountManagement               = $this->_objectManager->get(AccountManagementInterface::class);
        $this->additionalDescriptionRepository = $this->_objectManager
            ->get(AdditionalDescriptionRepositoryInterface::class);
        $this->sortOrder                       = $this->_objectManager->get(SortOrder::class);
        $this->criteriaBuilder                 = $this->_objectManager->get(SearchCriteriaBuilder::class);
        $this->session                         = $this->_objectManager->get(Session::class);
    }

    /**
     * Get latest Additional Description.
     *
     * @param array $params
     *
     * @return AdditionalDescriptionInterface|null
     * @throws InputException
     */
    protected function getLatestDescription(array $params = []): ?AdditionalDescriptionInterface
    {
        $sortOrder = $this->sortOrder
            ->setField(AdditionalDescriptionInterface::DESCRIPTION_ID)
            ->setDirection(SortOrder::SORT_DESC);

        if (!empty($params)) {
            foreach ($params as $field => $value) {
                $this->criteriaBuilder->addFilter($field, $value);
            }
        }

        $criteria = $this->criteriaBuilder->setSortOrders([$sortOrder])->create();
        $result = $this->additionalDescriptionRepository->getList($criteria)->getItems();

        return reset($result) ?? null;
    }

    /**
     * Load fixtures.
     */
    public static function loadAdditionalDescription(): void
    {
        include __DIR__ . '/../_files/additionalDescription.php';
    }


    public function loadCustomers(): void
    {
        include __DIR__ . '/../_files/customer.php';
        include __DIR__ . '/../_files/customerWithPermission.php';
    }

    public function loadCustomer(): void
    {
        include __DIR__ . '/../_files/customer.php';
    }
}
