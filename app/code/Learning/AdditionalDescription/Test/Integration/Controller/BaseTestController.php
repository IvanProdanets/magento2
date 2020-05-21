<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Test\Integration\Controller;

use Learning\AdditionalDescription\Api\AdditionalDescriptionRepositoryInterface;
use Learning\AdditionalDescription\Test\Integration\Helper\DataHelper;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey;
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

    /** @var DataHelper */
    protected $dataHelper;

    /**
     * Bootstrap application before any test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formKey                         = $this->_objectManager->get(FormKey::class);
        $this->accountManagement               = $this->_objectManager->get(AccountManagementInterface::class);
        $this->dataHelper                      = $this->_objectManager->get(DataHelper::class);
        $this->additionalDescriptionRepository =
            $this->_objectManager->get(AdditionalDescriptionRepositoryInterface::class);
        $this->session                         = $this->_objectManager->get(Session::class);
    }

    /**
     * Load Additional description fixture.
     */
    public static function loadAdditionalDescription(): void
    {
        include __DIR__ . '/../_files/additionalDescription.php';
    }

    /**
     * Load customer fixture.
     */
    public static function loadCustomer(): void
    {
        include __DIR__ . '/../_files/customer.php';
    }

    /**
     * Load product fixture.
     */
    public static function loadProduct(): void
    {
        include __DIR__ . '/../_files/product.php';
    }
}
