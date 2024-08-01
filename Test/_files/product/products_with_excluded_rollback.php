<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$productRepository = $objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$productRepository->cleanCache();
$registry = $objectManager->get(\Magento\Framework\Registry::class);

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

try {
    foreach (['simple113', 'simple112', 'simple111'] as $sku) {
        $productRepository->deleteById($sku);
    }
} catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
    //Product already removed
}

foreach (['simple-product-111.html', 'simple-product-112.html', 'simple-product-113.html'] as $key) {
    $urlRewrite = $objectManager->create(\Magento\UrlRewrite\Model\UrlRewrite::class)->load($key, 'request_path')->delete();
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);

\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('Magento/Store/_files/second_store_rollback.php');
