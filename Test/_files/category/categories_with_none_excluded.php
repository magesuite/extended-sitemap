<?php
$category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Category::class);
$category->isObjectNew(true);
$category->setId(111)
    ->setCreatedAt('2024-07-18 09:00:00')
    ->setName('Category 111')
    ->setParentId(2)
    ->setPath('1/2/111')
    ->setLevel(2)
    ->setAvailableSortBy(['position', 'name'])
    ->setDefaultSortBy('name')
    ->setIsActive(true)
    ->setPosition(1)
    ->save();

$category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(\Magento\Catalog\Model\Category::class);
$category->isObjectNew(true);
$category->setId(222)
    ->setCreatedAt('2024-07-18 09:00:00')
    ->setName('Category 222')
    ->setParentId(2)
    ->setPath('1/2/222')
    ->setLevel(2)
    ->setAvailableSortBy(['position', 'name'])
    ->setDefaultSortBy('name')
    ->setIsActive(true)
    ->setPosition(1)
    ->save();
