<?php

namespace Learning\Blog\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CurrentProductService
 */
class CurrentProductService
{
    /**
     * Current Product
     *
     * @var ProductInterface
     */
    private $currentProduct;

    /**
     * Current Product ID
     *
     * @var int|null
     */
    private $productId;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /** @var RequestInterface */
    private $request;


    /**
     * CurrentProductService constructor.
     *
     * @param RequestInterface           $request
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        RequestInterface $request,
        ProductRepositoryInterface $productRepository
    ) {
        $this->request           = $request;
        $this->productRepository = $productRepository;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        if (!$this->productId) {
            $productId       = $this->request->getParam('id');
            $this->productId = $productId ? (int) $productId : null;
        }

        return $this->productId;
    }

    /**
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface
    {
        if (!$this->currentProduct) {
            $productId = $this->getProductId();

            if (!$productId) {
                return null;
            }

            try {
                $this->currentProduct = $this->productRepository->getById($this->getProductId());
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }

        return $this->currentProduct;
    }
}
