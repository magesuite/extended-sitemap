<?php
declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Test\Integration\Model\ItemProvider;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    public const DEFAULT_STORE_ID = 1;
    public const SECOND_STORE_CODE = 'fixture_second_store';

    protected ?\Magento\Sitemap\Model\ItemProvider\Product $productProvider = null;
    protected ?\Magento\Store\Api\StoreRepositoryInterface $storeRepository = null;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->productProvider = $objectManager->create(\Magento\Sitemap\Model\ItemProvider\Product::class);
        $this->storeRepository = $objectManager->get(\Magento\Store\Api\StoreRepositoryInterface::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation disabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/product/products_with_excluded.php
     */
    public function testGetItemsWithExcluded()
    {
        $excludedIds = [112];
        $expectedItems = $this->getExpectedItems($excludedIds);
        $items = $this->productProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedProducts($items, $expectedItems, $excludedIds);

        $excludedIds = [112, 113];
        $expectedItemsSecondStore = $this->getExpectedItems($excludedIds);
        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->productProvider->getItems($storeId);
        $this->assertExpectedProducts($items, $expectedItemsSecondStore, $excludedIds);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation disabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/product/products_with_none_excluded.php
     */
    public function testGetItemsWithNoneExcluded()
    {
        $expectedItems = $this->getExpectedItems();
        $items = $this->productProvider->getItems(self::DEFAULT_STORE_ID);
        $this->assertExpectedProducts($items, $expectedItems, []);
    }

    protected function assertExpectedProducts(array $items, array $expectedItems, array $excludedIds): void
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
            111 => [
                'url' => 'simple-product-111.html',
                'priority' => '1',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            112 => [
                'url' => 'simple-product-112.html',
                'priority' => '1',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            113 => [
                'url' => 'simple-product-113.html',
                'priority' => '1',
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
