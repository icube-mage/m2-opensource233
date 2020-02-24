<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper {

    public function __construct(Context $context) {
        parent::__construct($context);
    }

    public function isEnable() {
        return $this->scopeConfig->getValue('autocategory/general/enable', ScopeInterface::SCOPE_STORE);
    }

    public function getNewRange() {
        return $this->scopeConfig->getValue('autocategory/general/newrange', ScopeInterface::SCOPE_STORE);
    }

}