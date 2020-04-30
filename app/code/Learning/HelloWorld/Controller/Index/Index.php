<?php

declare(strict_types=1);

namespace Learning\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Index Controller.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Execute action based on request and return result.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResultInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
