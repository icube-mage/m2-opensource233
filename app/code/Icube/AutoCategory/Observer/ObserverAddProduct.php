<?php
namespace Icube\AutoCategory\Observer;

class ObserverAddProduct implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
		\Icube\AutoCategory\Helper\Data $helper
	){
		$this->helper = $helper;
	}

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_product = $observer->getProduct();

        $_sku= $_product->getSku();
        $_sale= $_product->getSale();
        $_excludeNew= $_product->getExcludeFromNew();
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
        $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface'); 

        
        
        if($_sale==1 && $_excludeNew==0){
            $categoryIds= array('37','41');
            $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
        }else{
            if($_sale==1){
                $categoryIds= array('37');
                $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
            }else{
                $categoryId= 37;
                $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
            }
            
            
            if($_excludeNew==0){
                $categoryIds= array('41');
                $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
            }else{
                $categoryId= 41;
                $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
            }
            
        }
        
        
        $_enable= $this->helper->getConfigEnable();
        
  
    }
}