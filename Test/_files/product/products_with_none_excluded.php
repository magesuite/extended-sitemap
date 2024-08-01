<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('MageSuite_ExtendedSitemap::Test/_files/product/products_with_excluded.php');
$productRepository =  \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$product = $productRepository->get('simple112');
$product->setIsExcludedFromSitemap(false);
$productRepository->save($product);
