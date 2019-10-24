<?php

namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;


class NewArrivalsCommandEnable extends command{
      /**
     *  @var \Magento\Framework\App\Config\Storage\WriterInterface
     */

    /**
     *
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     */
    public function __construct(
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Icube\AutoCategory\Helper\Data $helper
        )
    {
        parent::__construct();
        $this->configWriter = $configWriter;
        $this->helper = $helper;
    }

    /**
     * @inheritdoc
     */
     protected function configure(){
         $this->setName('new-arrivals:enable');
         $this->setDescription('This command for enable auto "New Arrivals"');

         parent::configure();
     }

     /**
      * @inheritdoc
      */
     protected function execute(InputInterface $input, OutputInterface $output){
         $this->configWriter->save('auto_category/general/enable',  $value=1, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
         $output->writeln("Auto new arrivals has been enable");
        
         $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();       
         $categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
         $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
         $categoryLinkRepository = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface'); 


         $categoryId = 41;
         $category = $categoryFactory->create()->load($categoryId);
         $categoryProducts = $category->getProductCollection()
                             ->addAttributeToSelect('*');

                               
         $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/customer.log');
         $logger = new \Zend\Log\Logger();
         $logger->addWriter($writer);
                 
        $currentDate = date('Y-m-d');   
        $range= (string)$this->helper->getConfigRange();
        foreach ($categoryProducts as $productCategory) {
            $date= date("Y-m-d",strtotime($productCategory->getCreatedAt()."+ ".$range." day")); 
            $_sku= $productCategory->getSku();         
            if($currentDate==$date){
                $CategoryLinkRepository->deleteByIds($categoryId,$_sku);
            }
            
        }       
        
        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        /** Apply filters here */
        $collection = $productCollection->addAttributeToSelect('*')
        ->load();
        
        foreach ($collection as $product){
            $date= date("Y-m-d",strtotime($product->getCreatedAt()."+ ".$range." day")); 
            $_sku= $product->getSku();
            if($product->getExcludeFromNew()==0 && ($date!=$currentDate)){
                $categoryIds= array('41');
                $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
            }
            $logger->info($product->getExcludeFromNew()); 
         }
        
     }
}