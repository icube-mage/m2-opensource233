<?php
namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLE = 'autocategory_setting/general/enable';
    const XML_PATH_RANGE = 'autocategory_setting/general/new_range';
   
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
   
    public function getEnable()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getRange()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_RANGE, ScopeInterface::SCOPE_STORE);
    }
}
