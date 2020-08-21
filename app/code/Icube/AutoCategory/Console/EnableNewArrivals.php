<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Icube\AutoCategory\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;

class EnableNewArrivals extends Command
{
	protected $helper;
  protected $productCollection;
	const NAME = 'name';
	
	public function __construct(
	    Data $helper,
      \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory
	){
		$this->helper = $helper;
    $this->productCollection = $productCollectionFactory;
		parent::__construct();
	}
	
   protected function configure()
   {
       $this->setName('final:enableArrivals');
       $this->setDescription('Training command line');
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
   		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      $categoryLinkRepository = $objectManager->get('Magento\Catalog\Api\CategoryLinkManagementInterface');
      $categoryLinkRepositorys = $objectManager->get('Magento\Catalog\Model\CategoryLinkRepository');

      $categoryId = '41';
      
      $_enable= $this->helper->getEnabled();

      $collection = $this->productCollection->addAttributeToSelect('*')->load();

      if($_enable==1)
      {
        foreach ($collection as $product) {
          $_sku = $product->getSku();
          if($product->getExcludeFromNew()==1)
          {
            $categoryIds= array('41');
            $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
          }else
          {
            $categoryLinkRepositorys->deleteByIds($categoryId,$_sku);
          }
        }        
      }      
   }
}