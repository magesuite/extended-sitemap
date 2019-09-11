<?php

namespace MageSuite\ExtendedSitemap\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_CONFIGURATION_KEY = 'extended_sitemap/configuration';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    protected $serializer;

    protected $config = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\Framework\Serialize\SerializerInterface $serializer
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
        $this->serializer = $serializer;
    }

    public function isEnabled()
    {
        return $this->getConfig()->getAdditionalLinksEnabled();
    }

    public function getAdditionalLinks()
    {
        $additionalLinks =  $this->getConfig()->getAdditionalLinks();

        return $this->serializer->unserialize($additionalLinks);
    }

    protected function getConfig()
    {
        if ($this->config === null) {
            $config = $this->scopeConfig->getValue(self::XML_PATH_CONFIGURATION_KEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $this->config = new \Magento\Framework\DataObject($config);
        }

        return $this->config;
    }
}
