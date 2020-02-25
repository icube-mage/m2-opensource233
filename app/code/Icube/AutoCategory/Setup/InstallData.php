<?php

namespace Icube\AutoCategory\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * Class InstallData
 * @package Icube\AutoCategory\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'exclude_from_new');
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'sale');

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'exclude_from_new',
            [
               'group' => 'General',
               'type' => 'int',
               'label' => 'Exclude From New',
               'input' => 'boolean',
               'source' => \Magento\Catalog\Model\Product\Attribute\Source\Boolean::class,
               'required' => false,
               'default' => 0,
               'sort_order' => 100,
               'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
               'used_in_product_listing' => false,
               'visible_on_front' => false,
               'attribute_set_name' => 'default'
            ]
        );

        
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'sale',
            [
               'group' => 'General',
               'type' => 'int',
               'label' => 'Sale',
               'input' => 'boolean',
               'source' => \Magento\Catalog\Model\Product\Attribute\Source\Boolean::class,
               'required' => false,
               'default' => 0,
               'sort_order' => 101,
               'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
               'used_in_product_listing' => true,
               'visible_on_front' => true,
               'attribute_set_name' => 'default'
            ]
        );
    }
}