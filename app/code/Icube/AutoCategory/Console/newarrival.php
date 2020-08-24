<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class newarrival extends Command
{
    protected $helper;
	
	public function __construct(
	    \Icube\AutoCategory\Helper\Data $helper
	){
		$this->helper = $helper;
		parent::__construct();
    }
    
   protected function configure()
   {
       $this->setName('final:newarrival');
       $this->setDescription('Command New Arrival');
       
       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
    //    $output->writeln("Tes Command New Arrival");
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();       
        $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
        $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface'); 
        $categoryID = 41;
        $configEnabled = $this->helper->getConfigEnabled();
        $configRange = (string)$this->helper->getConfigRange();
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $collection = $productCollection->addAttributeToSelect('*')->load();
        $currentDate = date('Y-m-d');
        if($configEnabled==1){
            foreach ($collection as $product){
                $startDate= date("Y-m-d",strtotime($product->getCreatedAt())); 
                $endDate= date("Y-m-d",strtotime($product->getCreatedAt()."+ ".$configRange." day")); 
                $sku = $product->getSku();
                if($product->getExcludeFromNew()==0){
                    if($startDate <= $currentDate && $endDate >= $currentDate){
                        $categoryIds= array('41');
                        echo 'Product Assigned to New Arrival Category';
                        $categoryLinkRepository->assignProductToCategories($sku, $categoryIds);
                    }
                    else if($currentDate > $endDate && $product->getCategoryIds()==NULL ){
                    
                    }
                    else if($currentDate > $endDate && $product->getCategoryIds()==$categoryID ){
                        echo 'Expired Product Unassigned';
                        $CategoryLinkRepository->deleteByIds($categoryID,$sku);
                    }
                    else{
                        echo 'Expired Product Unassigned';
                        $CategoryLinkRepository->deleteByIds($categoryID,$sku);
                    }
                }
                else if($product->getExcludeFromNew()==1 && $product->getCategoryIds()==$categoryID ){
                    
                }
                else if($product->getCategoryIds() == NULL){
                    
                }
                else{
                    echo 'Product Excluded';
                    $CategoryLinkRepository->deleteByIds($categoryID,$sku);
                }
             }
        }else if($configEnabled==0)
        {
            echo 'Auto Category has been disabled';
        }
    }

}