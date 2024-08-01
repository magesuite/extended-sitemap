<?php

declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Plugin\Magento\Sitemap\Model\ItemProvider;

class ExcludeCategoriesFromSitemap
{
    protected \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\Category $subject, array $result, int $storeId): array
    {
        $items = $result;
        $categories = $this->categoryCollectionFactory->create()
            ->setStoreId($storeId)
            ->addAttributeToSelect('is_excluded_from_sitemap')
            ->addAttributeToFilter('is_excluded_from_sitemap', ['eq' => 1]);

        foreach ($categories as $category) {
            if (isset($items[$category->getId()])) {
                unset($items[$category->getId()]);
            }
        }

        return $items;
    }
}
