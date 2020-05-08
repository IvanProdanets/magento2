<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Block\Product;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Description extends Template
{
    /** @var Session */
    private $customerSession;

    /** @var AdditionalDescriptionRepository */
    private $additionalDescriptionRepository;

    /** @var SearchCriteriaBuilder */
    private $criteriaBuilder;

    /** @var FilterBuilder */
    private $filterBuilder;

    /** @var SortOrder */
    private $sortOrder;

    /** @var Registry */
    private $registry;

    /** @var ManagerInterface */
    private $messageManager;

    /** @var ProductInterface */
    private $currentProduct;

    /**
     * Description constructor.
     *
     * @param Context                                          $context
     * @param Session                                          $customerSession
     * @param AdditionalDescriptionRepository                  $additionalDescriptionRepository
     * @param SearchCriteriaBuilder                            $criteriaBuilder
     * @param SortOrder                                        $sortOrder
     * @param Registry                                         $registry
     * @param ManagerInterface                                 $messageManager
     * @param array                                            $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        AdditionalDescriptionRepository $additionalDescriptionRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        SortOrder $sortOrder,
        Registry $registry,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setTabTitle();
        $this->customerSession                 = $customerSession;
        $this->additionalDescriptionRepository = $additionalDescriptionRepository;
        $this->criteriaBuilder                 = $criteriaBuilder;
        $this->sortOrder                       = $sortOrder;
        $this->registry                        = $registry;
        $this->messageManager                  = $messageManager;
        $this->currentProduct                  = $registry->registry('current_product');
    }

    /**
     * Set tab title.
     *
     * @return void
     */
    public function setTabTitle(): void
    {
        $this->setTitle(__('Additional Description'));
    }

    /**
     * @return bool
     */
    public function isDescriptionsVisible(): bool
    {
        return count($this->getDescriptionList()) > 0;
    }

    /**
     * Get the logged in customer
     *
     * @return CustomerInterface|null
     */
    private function getCustomer(): ?CustomerInterface
    {
        if (!$this->customerSession->isLoggedIn()) {
            return null;
        }

        try {
            $customer = $this->customerSession->getCustomerData();
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return null;
        }

        return $customer;
    }

    /**
     * @return bool
     */
    public function isFormVisible(): bool
    {
        if ($this->getCustomer() === null) {
            return false;
        }

        return $this->getCustomer()->getExtensionAttributes()->getAllowAddDescription()->getIsAllowed() ?? false;
    }

    /**
     * Get current product additional descriptions without current user descriptions.
     *
     * @return AdditionalDescriptionInterface[]
     */
    public function getDescriptionList(): array
    {
        try {
            $sortOrder = $this->sortOrder
                ->setField(AdditionalDescriptionInterface::DESCRIPTION_ID)
                ->setDirection(SortOrder::SORT_DESC);
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }


        $criteria = $this->criteriaBuilder
            ->addFilter(AdditionalDescriptionInterface::PRODUCT_ID, $this->currentProduct->getId())
//            ->addFilter(AdditionalDescriptionInterface::CUSTOMER_EMAIL, $this->getCustomer()->getEmail())
            ->setSortOrders([$sortOrder])
            ->create();

        return $this->additionalDescriptionRepository->getList($criteria)->getItems();
    }

//    public function getCurrentDescription(): AdditionalDescriptionInterface
//    {
//        try {
//            return $this->additionalDescriptionRepository->get($this->currentProductId);
//        } catch (NoSuchEntityException $e) {
//            $this->messageManager->addErrorMessage($e->getMessage());
//        }
//    }


//    public function getFilters(): array
//    {
//        $filters = [];
//        $this->filterBuilder->setField(AdditionalDescriptionInterface::PRODUCT_ID)
//        foreach ($searchFields as $field) {
//            $filters[] = $this->filterBuilder
//                ->setField($field)
//                ->setConditionType('like')
//                ->setValue($this->getQuery() . '%')
//                ->create();
//        }
//        $filters[] = AdditionalDescriptionInterface::PRODUCT_ID, $this->currentProduct->getId()
//        $criteria = $this->criteriaBuilder
//            ->addFilters()
//            ->addFilter()
//            ->addFilter(AdditionalDescriptionInterface::CUSTOMER_EMAIL, $this->currentCustomer->getEmail())
//            ->setSortOrders([$sortOrder])
//            ->create();
//    }
}
