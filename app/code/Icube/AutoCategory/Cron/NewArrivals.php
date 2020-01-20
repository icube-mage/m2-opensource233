<?php 

namespace Icube\AutoCategory\Cron;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;

class NewArrivals extends Action
{
	protected $_productCollectionFactory;
	protected $_scopeConfig;
	protected $_categoryCollectionFactory;
	protected $_categoryLinkManagement;
	protected $_categoryLinkRepository;
	protected $_storeScope;
	protected $data;
	
	public function __construct(
		Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,        
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
		\Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement,
		\Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository,
		array $data = []
	){
		$this->_productCollectionFactory	= $productCollectionFactory;    
		$this->_scopeConfig					= $scopeConfig;
		$this->_categoryCollectionFactory	= $categoryCollectionFactory;
		
		$this->_categoryLinkManagement		= $categoryLinkManagement;
		$this->_categoryLinkRepository		= $categoryLinkRepository;
		
		$this->_storeScope	= \Magento\Store\Model\ScopeInterface::SCOPE_STORES;
		
		$this->data = $data;
		
		parent::__construct($context);

	}
	public function execute()
	{
		//Call logger
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron_autocategory.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		//End Call logger
		
		# check if module enable
		$isEnabled = $newrange	= $this->_scopeConfig->getValue("autocategory/general/enable", $this->_storeScope);
		
		if($isEnabled == 1)
		{
			# get new range days
			$newrange	= $this->_scopeConfig->getValue("autocategory/general/newrange", $this->_storeScope);
			
			# get category id for New Arrivals
			$newArrival = $this->_categoryCollectionFactory
					->create()
					->addAttributeToFilter('name',"New Arrivals")
					->setPageSize(1);
			$newCategoryId = '';
			if ($newArrival->getSize()) {
				$newCategoryId = $newArrival->getFirstItem()->getId();
			}
			
			# get product collection
			$collection = $this->_productCollectionFactory->create();
			$collection->addAttributeToSelect('*');
			
			$i = 0;
			
			foreach ($collection as $product) {
				
				# get product sku
				$productSku = $product->getSku();
				
				# get product categories
				$categoryIds = $product->getCategoryIds();
				
				// if(isset($product['is_excluded_from_new']) && $product['is_excluded_from_new'] == '1')
				// $datediff = strtotime(date('Y-m-d')) - strtotime($product['created_at']);
				
				$date1 = $product['created_at']; 
				$date2 = date('Y-m-d'); 
				
				// Calulating the difference in timestamps 
				$diff = strtotime($date2) - strtotime($date1); 
				// 1 day = 24 hours 
				// 24 * 60 * 60 = 86400 seconds 
				$datediff = abs(round($diff / 86400)); 
				
				if(($datediff > $newrange) || $product['is_excluded_from_new'] == '1')
				{
					if(in_array($newCategoryId,$categoryIds))
					{
						# remove product from category if assigned
						$this->_categoryLinkRepository->deleteByIds($newCategoryId,$productSku);
						$categoryIds = $product->getCategoryIds();
						$logger->info("Unassigned SKU : ".$productSku);
					}
				}
				else
				{
					if(!in_array($newCategoryId,$categoryIds))
					{
						# add product to category if exclude_from_new not 1 and has not assigned yet
						array_push($categoryIds,$newCategoryId);
						$this->_categoryLinkManagement->assignProductToCategories($productSku, $categoryIds);
						$logger->info("Assigned SKU : ".$productSku);
					}
				}
				$i++;
			}
			$msg = 'Success';
		}
		else
		{
			$msg = 'Module Disabled';
		}
		echo $msg;
		$logger->info($msg);
		
		exit();
	}

}
