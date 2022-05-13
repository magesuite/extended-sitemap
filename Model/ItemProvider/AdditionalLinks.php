<?php
declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Model\ItemProvider;

class AdditionalLinks implements \Magento\Sitemap\Model\ItemProvider\ItemProviderInterface
{
    /**
     * @var \Magento\Sitemap\Model\SitemapItemInterfaceFactory
     */
    protected $itemFactory;

    /**
     * @var \MageSuite\ExtendedSitemap\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Sitemap\Model\SitemapItemInterfaceFactory $itemFactory,
        \MageSuite\ExtendedSitemap\Helper\Configuration $configuration
    ) {
        $this->itemFactory = $itemFactory;
        $this->configuration = $configuration;
    }

    public function getItems($storeId): array
    {
        if (!$this->configuration->isEnabled($storeId)) {
            return [];
        }

        $items = [];
        $additionalLinks = $this->configuration->getAdditionalLinks($storeId);

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
