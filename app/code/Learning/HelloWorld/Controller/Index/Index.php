<?php

namespace Learning\HelloWorld\Controller\Index;

use Learning\HelloWorld\Api\HelloWorldInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Response;

/**
 * Class Index.
 */
class Index extends Action implements HttpGetActionInterface
{
    /** @var HelloWorldInterface */
    protected $helloWorld;

    public function __construct(Context $context, HelloWorldInterface $helloWorld)
    {
        $this->helloWorld = $helloWorld;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return ResponseInterface|Json|ResultInterface
     */
    public function execute()
    {
        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $response = $response->setData([
                'data' => [
                    'message' => $this->helloWorld->hello() ?? '',
                ]
            ]);
            $response->setHttpResponseCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            $response->setData([
                'error'     => $exception->getMessage(),
                'errorCode' => $exception->getCode()
            ]);
            $response->setHttpResponseCode(Exception::HTTP_INTERNAL_ERROR);
        }

        return $response;
    }
}
