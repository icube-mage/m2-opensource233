<?php
namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   const XML_PATH = 'autocategory_setting/general/enabled';
   
   public function __construct(Context $context)
   {
		parent::__construct($context);
   }
   
   public function getConfigValue()
   {
       return $this->scopeConfig->getValue(self::XML_PATH, ScopeInterface::SCOPE_STORE);
   }
}