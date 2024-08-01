<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('MageSuite_ExtendedSitemap::Test/_files/cms/pages_with_none_excluded.php');
$pageRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Cms\Api\PageRepositoryInterface::class);

foreach ([444, 555] as $pageId) {
    $page = $pageRepository->getById($pageId);
    $page->setIsExcludedFromSitemap(true);
    $pageRepository->save($page);
}
