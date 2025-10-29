<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('Magento/Store/_files/second_store.php');
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('MageSuite_ExtendedSitemap::Test/_files/category/categories_with_none_excluded.php');
$categoryRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class);
$storeRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Store\Api\StoreRepositoryInterface::class);

$category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Category::class);
$category->isObjectNew(true);
$category->setId(333)
    ->setCreatedAt('2024-07-18 09:00:00')
    ->setName('Category 333')
    ->setParentId(2)
    ->setPath('1/2/333')
    ->setLevel(2)
    ->setAvailableSortBy(['position', 'name'])
    ->setDefaultSortBy('name')
    ->setIsActive(true)
    ->setPosition(1)
    ->setIsExcludedFromSitemap(true)
    ->setStoreId(0)
    ->save();

$category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Category::class);
$category->isObjectNew(true);
$category->setId(444)
    ->setCreatedAt('2024-07-18 09:00:00')
    ->setName('Category 444')
    ->setParentId(2)
    ->setPath('1/2/444')
    ->setLevel(2)
    ->setAvailableSortBy(['position', 'name'])
    ->setDefaultSortBy('name')
    ->setIsActive(true)
    ->setPosition(1)
    ->setIsExcludedFromSitemap(false)
    ->setStoreId(0)
    ->save();

$storeManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Store\Model\StoreManagerInterface::class);
// change default store, otherwise store won't be updated for the category
$secondStore = $storeRepository->get('fixture_second_store');
$storeManager->setCurrentStore($secondStore->getId());
$category->setIsExcludedFromSitemap(true)->setStoreId($secondStore->getId());
$categoryRepository->save($category);
// back to default store
$storeManager->setCurrentStore(1);
