<?php
namespace Learning\Blog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ListenCustomerViews implements ObserverInterface
{

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        if ($customerId = $observer->getData('customer_id')) {
            echo '<pre>';
            var_dump($customerId);
            die();
        }
    }
}
