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

      const STATUS = 'Status';
      // const RANGE = 'Range';
      // const CRON = 'Cron';
      public $cek = "Trisna Risnandar";

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
          $commandoptions = [new InputOption(self::STATUS, null, InputOption::VALUE_REQUIRED, 'Status')];
          // $commandoptions = [new InputOption(self::RANGE, null, InputOption::VALUE_REQUIRED, 'Range')];
          // $commandoptions = [new InputOption(self::CRON, null, InputOption::VALUE_REQUIRED, 'Cron')];

          $this->setName('category:newarrivals:list');
          $this->setDescription('This is my first console command.');
          $this->setDefinition($commandoptions);
          $this->addArgument('number', InputArgument::REQUIRED, __('Type a string'));

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
              $tempp = date('d',strtotime($date));
              $tempp1 = date('d',strtotime($category->getCreatedAt()));
              $tempp1 = $tempp1+$this->data->getRange();
              if($tempp >= $tempp1){
                $categoryId = $cateid;
                $sku = $category->getSku();
                $CategoryLinkRepository->deleteByIds($categoryId,$sku);
              }
            }
          }

          // $output->writeln($this->data->setStatus(0));
         /* $output->writeln($this->data->getStatus());
          $output->writeln($this->cek);
          $output->writeln('<info>Success Message.</info>');
          $output->writeln('<error>An error encountered.</error>');*/
        }
      }

      ?>