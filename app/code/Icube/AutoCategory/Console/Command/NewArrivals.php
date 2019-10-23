<?php
namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Data;

    /**
     * Class SomeCommand
     */
    class NewArrivals extends Command
    {

      const CUSTOMERNAME = 'Name';
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
        public function __construct(Data $data)
        {
          $this->data = $data;
          parent::__construct();
        }
        /**
         * @inheritDoc
         */
        protected function configure()
        {
        	$this->setName('category:newarrivals:enable');
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
          $cek1 = $objectManager->create('\Magento\Catalog\Model\Category')->getCollection();
          foreach ($cek1 as $category) {
            $tempCategory = $objectManager->create('\Magento\Catalog\Model\Category')->load($category->getEntityId());
            echo $cek12->getName();
// echo $category->getName() . '<br>';
            echo "<br>";
            // print_R($category->getData());
          }


          $cateid = '40';         
          $cateinstance = $objectManager->create('Magento\Catalog\Model\CategoryFactory');
          $allcategoryproduct = $cateinstance->create()->load($cateid)->getProductCollection()->addAttributeToSelect('*');
          $CategoryLinkRepository = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
          $temp = $allcategoryproduct->getData();
          var_dump($temp);
          // $temp = $temp[0]['sku'];
          foreach ($allcategoryproduct as $category) {
            // $categoryId = $cateid;
            //$sku = $category->getSku();
            //$CategoryLinkRepository->deleteByIds($categoryId,$sku);
            // print_R($category->getData());
          }
          $output->writeln($this->cek);
          $output->writeln('<info>Success Message.</info>');
          $output->writeln('<error>An error encountered.</error>');
        }
      }

      ?>