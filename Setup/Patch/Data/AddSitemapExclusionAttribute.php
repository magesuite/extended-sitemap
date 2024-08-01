<?php

declare(strict_types=1);

namespace MageSuite\ExtendedSitemap\Setup\Patch\Data;

class AddSitemapExclusionAttribute implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    const ATTRIBUTE_CODE = 'is_excluded_from_sitemap';

    protected \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup;
    protected \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory;
    protected \Magento\Eav\Setup\EavSetup $eavSetup;

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @throws \Magento\Framework\Validator\ValidateException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply(): void
    {
        $this->eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $this->addProductAttribute();
        $this->addCategoryAttribute();
    }

    protected function addProductAttribute(): void
    {
        if ($this->eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, self::ATTRIBUTE_CODE)) {
            return;
        }

        $entityType = \Magento\Catalog\Model\Product::ENTITY;
        $this->eavSetup->addAttribute(
            $entityType,
            self::ATTRIBUTE_CODE,
            [
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'type' => 'int',
                'label' => 'Exclude from Sitemap',
                'input' => 'boolean',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'default' => 0,
                'user_defined' => true,
                'unique' => false,
                'required' => false,
                'sort_order' => 100,
                'visible' => true,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true
            ]
        );

        $attribute = $this->eavSetup->getAttribute($entityType, self::ATTRIBUTE_CODE);
        $entityTypeId = \Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE;
        $setIds = $this->eavSetup->getAllAttributeSetIds($entityTypeId);

        foreach ($setIds as $setId) {
            $groupId = $this->eavSetup->getDefaultAttributeGroupId($entityType, $setId);
            $this->eavSetup->addAttributeToGroup(
                $entityTypeId,
                $setId,
                $groupId,
                self::ATTRIBUTE_CODE,
                100
            );
        }
    }

    protected function addCategoryAttribute(): void
    {
        if ($this->eavSetup->getAttributeId(\Magento\Catalog\Model\Category::ENTITY, self::ATTRIBUTE_CODE)) {
            return;
        }

        $this->eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'type' => 'int',
                'label' => 'Exclude from Sitemap',
                'input' => 'boolean',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'group' => 'General Information',
                'visible'   => true,
                'required' => false,
                'sort_order' => 40,
                'user_defined' => 1,
                'unique' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
            ]
        );
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
