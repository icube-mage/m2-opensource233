<?php

namespace Icube\AutoCategory\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AddAttributeSet implements InstallDataInterface {

 private $eavSetupFactory;

 public function __construct(EavSetupFactory $eavSetupFactory) {
  $this->eavSetupFactory = $eavSetupFactory;
 }

 public function install(
     ModuleDataSetupInterface $setup,
     ModuleContextInterface $context) {

  $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

  $eavSetup->addAttribute(
      \Magento\Catalog\Model\Product::ENTITY, 'exclude_new',
      [
        'group'                   => 'General',
        'attribute_set'           => 'Default',
        'type'                    => 'int',
        'backend'                 => '',
        'frontend'                => '',
        'label'                   => 'Exclude From New',
        'input'                   => 'boolean',
        'class'                   => '',
        'source'                  => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
        'global'                  => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
        'visible'                 => true,
        'required'                => false,
        'user_defined'            => false,
        'default'                 => '0',
        'searchable'              => false,
        'filterable'              => false,
        'comparable'              => false,
        'visible_on_front'        => false,
        'used_in_product_listing' => false,
        'unique'                  => false,
        'apply_to'                => 'simple,configurable,virtual,bundle,downloadable'
      ]
  );

  $eavSetup->addAttribute(
      \Magento\Catalog\Model\Product::ENTITY, 'sale',
      [
        'group'                   => 'General',
        'attribute_set'           => 'Default',
        'type'                    => 'int',
        'backend'                 => '',
        'frontend'                => '',
        'label'                   => 'Sale',
        'input'                   => 'boolean',
        'class'                   => '',
        'source'                  => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
        'global'                  => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
        'visible'                 => true,
        'required'                => false,
        'user_defined'            => false,
        'default'                 => '0',
        'searchable'              => false,
        'filterable'              => false,
        'comparable'              => false,
        'visible_on_front'        => false,
        'used_in_product_listing' => false,
        'unique'                  => false,
        'apply_to'                => 'simple,configurable,virtual,bundle,downloadable'
      ]
  );
 }

}
