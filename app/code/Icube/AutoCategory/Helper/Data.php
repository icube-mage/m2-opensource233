<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	public function __construct(
		Context $context
	){
		parent::__construct($context);
		$this->scopeConfig = $context->getScopeConfig();
	}
	
	public function getConfigEnable(){
		return $this->scopeConfig->getValue('auto_category/general/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

}

?>