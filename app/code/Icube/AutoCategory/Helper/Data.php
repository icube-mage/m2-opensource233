<?php
namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
  public function __construct(
    Context $context
  ){
    parent::__construct($context);
    $this->scopeConfig = $context->getScopeConfig();
  }

  public function getEnabled()
  {
    return $this->scopeConfig->getValue(
      'auto_category/general/enabled', ScopeInterface::SCOPE_STORE
    );
  }

  public function getHello()
  {
    return "Hello World !";
  }
}