<?php
\Magento\TestFramework\Workaround\Override\Fixture\Resolver::getInstance()->requireDataFixture('Magento/Store/_files/second_store.php');
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$storeRepository = $objectManager->get(\Magento\Store\Api\StoreRepositoryInterface::class);

$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(333)
    ->setTitle('Cms Page 333')
    ->setIdentifier('page333')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page 333 Title</h1>')
    ->setContentHeading('<h2>Cms Page 100 Title</h2>')
    ->setMetaTitle('Cms Meta title for page333')
    ->setMetaKeywords('Cms Meta Keywords for page333')
    ->setMetaDescription('Cms Meta Description for page333')
    ->setPageLayout('1column')->save();

$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(444)
    ->setTitle('Cms Page 444')
    ->setIdentifier('page444')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page 444 Title</h1>')
    ->setContentHeading('<h2>Cms Page 444 Title</h2>')
    ->setMetaTitle('Cms Meta title for page444')
    ->setMetaKeywords('Cms Meta Keywords for page444')
    ->setMetaDescription('Cms Meta Description for page444')
    ->setPageLayout('1column')->save();

$secondStore = $storeRepository->get('fixture_second_store');
$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setId(555)
    ->setTitle('Cms Page 555 Second Store')
    ->setIdentifier('page555')
    ->setStores([$secondStore->getId()])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page Second Store Title</h1>')
    ->setContentHeading('<h2>Cms Page Second Store Title</h2>')
    ->setMetaTitle('Cms Meta title for Second Store page')
    ->setMetaKeywords('Cms Meta Keywords for Second Store page')
    ->setMetaDescription('Cms Meta Description for Second Store page')
    ->setPageLayout('1column')
    ->save();
