<?php

namespace MageSuite\ExtendedSitemap\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_CONFIGURATION_ADDITIONAL_LINKS_ENABLED = 'extended_sitemap/configuration/additional_links_enabled';
    const XML_PATH_CONFIGURATION_ADDITIONAL_LINKS = 'extended_sitemap/configuration/additional_links';

    protected \Magento\Framework\Serialize\SerializerInterface $serializer;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Serialize\SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->serializer = $serializer;
    }

    public function isEnabled($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CONFIGURATION_ADDITIONAL_LINKS_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getAdditionalLinks($storeId = null)
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_CONFIGURATION_ADDITIONAL_LINKS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );

        return $this->serializer->unserialize($value);
    }
}
