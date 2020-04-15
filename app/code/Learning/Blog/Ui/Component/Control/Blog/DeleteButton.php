<?php

namespace Learning\Blog\Ui\Component\Control\Blog;

use Learning\Blog\Api\Data\BlogInterface;
use Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        return [
            'label'    => __('Delete'),
            'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this blog?') .
                          '\', \'' . $this->getDeleteUrl() . '\')',
            'class'    => 'delete',
        ];
    }

    /**
     * @return string
     */
    private function getDeleteUrl(): string
    {
        return $this->getUrl(
            '*/*/delete',
            [
            'id' => $this->context->getRequest()->getParam(BlogInterface::ID, null)
            ]
        );
    }
}
