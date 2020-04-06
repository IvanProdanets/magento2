<?php
namespace Learning\Blog\Controller\Me;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    protected $customerSession;

    public function __construct(Context $context, Session $session)
    {
        $this->customerSession = $session;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        $customerId = $this->customerSession->getCustomerId() ?? 0;
        $this->_eventManager->dispatch('customer_views_blog_me_index', [
            'customer_id' => $customerId,
        ]);
        $result->setContents("customerId: $customerId");

        return $result;
    }
}
