<?php
declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Test\Integration\Model\ItemProvider;

class CmsPageTest extends \PHPUnit\Framework\TestCase
{
    public const DEFAULT_STORE_ID = 1;
    public const SECOND_STORE_CODE = 'fixture_second_store';

    protected ?\Magento\Sitemap\Model\ItemProvider\CmsPage $cmsPageProvider;
    protected ?\Magento\Store\Api\StoreRepositoryInterface $storeRepository = null;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->cmsPageProvider = $objectManager->get(\Magento\Sitemap\Model\ItemProvider\CmsPage::class);
        $this->storeRepository = $objectManager->get(\Magento\Store\Api\StoreRepositoryInterface::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/cms/pages_with_excluded.php
     */
    public function testGetItemsWithExcluded()
    {
        $expectedItems = $this->getExpectedItems([444,555]);
        $items = $this->cmsPageProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedItems($expectedItems, $items);

        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->cmsPageProvider->getItems($storeId);
        $this->assertExpectedItems($expectedItems, $items);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/cms/pages_with_none_excluded.php
     */
    public function testGetItemsWithNoneExcluded()
    {
        $expectedItemsDefaultStore = $this->getExpectedItems([555]);
        $items = $this->cmsPageProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedItems($expectedItemsDefaultStore, $items);

        $expectedItemsSecondStore = $this->getExpectedItems();
        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->cmsPageProvider->getItems($storeId);
        $this->assertExpectedItems($expectedItemsSecondStore, $items);
    }

    protected function assertExpectedItems(array $expectedItems, array $items): void
    {
        foreach ($items as $index => $item) {
            if ($item->getUrl() === 'privacy-policy-cookie-restriction-mode') {
                unset($items[$index]);
                continue;
            }

            $this->assertEquals($expectedItems[$index]['url'], $item->getUrl());
            $this->assertEquals($expectedItems[$index]['priority'], $item->getPriority());
            $this->assertEquals($expectedItems[$index]['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItems[$index]['images'], $item->getImages());
        }
    }

    protected function getExpectedItems(array $excludedIds = []): array
    {
        $expectedItems = [
            333 => [
                'url' => 'page100',
                'priority' => '0.25',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            444 => [
                'url' => 'page_design_blank',
                'priority' => '0.25',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            555 => [
                'url' => 'page_second_store',
                'priority' => '0.25',
                'changeFrequency' => 'daily',
                'images' => null
            ]
        ];

        foreach ($excludedIds as $excludedId) {
            if (isset($expectedItems[$excludedId])) {
                unset($expectedItems[$excludedId]);
            }
        }

        return $expectedItems;
    }
}
