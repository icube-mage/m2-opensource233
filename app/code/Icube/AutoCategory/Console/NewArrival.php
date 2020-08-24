<?php
namespace Icube\AutoCategory\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Icube\AutoCategory\Helper\Data;

class NewArrival extends Command
{
    protected $helper;
    protected $productCollection;
    
    public function __construct(
        Data $helper,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory
    ) {
        $this->helper = $helper;
        $this->productCollection = $productCollectionFactory;
        parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName('final:newarr');
        $this->setDescription('Training command line');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryLinkRepository = $objectManager->get('Magento\Catalog\Api\CategoryLinkManagementInterface');
        $categoryLinkRepositorys = $objectManager->get('\Magento\Catalog\Model\CategoryLinkRepository');
        $currDate = date('Y-m-d');
        $range= (string)$this->helper->getRange();
        $enablSetup= $this->helper->getEnable();
        $collection = $this->productCollection->addAttributeToSelect('*')->load();
  
        $categoryId = '41';

        $categoryIds = array('41');
        // $sku = '24-MB01';
        // $categoryLinkRepository->assignProductToCategories($sku, $categoryIds);
        // die();
        var_dump("range : " . $range);
        if ($enablSetup==1) {
            foreach ($collection as $product) {
                $_sku = $product->getSku();
                $_createdAt = date("Y-m-d", strtotime($product->getCreatedAt()));
                $date = date("Y-m-d", strtotime($_createdAt . "+ " . $range . " day"));
                $booleDate = ($_createdAt <= $currDate && $date >= $currDate);
                // $from=date_create($currDate);
                // $to=date_create($_createdAt);
                // $diff=date_diff($to, $from)->format('%a');
                
                if ($product->getExcludeFromNew() == 0) {
                    // var_dump("if");
                    if ($booleDate == true) {
                        // var_dump("boole Range");
                        $categoryIds= array('41');
                        $categoryLinkRepository->assignProductToCategories($_sku, $categoryIds);
                    } elseif ($booleDate == false && $product->getCategoryIds() != null) {
                        // var_dump($product->getSku());
                        var_dump("error 3");
                        $categoryLinkRepositorys->deleteByIds($categoryId, $_sku);
                        var_dump("Exception Range");
                    } else {
                        // var_dump("error 2");
                        // Exception
                    }
                } elseif (($product->getExcludeFromNew() == 1 && $product->getCategoryIds() != null)) {
                    // var_dump("else " . $product->getSku());
                    $categoryLinkRepositorys->deleteByIds($categoryId, $_sku);
                } else {
                    var_dump("error 1");
                    // Exception
                }
            }
        } else {
            $output->writeln("New Arrival disabled");
        }
    }
}
