<?php

declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Plugin\Magento\Sitemap\Model\ItemProvider;

class ExcludeCmsPagesFromSitemap
{
    protected \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory;

    public function __construct(
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\CmsPage $subject, array $result): array
    {
        $items = $result;
        $pages = $this->pageCollectionFactory->create()
            ->addFieldToFilter('is_excluded_from_sitemap', ['eq' => 1]);

        foreach ($pages as $page) {
            if (isset($items[$page->getId()])) {
                unset($items[$page->getId()]);
            }
        }

        return $items;
    }
}
