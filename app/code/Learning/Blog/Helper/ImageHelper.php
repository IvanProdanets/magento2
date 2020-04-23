<?php

namespace Learning\Blog\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageHelper extends AbstractHelper
{
    const DEFAULT_IMAGE = 'thumbnail.jpg';

    const DEFAULT_ALT = 'Blog\'s image';

    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var AssetRepository */
    private $assetRepository;

    /**
     * @var WriteInterface
     * @since 101.0.0
     */
    protected $mediaDirectory;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ImageHelper constructor.
     *
     * @param Context               $context
     * @param AssetRepository       $assetRepository
     * @param StoreManagerInterface $storeManager
     * @param Filesystem            $filesystem
     * @param LoggerInterface       $logger
     *
     * @throws FileSystemException
     */
    public function __construct(
        Context $context,
        AssetRepository $assetRepository,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        LoggerInterface $logger
    ) {
        $this->storeManager    = $storeManager;
        $this->assetRepository = $assetRepository;
        $this->mediaDirectory  = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->logger          = $logger;
        parent::__construct($context);
    }

    /**
     * Get image url for Blog list.
     *
     * @param string $url
     *
     * @return string
     */
    public function getImageUrl(string $url = ''): string
    {
        if ($url === '') {
            return $this->getDefaultImageUrl();
        }

        // Check if image exist inside media storage.
        $filePath = DIRECTORY_SEPARATOR . ltrim($url, DIRECTORY_SEPARATOR);
        if (!$this->mediaDirectory->isFile($filePath)) {
            $this->logger->info(
                __(
                    'Could not find image %1',
                    $this->mediaDirectory->getAbsolutePath($filePath)
                )
            );

            return $this->getDefaultImageUrl();
        }

        try {
            $filePath = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $filePath;
        } catch (NoSuchEntityException $e) {
            $this->logger->error(
                __(
                    'Something went wrong with image %1',
                    $this->mediaDirectory->getAbsolutePath($filePath)
                )
            );

            return $this->getDefaultImageUrl();
        }

        return $filePath;
    }

    /**
     *  Reprieve default blog image.
     *
     * @return string
     */
    public function getDefaultImageUrl(): string
    {
        return $this->assetRepository->getUrl('Learning_Blog::images/blog/' . self::DEFAULT_IMAGE);
    }
}
