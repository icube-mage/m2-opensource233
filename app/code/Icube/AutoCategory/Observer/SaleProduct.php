<?php
namespace Icube\AutoCategory\Observer;
 
use Magento\Framework\Event\ObserverInterface;
 
class SaleProduct implements ObserverInterface
{
	public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();

        $_sale = $product->getCustomSale();
        $_sku = $product->getSku();

        $idSale = '37';

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$categoryLinkManagement = $objectManager->get('Magento\Catalog\Api\CategoryLinkManagementInterface');
    	$categoryLinkRepository = $objectManager->get('Magento\Catalog\Model\CategoryLinkRepository');

    	if($_sale == 1){
    		$categoryIds= array($idSale);
            $categoryLinkManagement->assignProductToCategories($_sku, $categoryIds);
    	}else{
            $categoryLinkRepository->deleteByIds($idSale,$_sku);
    	}
    }
}