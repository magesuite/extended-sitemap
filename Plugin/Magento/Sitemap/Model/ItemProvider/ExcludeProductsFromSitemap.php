<?php

declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Plugin\Magento\Sitemap\Model\ItemProvider;

class ExcludeProductsFromSitemap
{
    protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\Product $subject, array $result, int $storeId): array
    {
        $items = $result;
        $products = $this->productCollectionFactory->create()
            ->setStoreId($storeId)
            ->addAttributeToSelect('is_excluded_from_sitemap')
            ->addAttributeToFilter('is_excluded_from_sitemap', ['eq' => 1]);

        foreach ($products as $product) {
            if (isset($items[$product->getId()])) {
                unset($items[$product->getId()]);
            }
        }

        return $items;
    }
}
