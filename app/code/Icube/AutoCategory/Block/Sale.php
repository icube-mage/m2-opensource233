<?php

namespace Icube\AutoCategory\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class Sale extends \Magento\Framework\View\Element\Template
{
    protected $_registry;
    
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ){
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getCurrentCategory()
    {        
        return $this->_registry->registry('current_category');
    }
    
    public function getCurrentProduct()
    {        
        return $this->_registry->registry('current_product');
    }    
}