<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Block\Product;

use Learning\AdditionalDescription\Model\AdditionalDescriptionRepository;
use Learning\AdditionalDescription\Service\CurrentUserService;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Base template class.
 */
class BaseTemplate extends Template
{
    /** @var CurrentUserService */
    protected $currentUser;

    /** @var AdditionalDescriptionRepository */
    protected $additionalDescriptionRepository;

    /** @var Registry */
    private $registry;

    /** @var ManagerInterface */
    protected $messageManager;

    /** @var ProductInterface */
    private $currentProduct;

    /**
     * Description constructor.
     *
     * @param Context                         $context
     * @param CurrentUserService              $currentUser
     * @param AdditionalDescriptionRepository $additionalDescriptionRepository
     * @param Registry                        $registry
     * @param ManagerInterface                $messageManager
     * @param array                           $data
     */
    public function __construct(
        Context $context,
        CurrentUserService $currentUser,
        AdditionalDescriptionRepository $additionalDescriptionRepository,
        Registry $registry,
        ManagerInterface $messageManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->currentUser                     = $currentUser;
        $this->additionalDescriptionRepository = $additionalDescriptionRepository;
        $this->registry                        = $registry;
        $this->messageManager                  = $messageManager;
    }

    /**
     * Get current product.
     *
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface
    {
        if (!$this->currentProduct) {
            $this->currentProduct = $this->registry->registry('current_product');
        }

        return $this->currentProduct;
    }

    /**
     * @return bool
     */
    public function canCustomerAddDescription(): bool
    {
        return $this->currentUser->canCustomerAddDescription();
    }
}
