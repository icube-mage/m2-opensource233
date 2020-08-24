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
        $configValue = $this->helper->getConfigValue();
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $collection = $productCollection->addAttributeToSelect('*')->load();
        
        if($configValue==1){
            foreach ($collection as $product){
                $sku = $product->getSku();
                if($product->getExcludeFromNew()==0){
                    $categoryIds= array('41');
                    $categoryLinkRepository->assignProductToCategories($sku, $categoryIds);
                    var_dump($product->getName());
                    die();
                }elseif($product->getExcludeFromNew()==1){
                    $CategoryLinkRepository->deleteByIds($categoryID,$sku);
                }
                $logger->info($product->getData()); 
             }
        }
    }

}