<?php

namespace Icube\AutoCategory\Observer;


class AutoCategory implements \Magento\Framework\Event\ObserverInterface
{

  public function execute(\Magento\Framework\Event\Observer $observer)
  {
   // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sale.log');
   // $logger = new \Zend\Log\Logger();
   // $logger->addWriter($writer);


   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
   $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
   $categoryLinkManagement = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');

   $tempProduct = $observer->getProduct();
   $tempExcludeFromNew = $tempProduct->getExcludeFromNew();
   $tempSale = $tempProduct->getSale();
   $tempSku = $tempProduct->getSku();

   // $logger->info('EFN '.$tempExcludeFromNew);
   // $logger->info('sale '.$tempSale);


   //input
   $temp=0;
   if($tempExcludeFromNew == 0){
    $temp++;
  }
  if($tempSale == 1){
    $temp++;
  }


  if($tempExcludeFromNew == 0 && $temp != 2){
    $tempId = array(41);
    $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  }else if($temp != 2){
    $tempId = 41;
    $CategoryLinkRepository->deleteByIds($tempId,$tempSku);
  }


  if($tempSale == 1 && $temp != 2){
    $tempId = array(37);
    $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  }else if($temp != 2){
    $tempId = 37;
    $CategoryLinkRepository->deleteByIds($tempId,$tempSku);
  }

  if($temp == 2){
    $tempId = array(37,41);
    $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  }





  //  if($tempExcludeFromNew == 1){
  //   $tempId = 41;
  //   $CategoryLinkRepository->deleteByIds($tempId,$tempSku);
  // }else if($tempExcludeFromNew == 0){
  //   $tempId = array(41);
  //   $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  //   $logger->info('Ot IN'.$tempProduct->getExcludeFromNew());
  // }


  // if($tempSale == 0){
  //   $tempId = 37;
  //   $CategoryLinkRepository->deleteByIds($tempId,$tempSku);
  // }else if($tempSale == 1){
  //   $tempId = array(37);
  //   $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  //   $logger->info('In push'.$tempProduct->getExcludeFromNew());
  // }   
  // if($tempSale == 1 && $tempExcludeFromNew == 0) {
  //    $tempId = array(37,41);
  //    $categoryLinkManagement->assignProductToCategories($tempSku,$tempId);
  // }
  // $logger->info($tempProduct->getSku());
  // $logger->info($tempExcludeFromNew);
  // $logger->info($tempSku);



}
}
