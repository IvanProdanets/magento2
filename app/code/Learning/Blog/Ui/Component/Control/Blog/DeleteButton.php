<?php

namespace Learning\Blog\Ui\Component\Control\Blog;

use Learning\Blog\Api\Data\BlogInterface;
use Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton.
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Learning_Blog::blog_delete';

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
     * Return url for delete action.
     *
     * @return string
     */
    private function getDeleteUrl(): string
    {
        return $this->getUrl(
            'blog/blog/delete',
            [
                'id' => $this->context->getRequest()->getParam(BlogInterface::ID, null)
            ]
        );
    }
}
