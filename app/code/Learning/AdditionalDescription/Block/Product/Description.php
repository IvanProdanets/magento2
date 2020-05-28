<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Block\Product;

use Learning\AdditionalDescription\Api\Data\AdditionalDescriptionInterface;
use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Learning\AdditionalDescription\Service\CurrentCustomerService;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;

/**
 * Additional Description template.
 */
class Description extends BaseTemplate
{
    /** @var SearchCriteriaBuilder */
    private $criteriaBuilder;

    /** @var SortOrder */
    private $sortOrder;

    /**
     * Description constructor.
     *
     * @param Context                         $context
     * @param CurrentCustomerService          $customerService
     * @param AdditionalDescriptionRepository $additionalDescriptionRepository
     * @param SearchCriteriaBuilder           $criteriaBuilder
     * @param SortOrder                       $sortOrder
     * @param Registry                        $registry
     * @param ManagerInterface                $messageManager
     * @param array                           $data
     */
    public function __construct(
        Context $context,
        CurrentCustomerService $customerService,
        AdditionalDescriptionRepository $additionalDescriptionRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        SortOrder $sortOrder,
        Registry $registry,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $customerService,
            $additionalDescriptionRepository,
            $registry,
            $messageManager,
            $data
        );

        $this->criteriaBuilder = $criteriaBuilder;
        $this->sortOrder       = $sortOrder;
        $this->setTabTitle();
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
     * @param AdditionalDescriptionInterface $description
     *
     * @return bool
     */
    public function isEditButtonVisible(AdditionalDescriptionInterface $description): bool
    {
        if ($this->canCustomerAddDescription()) {
            return $this->customerService->getCustomer()->getEmail() === $description->getCustomerEmail();
        }

        return false;
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
            return [];
        }

        $criteria = $this->criteriaBuilder
            ->addFilter(AdditionalDescriptionInterface::PRODUCT_ID, $this->getProduct()->getId())
            ->setSortOrders([$sortOrder])
            ->create();

        return $this->additionalDescriptionRepository->getList($criteria)->getItems();
    }
}
