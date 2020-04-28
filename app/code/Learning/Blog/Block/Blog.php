<?php

namespace Learning\Blog\Block;

use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Helper\ImageHelper;
use Learning\Blog\Model\BlogRepository;
use Learning\Blog\Service\CurrentProductService;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class Blog extends Template
{
    const XML_PATH_RELATED_PRODUCTS = 'catalog/catalog/blog_applied_to';
    const PAGE_SIZE = 5;

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var BlogRepository */
    private $blogRepository;

    /** @var CurrentProductService */
    private $currentProduct;

    /** @var SearchCriteriaBuilder */
    private $criteriaBuilder;

    /** @var SortOrder */
    private $sortOrder;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /** @var ImageHelper */
    private $imageHelper;

    /**
     * Blog constructor.
     *
     * @param Context               $context
     * @param ScopeConfigInterface  $scopeConfig
     * @param BlogRepository        $blogRepository
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param SortOrder             $sortOrder
     * @param CurrentProductService $currentProduct
     * @param ManagerInterface      $messageManager
     * @param ImageHelper           $imageHelper
     * @param array                 $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        BlogRepository $blogRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        SortOrder $sortOrder,
        CurrentProductService $currentProduct,
        ManagerInterface $messageManager,
        ImageHelper $imageHelper,
        array $data = []
    ) {
        $this->scopeConfig     = $scopeConfig;
        $this->blogRepository  = $blogRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->sortOrder       = $sortOrder;
        $this->currentProduct  = $currentProduct;
        $this->messageManager  = $messageManager;
        $this->imageHelper     = $imageHelper;

        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getLastItems(): array
    {
        try {
            $sortOrder = $this->sortOrder
                ->setField(BlogInterface::CREATED_AT)
                ->setDirection(SortOrder::SORT_DESC);

            $criteria = $this->criteriaBuilder->create();
            $criteria->setSortOrders([$sortOrder]);
            $criteria->setPageSize(self::PAGE_SIZE);
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->blogRepository->getList($criteria)->getItems();
    }

    /**
     * @return bool
     */
    public function showBlogSection(): bool
    {
        $currentProduct = $this->currentProduct->getProduct();

        if ($currentProduct) {
            return in_array($currentProduct->getTypeId(), $this->getRelatedProducts());
        }

        return false;
    }

    /**
     * Get products list from store config.
     *
     * @return array
     */
    private function getRelatedProducts(): array
    {
        $relatedProducts = $this->scopeConfig->getValue(
            self::XML_PATH_RELATED_PRODUCTS,
            ScopeInterface::SCOPE_STORES
        );

        if (is_string($relatedProducts) & !empty($relatedProducts)) {
            $relatedProducts = explode(',', $relatedProducts);
        }

        return $relatedProducts ?? [];
    }

    /**
     * Get full image url for display in front.
     *
     * @param string $relativePath
     * @return string
     */
    public function fullImgPath(string $relativePath = ''): string
    {
        return $this->imageHelper->getImageUrl($this->escapeUrl($relativePath));
    }
}
