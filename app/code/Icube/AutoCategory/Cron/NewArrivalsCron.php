<?php
namespace Icube\AutoCategory\Cron;
 
class NewArrivalsCron
{
    protected $_logger;
 
    public function __construct(\Psr\Log\LoggerInterface $logger,
    \Icube\AutoCategory\Helper\Data $helper) {
        $this->_logger = $logger;
        $this->helper = $helper;
    }

    public function execute()
    {
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();       
        $categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
        $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');

        $categoryId = 41;
        $category = $categoryFactory->create()->load($categoryId);
        $categoryProducts = $category->getProductCollection()
                             ->addAttributeToSelect('*');

                               
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/customer.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
                 
        foreach ($categoryProducts as $productCategory) {
            $range= (string)$this->helper->getConfigRange();
            $date= date("Y-m-d",strtotime($productCategory->getCreatedAt()."+ ".$range." day")); 
            $currentDate = date('Y-m-d');   
            $_sku= $productCategory->getSku();         
            if($currentDate==$date){
                $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
            }

            $logger->info($productCategory->getSku()); 
        }

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("test"); 

    }
}