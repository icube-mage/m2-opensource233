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

}

?>