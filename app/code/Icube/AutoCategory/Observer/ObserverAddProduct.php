<?php
namespace Icube\AutoCategory\Observer;

class ObserverAddProduct implements \Magento\Framework\Event\ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/product.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $_product = $observer->getProduct();

        $_sku= $_product->getSku();
        $_sale= $_product->getSale();
        $logger->info($_sale);

        if($_sale==0){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');

            $categoryId= 37;
            $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
        }
    }
}