<?php

namespace Icube\AutoCategory\Cron;


class CronAutoCategory
{

protected $storeManager;
protected $emulation;
protected $productCollectionFactory;
protected $productStatus;
protected $productVisibility;
protected $_categoryCollectionFactory;
protected $_categoryLinkManagement;
protected $_categoryLinkRepository;


public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Store\Model\App\Emulation $emulation,
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
    \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
    \Magento\Catalog\Model\Product\Visibility $productVisibility,
    \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
	\Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement,
    \Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository,
    array $data = []
)
{
    $this->scopeConfig=$scopeConfig;
    $this->storeManager = $storeManager;
    $this->emulation = $emulation;
    $this->productCollectionFactory = $productCollectionFactory;
    $this->productStatus = $productStatus;
    $this->productVisibility = $productVisibility;
    $this->_categoryCollectionFactory	= $categoryCollectionFactory;
	$this->_categoryLinkManagement		= $categoryLinkManagement;
    $this->_categoryLinkRepository		= $categoryLinkRepository;
    $this->data = $data;
}

public function execute()
{
    //Call logger
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
	$logger = new \Zend\Log\Logger();
	$logger->addWriter($writer);
    //End Call logger

    $activemode=(int) $this->scopeConfig->getValue('autocategory/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);


    if($activemode == 1){

    # get category id for New Arrivals
		$newArrival = $this->_categoryCollectionFactory
        ->create()
        ->addAttributeToFilter('name',"New Arrivals")
        ->setPageSize(1);
        $newCategoryId = '';
        if ($newArrival->getSize()) {
            $newCategoryId = $newArrival->getFirstItem()->getId();
        }

    $this->emulation->startEnvironmentEmulation(1, \Magento\Framework\App\Area::AREA_FRONTEND, true);

    
    //Call product collection
    $collection = $this->productCollectionFactory->create();
    $collection
        ->addAttributeToSelect('*')
        ->addStoreFilter($this->storeManager->getStore()->getId())
        ->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
        ->addAttributeToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()])
        ->addAttributeToFilter('exclude_from_new_attribute', '0') //filter product auto category
        ->load(); 

    $this->emulation->stopEnvironmentEmulation();
    $newrangeconf=(int) $this->scopeConfig->getValue('autocategory/general/newrange', \Magento\Store\Model\ScopeInterface::SCOPE_STORE); //get from conf file
    foreach ($collection as $product) {
        # get product sku
			$productSku = $product->getSku();
			
		# get product categories
		$categoryIds = $product->getCategoryIds();

        $currentdate=date_create();
        $creatdateproduct=date_create($product->getData('created_at'));
        $periodtime  = date_diff($creatdateproduct, $currentdate);
        $periodproduct=$periodtime->d;
        if($periodproduct <= $newrangeconf){
            $logger->info($periodtime->d." masuk range" );
            if(!in_array($newCategoryId,$categoryIds))
            {
                # add product to category if exclude_from_new not 1 and has not assigned yet
                array_push($categoryIds,$newCategoryId);
                $this->_categoryLinkManagement->assignProductToCategories($productSku, $categoryIds);
            }
        }else{
            
            $logger->info($periodtime->d." tdk masuk range" );
            if(in_array($newCategoryId,$categoryIds))
            {
                # remove product from category if assigned
                $this->_categoryLinkRepository->deleteByIds($newCategoryId,$productSku);
                $categoryIds = $product->getCategoryIds();
            }
        }


    }

}else{
    $logger->info('not active');
}     
		

		return $this;
}
	
}