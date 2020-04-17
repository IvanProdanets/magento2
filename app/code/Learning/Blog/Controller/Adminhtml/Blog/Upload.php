<?php

namespace Learning\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Response;

/**
 * Class Upload image for blog.
 */
class Upload extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Learning_Blog::blog_update';

    private $imageUploader;

    /**
     * Upload constructor.
     *
     * @param Context       $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(Context $context, ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|Json|ResponseInterface
     */
    public function execute()
    {
        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        try {
            $imageId = $this->_request->getParam('param_name', 'image');
            $data    = $this->imageUploader->saveFileToTmpDir($imageId);
            $response->setHttpResponseCode(Response::HTTP_OK);
        } catch (\Exception $e) {
            $data = [
                'error'     => $e->getMessage(),
                'errorcode' => $e->getCode()
            ];
            $response->setHttpResponseCode(Exception::HTTP_INTERNAL_ERROR);
        }

        $response->setData($data);

        return $response;
    }
}
