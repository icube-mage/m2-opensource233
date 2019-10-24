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
          // 0/5 * * * * php bin/magento category:newarrivals:list
          // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sale.log');
          //  $logger = new \Zend\Log\Logger();
          //  $logger->addWriter($writer);
          //  $logger->info("Trisna Risnandar");

          $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
          $cek1 = $objectManager->create('\Magento\Catalog\Model\Category')->getCollection();
          $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
          $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');

          $date = $objDate->gmtDate();

          $cateid;         
          foreach ($cek1 as $category) {
            $tempCategory = $objectManager->create('\Magento\Catalog\Model\Category')->load($category->getEntityId());
            if($tempCategory->getName() == "New Arrivals"){
              $cateid = $tempCategory->getEntityId();
            }
          }

          $cateinstance = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
          $allcategoryproduct = $cateinstance->create()->load($cateid)->getProductCollection()->addAttributeToSelect('*');
          // echo '++++'.date('d',strtotime($date)).'++++';

          $status = $this->data->getStatus();
          // echo $status;
          if($status == 0){
          // echo '---'.$this->data->getRange().'----';
            foreach ($allcategoryproduct as $category) {
              $tempp = date('d-m-Y',strtotime($date));
              $tempp1 = date('d-m-Y',strtotime('+'.$this->data->getRange().'days' ,strtotime($category->getCreatedAt())));
              // $tempp1 = $tempp1+$this->data->getRange();
              if($tempp <= $tempp1){
                $categoryId = $cateid;
                $CategoryLinkRepository->deleteByIds($categoryId,$sku);
                $sku = $category->getSku();
                // echo $sku;
              }
            }
            $output->writeln('<info>Success Message.</info>');
          }else{
            $output->writeln('<error>Status Not Enable.</error>');
          }

                // echo $status;

          // $output->writeln($this->data->setStatus(0));
         /* $output->writeln($this->data->getStatus());
          $output->writeln($this->cek);
          $output->writeln('<error>An error encountered.</error>');*/
        }
      }

      ?>