<?php
namespace Learning\Blog\Model;

use Learning\Blog\Api\Data\BlogInterface;
use Magento\Framework\Model\AbstractModel;
use Learning\Blog\Model\ResourceModel\Blog as BlogResourceModel;

/**
 * Model Blog.
 */
class Blog extends AbstractModel implements BlogInterface
{
    /**
     * Model initialization.
     */
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }

    /**
     * Retrieve blog id.
     *
     * @return int|null
     */
    public function getBlogId(): ?int
    {
        return $this->getData(self::ID);
    }

    /**
     * Set blog id.
     *
     * @param int $id
     * @return void
     */
    public function setBlogId($id)
    {
        $this->setData(self::ID, $id);
    }

    /**
     * Retrieve subject of the blog.
     *
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * Set subject of the blog.
     *
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject)
    {
        $this->setData(self::SUBJECT, $subject);
    }

    /**
     * Retrieve blog\'s content.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTEXT);
    }

    /**
     * Set blog\'s content.
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content)
    {
        $this->setData(self::CONTEXT, $content);
    }

    /**
     * Retrieve image url.
     *
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->getData(self::IMAGE_URL);
    }

    /**
     * Set image url.
     *
     * @param string|null $url
     * @return void
     */
    public function setImageUrl(?string $url)
    {
        $this->setData(self::IMAGE_URL, $url);
    }

    /**
     * Get blog\'s time creation.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set blog\'s time creation.
     *
     * @param string $timestamp
     * @return void
     */
    public function setCreatedAt(string $timestamp)
    {
        $this->setData(self::CREATED_AT, $timestamp);
    }
}
