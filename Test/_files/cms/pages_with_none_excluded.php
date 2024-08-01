<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('Magento/Store/_files/second_store.php');
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$storeRepository = $objectManager->get(\Magento\Store\Api\StoreRepositoryInterface::class);

$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(333)
    ->setTitle('Cms Page 100')
    ->setIdentifier('page100')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page 100 Title</h1>')
    ->setContentHeading('<h2>Cms Page 100 Title</h2>')
    ->setMetaTitle('Cms Meta title for page100')
    ->setMetaKeywords('Cms Meta Keywords for page100')
    ->setMetaDescription('Cms Meta Description for page100')
    ->setPageLayout('1column')->save();

$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(444)
    ->setTitle('Cms Page Design Blank')
    ->setIdentifier('page_design_blank')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page Design Blank Title</h1>')
    ->setContentHeading('<h2>Cms Page Blank Title</h2>')
    ->setMetaTitle('Cms Meta title for Blank page')
    ->setMetaKeywords('Cms Meta Keywords for Blank page')
    ->setMetaDescription('Cms Meta Description for Blank page')
    ->setPageLayout('1column')
    ->setCustomTheme('Magento/blank')->save();

$secondStore = $storeRepository->get('fixture_second_store');
$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(555)
    ->setTitle('Cms Page Second Store')
    ->setIdentifier('page_second_store')
    ->setStores([$secondStore->getId()])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page Second Store Title</h1>')
    ->setContentHeading('<h2>Cms Page Second Store Title</h2>')
    ->setMetaTitle('Cms Meta title for Second Store page')
    ->setMetaKeywords('Cms Meta Keywords for Second Store page')
    ->setMetaDescription('Cms Meta Description for Second Store page')
    ->setPageLayout('1column')
    ->save();
