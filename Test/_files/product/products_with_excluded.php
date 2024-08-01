<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('Magento/Store/_files/second_store.php');
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('MageSuite_ExtendedSitemap::Test/_files/category/categories_with_none_excluded.php');
$storeRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Store\Api\StoreRepositoryInterface::class);
$productRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);

$product = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Product::class);
$product
    ->setTypeId('simple')
    ->setId(111)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Product 111')
    ->setSku('simple111')
    ->setPrice(10)
    ->setMetaTitle('meta title')
    ->setMetaKeyword('meta keyword')
    ->setMetaDescription('meta description')
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(['use_config_manage_stock' => 0])
    ->save();

$product = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Product::class);
$product
    ->setTypeId('simple')
    ->setId(112)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Product 112')
    ->setSku('simple112')
    ->setPrice(10)
    ->setMetaTitle('meta title2')
    ->setMetaKeyword('meta keyword')
    ->setMetaDescription('meta description')
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(['use_config_manage_stock' => 0])
    ->setIsExcludedFromSitemap(true)
    ->save();

$product = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Product::class);
$product
    ->setTypeId('simple')
    ->setId(113)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Product 113')
    ->setSku('simple113')
    ->setPrice(10)
    ->setMetaTitle('meta title3')
    ->setMetaKeyword('meta keyword')
    ->setMetaDescription('meta description')
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(['use_config_manage_stock' => 0])
    ->setIsExcludedFromSitemap(false)
    ->save();

$store = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Store\Model\Store::class);
$storeId = $store->load('fixture_second_store', 'code')->getId();
$product->setStoreId($storeId)->setIsExcludedFromSitemap(true);
$productRepository->save($product);
