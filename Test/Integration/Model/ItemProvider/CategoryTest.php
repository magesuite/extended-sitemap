<?php
declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Test\Integration\Model\ItemProvider;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    public const DEFAULT_STORE_ID = 1;
    public const SECOND_STORE_CODE = 'fixture_second_store';

    protected ?\Magento\Sitemap\Model\ItemProvider\Category $categoryProvider = null;
    protected ?\Magento\Store\Api\StoreRepositoryInterface $storeRepository = null;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->categoryProvider = $objectManager->get(\Magento\Sitemap\Model\ItemProvider\Category::class);
        $this->storeRepository = $objectManager->get(\Magento\Store\Api\StoreRepositoryInterface::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/category/categories_with_excluded.php
     */
    public function testGetItemsWithExcluded()
    {
        $expectedItems = $this->getExpectedItems([333]);

        $items = $this->categoryProvider->getItems(self::DEFAULT_STORE_ID);

        foreach ($items as $index => $item) {
            $this->assertEquals($expectedItems[$index]['url'], $item->getUrl());
            $this->assertEquals($expectedItems[$index]['priority'], $item->getPriority());
            $this->assertEquals($expectedItems[$index]['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItems[$index]['images'], $item->getImages());
        }
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/category/categories_with_excluded.php
     */
    public function testGetItemsWithExcludedFromSecondStore()
    {
        $excludedCategoryIds = [333,444];
        $expectedItems = $this->getExpectedItems($excludedCategoryIds);

        $storeId = $this->storeRepository->get(self::SECOND_STORE_CODE)->getId();
        $items = $this->categoryProvider->getItems($storeId);

        foreach ($items as $index => $item) {
            $this->assertEquals($expectedItems[$index]['priority'], $item->getPriority());
            $this->assertEquals($expectedItems[$index]['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItems[$index]['images'], $item->getImages());
        }
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_ExtendedSitemap::Test/_files/category/categories_with_none_excluded.php
     */
    public function testGetItemsWithNoneExcluded()
    {
        $expectedItems = $this->getExpectedItems([333,444]);
        $items = $this->categoryProvider->getItems(self::DEFAULT_STORE_ID);

        foreach ($items as $index => $item) {
            $this->assertEquals($expectedItems[$index]['url'], $item->getUrl());
            $this->assertEquals($expectedItems[$index]['priority'], $item->getPriority());
            $this->assertEquals($expectedItems[$index]['changeFrequency'], $item->getChangeFrequency());
            $this->assertEquals($expectedItems[$index]['images'], $item->getImages());
        }
    }

    protected function getExpectedItems(array $excludedIds = []): array
    {
        $expectedItems = [
            111 => [
                'url' => 'category-1.html',
                'priority' => '0.5',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            222 => [
                'url' => 'category-2.html',
                'priority' => '0.5',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            333 => [
                'url' => 'category-3.html',
                'priority' => '0.5',
                'changeFrequency' => 'daily',
                'images' => null
            ],
            444 => [
                'url' => 'category-4.html',
                'priority' => '0.5',
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
