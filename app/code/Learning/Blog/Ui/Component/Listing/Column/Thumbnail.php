<?php

namespace Learning\Blog\Ui\Component\Listing\Column;

use Learning\Blog\Api\Data\BlogInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Psr\Log\LoggerInterface;

class Thumbnail extends Column
{
    const DEFAULT_IMAGE = 'thumbnail.jpg';

    const ALT_FIELD = 'Blog\'s image';

    /** @var StoreManagerInterface */
    protected $storeManager;

    /** @var UrlInterface */
    private $urlBuilder;

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
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param AssetRepository       $assetRepository
     * @param StoreManagerInterface $storeManager
     * @param Filesystem            $filesystem
     * @param LoggerInterface       $logger
     * @param array                 $components
     * @param array                 $data
     *
     * @throws FileSystemException
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        AssetRepository $assetRepository,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        LoggerInterface $logger,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager    = $storeManager;
        $this->urlBuilder      = $urlBuilder;
        $this->assetRepository = $assetRepository;
        $this->mediaDirectory  = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->logger          = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url                            = $this->getImageUrl($item[BlogInterface::IMAGE_URL] ?? '');
                $item[$fieldName . '_orig_src'] = $url;
                $item[$fieldName . '_src']      = $url;
                $item[$fieldName . '_alt']      = self::ALT_FIELD;
                $item[$fieldName . '_link']     = $this->urlBuilder->getUrl(
                    'blog/blog/edit',
                    [BlogInterface::ID => $item[BlogInterface::ID]]
                );
            }
        }

        return $dataSource;
    }

    /**
     * Get image url for Blog list.
     *
     * @param string $url
     *
     * @return string
     */
    private function getImageUrl(string $url = ''): string
    {
        if ($url === '') {
            return $this->getDefaultImageUrl();
        }

        // Check if image exist inside media storage.
        $filePath = DIRECTORY_SEPARATOR . ltrim($url, DIRECTORY_SEPARATOR);
        if (!$this->mediaDirectory->isFile($filePath)) {
            $this->logger->info(__(
                'Could not find image %1',
                $this->mediaDirectory->getAbsolutePath($filePath)
            ));

            return $this->getDefaultImageUrl();
        }

        try {
            $filePath = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $filePath;
        } catch (NoSuchEntityException $e) {
            $this->logger->error(__(
                'Something went wrong with image %1',
                $this->mediaDirectory->getAbsolutePath($filePath)
            ));

            return $this->getDefaultImageUrl();
        }

        return $filePath;
    }

    /**
     *  Reprieve default blog image.
     *
     * @return string
     */
    private function getDefaultImageUrl(): string
    {
        return $this->assetRepository->getUrl('Learning_Blog::images/blog/' . self::DEFAULT_IMAGE);
    }
}
