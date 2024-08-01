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
        $excludedIds = [444, 555];
        $expectedItems = $this->getExpectedItems($excludedIds);
        $items = $this->cmsPageProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedItems($items, $expectedItems, $excludedIds);

        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->cmsPageProvider->getItems($storeId);
        $this->assertExpectedItems($items, $expectedItems, $excludedIds);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/cms/pages_with_none_excluded.php
     */
    public function testGetItemsWithNoneExcluded()
    {
        $excludedIds = [555];
        $expectedItemsDefaultStore = $this->getExpectedItems($excludedIds);
        $items = $this->cmsPageProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedItems($items, $expectedItemsDefaultStore, $excludedIds);

        $expectedItemsSecondStore = $this->getExpectedItems();
        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->cmsPageProvider->getItems($storeId);
        $this->assertExpectedItems($items, $expectedItemsSecondStore, []);
    }

    protected function assertExpectedItems(array $items, array $expectedItems, array $excludedIds): void
    {
        foreach ($expectedItems as $id => $expectedItem) {
            $this->assertArrayHasKey($id, $items);
            $item = $items[$id];
            $this->assertEquals($expectedItem['url'], $item->getUrl());
            $this->assertEquals($expectedItem['priority'], $item->getPriority());
            $this->assertEquals($expectedItem['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItem['images'], $item->getImages());
        }

        foreach ($excludedIds as $id => $data) {
            $this->assertArrayNotHasKey($id, $items);
        }
    }

    protected function getExpectedItems(array $excludedIds = []): array
    {
        $expectedItems = [
            333 => [
                'url' => 'page333',
                'priority' => '0.25',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            444 => [
                'url' => 'page444',
                'priority' => '0.25',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            555 => [
                'url' => 'page555',
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
