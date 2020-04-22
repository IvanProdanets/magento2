<?php

namespace Learning\Blog\Block;

use Learning\Blog\Api\Data\BlogInterface;
use Learning\Blog\Model\BlogRepository;
use Learning\Blog\Service\CurrentProductService;
use Magento\Catalog\Block\Product\View;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class Blog extends Template
{
    const XML_PATH_RELATED_PRODUCTS = 'catalog/catalog/blog_applied_to';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var BlogRepository */
    private $blogRepository;

    private $currentProduct;

    /**
     * Blog constructor.
     *
     * @param Context                    $context
     * @param ScopeConfigInterface       $scopeConfig
     * @param BlogRepository             $blogRepository
     * @param View $
     * @param array                      $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        BlogRepository $blogRepository,
        CurrentProductService $currentProduct,
        array $data = []
    ) {
        $this->scopeConfig    = $scopeConfig;
        $this->blogRepository = $blogRepository;
        $this->currentProduct = $currentProduct;
        parent::__construct($context, $data);
    }

    /**
     * @param int|null $size
     * @param string   $order
     *
     * @return array
     */
    public function getItems(int $size = null, string $order = 'ASC'): array
    {

//        $blogs = $this->blogRepository->getList();

        return [];
    }

    public function display(): bool
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
}
