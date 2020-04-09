<?php
namespace Learning\Blog\Api\Data;

/**
 * Blog entity data interface.
 */
interface BlogInterface
{
    const ID = 'id';

    const SUBJECT = 'subject';

    const CONTEXT = 'content';

    const IMAGE_URL = 'image_url';

    const CREATED_AT = 'created_at';


    /**
     * Retrieve blog id.
     *
     * @return int|null
     */
    public function getBlogId(): ?int;

    /**
     * Set blog id.
     *
     * @param int $id
     * @return void
     */
    public function setBlogId($id);

    /**
     * Retrieve subject of the blog.
     *
     * @return string|null
     */
    public function getSubject(): ?string;

    /**
     * Set subject of the blog.
     *
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject);

    /**
     * Retrieve blog\'s content.
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Set blog\'s content.
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content);


    /**
     * Retrieve image url.
     *
     * @return string|null
     */
    public function getImageUrl(): ?string;

    /**
     * Set image url.
     *
     * @param string|null $url
     * @return void
     */
    public function setImageUrl(?string $url);

    /**
     * Get blog\'s time creation.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set blog\'s time creation.
     *
     * @param string $timestamp
     * @return void
     */
    public function setCreatedAt(string $timestamp);
}
