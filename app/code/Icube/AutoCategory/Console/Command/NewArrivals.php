<?php
namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Data;

    /**
     * Class SomeCommand
     */
    class NewArrivals extends Command
    {

         /**
         * Module list
         *
         * @var Data
         */
         private $data;

        /**
         * @param bookingFactory $bookingFactory
         */
        public function __construct(
          Data $data
        )
        {
          $this->data = $data;
          parent::__construct();
        }
        /**
         * @inheritDoc
         */
        protected function configure()
        {

          $this->setName('category:newarrivals:list');
          $this->setDescription('This is my first console command.');

          parent::configure();
        }

        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         *
         * @return null|int
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {

          $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
          $category = $objectManager->create('\Magento\Catalog\Model\Category')->getCollection();
          $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
          $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');

          $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');


          $Product = $objectManager->create('Magento\Catalog\Model\Product')->getCollection()->addAttributeToSelect('*');
          $categoryLinkManagement = $objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
          $date = $objDate->gmtDate();

          $status = $this->data->getStatus();
          if($status == 1){
            $cateid = 41; 
            foreach ($Product as $list) {
              $tempp = date('d-m-Y',strtotime($date));
              $tempp1 = date('d-m-Y',strtotime('+'.$this->data->getRange().'days' ,strtotime($list->getCreatedAt())));

              $sku = $list->getSku();
              if(($list->getExcludeFromNew() == 1) && ($tempp > $tempp1)){
                $categoryId = $cateid;
                $CategoryLinkRepository->deleteByIds($categoryId,$sku);
              }else if(($list->getExcludeFromNew() == 0) && ($tempp <= $tempp1)){
                $tempId = array($cateid);
                $categoryLinkManagement->assignProductToCategories($sku,$tempId);
              }

            }
            $output->writeln('<info>Success Message.</info>');
          }else{
            $output->writeln('<error>Status Not Enable.</error>');
          }
          // echo $status;

        }
      }

      ?>