<?php

namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	protected $configWriter;
	protected $scopeConfig;

	public function __construct(
		Context $context,
		\Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	){
		parent::__construct($context);
		$this->configWriter = $configWriter;
		$this->scopeConfig = $scopeConfig;
	}

	public function getStatus(){
		return $this->scopeConfig->getValue('autocategory_setting/general/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function getRange(){
		return $this->scopeConfig->getValue('autocategory_setting/general/newrange',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function setStatus($value){
		return $this->configWriter->save('autocategory_setting/general/enable', $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
	}

}

?>