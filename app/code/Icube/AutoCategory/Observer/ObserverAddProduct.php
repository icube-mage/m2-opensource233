<?php
namespace Icube\AutoCategory\Observer;

class ObserverAddProduct implements \Magento\Framework\Event\ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_product = $observer->getProduct();

        $_sku= $_product->getSku();
        $_sale= $_product->getSale();
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
        $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface'); 
        
        if($_sale==1){
            $categoryIds= array('37');
            $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
        }else{
            $categoryId= 37;
            $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
        }
    }
}