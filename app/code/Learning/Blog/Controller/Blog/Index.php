<?php
namespace Learning\Blog\Controller\Blog;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Index
 * @package Learning\Blog\Controller\Blog
 */
class Index implements ActionInterface
{
    public function execute(): ResponseInterface
    {
        die('congrats');
    }
}
