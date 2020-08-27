<?php

namespace MageSuite\ExtendedSitemap\Test\Integration\Model\ItemProvider;

class AdditionalLinksTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\ExtendedSitemap\Model\ItemProvider\AdditionalLinks
     */
    protected $additionalLinksProvider;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->additionalLinksProvider = $this->objectManager->get(\MageSuite\ExtendedSitemap\Model\ItemProvider\AdditionalLinks::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoConfigFixture current_store extended_sitemap/configuration/additional_links_enabled 1
     * @magentoConfigFixture current_store extended_sitemap/configuration/additional_links {"1":{"path":"\/home","priority":"0.5","changeFrequency":"daily"},"2":{"path":"\/contact","priority":"0.25","changeFrequency":"weekly"},"3":{"path":"\/","priority":"1","changeFrequency":"monthly"}}
     */
    public function testItReturnCorrectLinks()
    {
        $expectedItems = [
            0 => [
                'url' => '/home',
                'priority' => '0.5',
                'changeFrequency' => 'daily',
                'images' => NULL,
                'updatedAt' => NULL
            ],
            1 => [
                'url' => '/contact',
                'priority' => '0.25',
                'changeFrequency' => 'weekly',
                'images' => NULL,
                'updatedAt' => NULL
            ],
            2 => [
                'url' => '/',
                'priority' => '1',
                'changeFrequency' => 'monthly',
                'images' => NULL,
                'updatedAt' => NULL
            ]
        ];

        $items = $this->additionalLinksProvider->getItems(0);
        foreach ($items as $index => $item) {
            $this->assertEquals($expectedItems[$index]['url'], $item->getUrl());
            $this->assertEquals($expectedItems[$index]['priority'], $item->getPriority());
            $this->assertEquals($expectedItems[$index]['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItems[$index]['images'], $item->getImages());
            $this->assertEquals($expectedItems[$index]['updatedAt'], $item->getUpdatedAt());
        }
    }
}
