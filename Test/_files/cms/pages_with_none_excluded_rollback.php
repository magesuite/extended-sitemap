<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$pageRepository = $objectManager->get(\Magento\Cms\Api\PageRepositoryInterface::class);
$searchCriteriaBuilder = $objectManager->get(\Magento\Framework\Api\SearchCriteriaBuilder::class);
$searchCriteria = $searchCriteriaBuilder->addFilter(\Magento\Cms\Api\Data\PageInterface::IDENTIFIER, ['page100', 'page_design_blank', 'page_second_store'], 'in')->create();
$result = $pageRepository->getList($searchCriteria);

foreach ($result->getItems() as $item) {
    $pageRepository->delete($item);
}
