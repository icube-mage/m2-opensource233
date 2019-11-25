<?php

namespace Icube\AutoCategory\Observer;

use Magento\Framework\Event\ObserverInterface;

class Productsaveafter implements ObserverInterface
{    
    protected $_categoryCollectionFactory;
	protected $_categoryLinkManagement;
    protected $_categoryLinkRepository;

    public function __construct(
		\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
		\Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement,
        \Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository,
        array $data = []
	){
		
		$this->_categoryCollectionFactory	= $categoryCollectionFactory;
		$this->_categoryLinkManagement		= $categoryLinkManagement;
		$this->_categoryLinkRepository		= $categoryLinkRepository;
		$this->data = $data;

	}
    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //Call logger
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/logsavesale.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        //End Call logger

        # get category id for New Arrivals
		$newArrival = $this->_categoryCollectionFactory
                ->create()
                ->addAttributeToFilter('name',"Sale")
                ->setPageSize(1);
        $newCategoryId = '';
        if ($newArrival->getSize()) {
            $newCategoryId = $newArrival->getFirstItem()->getId();
           // $logger->info($newCategoryId);
        }

        $_product = $observer->getProduct();  // you will get product object
        $_sku=$_product->getSku(); // for sku
        $categoryIds = $_product->getCategoryIds();
        array_push($categoryIds,$newCategoryId);
        $this->_categoryLinkManagement->assignProductToCategories($_sku, $categoryIds);
        //$logger->info($_sku);
        

    }   
}