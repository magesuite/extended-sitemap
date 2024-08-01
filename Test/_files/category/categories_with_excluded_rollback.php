<?php
$registry = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Framework\Registry::class);
$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

foreach ([111, 222, 333, 444] as $categoryId) {
    $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Category::class);
    $category->load($categoryId);

    if ($category->getId()) {
        $category->delete();
    }
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);
