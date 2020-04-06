<?php
namespace Learning\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class All extends Action
{

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->_forward('index');
    }
}
