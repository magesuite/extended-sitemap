<?php

namespace MageSuite\ExtendedSitemap\Model\ItemProvider;

class AdditionalLinks implements \Magento\Sitemap\Model\ItemProvider\ItemProviderInterface
{
    /**
     * @var \Magento\Sitemap\Model\ItemProvider\CmsPageConfigReader
     */
    protected $cmsPageConfigReader;

    /**
     * @var \Magento\Sitemap\Model\SitemapItemInterfaceFactory
     */
    protected $itemFactory;

    /**
     * @var \MageSuite\ExtendedSitemap\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Sitemap\Model\ItemProvider\CmsPageConfigReader $cmsPageConfigReader,
        \Magento\Sitemap\Model\SitemapItemInterfaceFactory $itemFactory,
        \MageSuite\ExtendedSitemap\Helper\Configuration $configuration
    ) {
        $this->cmsPageConfigReader = $cmsPageConfigReader;
        $this->itemFactory = $itemFactory;
        $this->configuration = $configuration;
    }
    
    public function getItems($storeId)
    {
        if (!$this->configuration->isEnabled()) {
            return [];
        }

        $items = [];
        $additionalLinks = $this->configuration->getAdditionalLinks();
        foreach ($additionalLinks as $additionalLink) {
            $items[] = $this->itemFactory->create([
                'url' => $additionalLink['path'],
                'priority' => $additionalLink['priority'],
                'changeFrequency' => $additionalLink['changeFrequency'],
            ]);
        }

        return $items;
    }
}
