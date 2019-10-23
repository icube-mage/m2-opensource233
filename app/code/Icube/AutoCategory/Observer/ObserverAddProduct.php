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

        $_sale= $_product->getSale();
        $logger->info($_sale);
    }
}