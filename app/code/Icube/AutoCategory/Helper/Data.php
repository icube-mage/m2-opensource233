<?php
namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   const XML_PATH_ENABLED = 'autocategory_setting/general/enabled';
   const XML_PATH_RANGE = 'autocategory_setting/general/rangeday';
   
   public function __construct(Context $context)
   {
		parent::__construct($context);
   }
   
   public function getConfigEnabled()
   {
       return $this->scopeConfig->getValue(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
   }

   public function getConfigRange()
   {
       return $this->scopeConfig->getValue(self::XML_PATH_RANGE, ScopeInterface::SCOPE_STORE);
   }
}