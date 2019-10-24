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
	
	/*public function cekLogin(){
		$id = $this->customerSession->getData('customer_id');
		if($id){
			$customer = $this->customer->load($id);
			return $customer->getFirstname();
		}else{
			return "Guest";
		}
	}

	public function getCategoryProduct(){
		$category = $this->_categoryFactory->create();
    	$category->load(1);
    	return $category;*/
		// $tempcategory = $category->getCollection();
			// return $category;
		// foreach ($tempcategory as $listCategory) {
              // echo "<pre>";
              // print_R($listCategory->getData());
        // }
		// $id = $this->customerSession->getData('customer_id');
		/*if($id){
			$customer = $this->customer->load($id);
			return $customer->getFirstname();
		}else{
		}*/
	// }
	/*public function getCategory($categoryId) 
    {
        $category = $this->_categoryFactory->create();
        $category->load($categoryId);
        return $category;
    }

	public function getCategoryProducts($categoryId) 
    {
    	$allcategoryproduct = $this->_categoryFactory->create()->load($categoryId)->getProductCollection()->addAttributeToSelect('*');
        // $products = $this->getCategory($categoryId)->getProductCollection();
        // $products->addAttributeToSelect('*');
        return $allcategoryproduct;
    }*/

	public function getStatus(){
		return $this->scopeConfig->getValue('autocategory_setting/general/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		// return "2";
	}

	public function getRange(){
		return $this->scopeConfig->getValue('autocategory_setting/general/newrange',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		// return "2";
	}

	public function setStatus($value){
		$cek = $this->configWriter->save('autocategory_setting/general/enable', $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
		// return $this->scopeConfig->getValue('autocategory_setting/general/enable',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

}

?>