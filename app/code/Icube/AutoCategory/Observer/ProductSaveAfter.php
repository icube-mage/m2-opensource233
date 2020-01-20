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
        $logger->info('masuk sini');
        //End Call logger

        # get category id for Sale
		$getSaleCategory = $this->_categoryCollectionFactory
                ->create()
                ->addAttributeToFilter('name',"Sale")
                ->setPageSize(1);
        $saleCategoryId = '';
        if ($getSaleCategory->getSize()) {
            $saleCategoryId = $getSaleCategory->getFirstItem()->getId();
        }

        $product    = $observer->getEvent()->getProduct(); // you will get product object
        $sku        = $product->getSku(); 
        $isSaleable = $product->getIsSaleable();
        $categoryIds = $product->getCategoryIds();
        
        if($isSaleable == "1"){
            if(!in_array($saleCategoryId,$categoryIds))
            {
                array_push($categoryIds,$saleCategoryId);
                $this->_categoryLinkManagement->assignProductToCategories($sku, $categoryIds);
            }
        }
        else{
            if(in_array($saleCategoryId,$categoryIds))
            {
                $this->_categoryLinkRepository->deleteByIds($saleCategoryId,$sku);
            }
        }
        $logger->info(json_encode($product->getData()));
        $logger->info('end of observer'); 
    }
}