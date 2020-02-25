<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH = 'auto_category_setting/general/status';
    const NEW_RANGE = 'auto_category_setting/general/new_range';
    const USE_CRON = 'auto_category_setting/general/use_cron';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
    
    public function getConfigValue()
    {
        return  $this->scopeConfig->getValue(self::XML_PATH, ScopeInterface::SCOPE_STORE);
    }
    
    public function getNewRange()
    {
        return  $this->scopeConfig->getValue(self::NEW_RANGE, ScopeInterface::SCOPE_STORE);
    }
    
    public function getUseCron()
    {
        return  $this->scopeConfig->getValue(self::USE_CRON, ScopeInterface::SCOPE_STORE);
    }
     
}