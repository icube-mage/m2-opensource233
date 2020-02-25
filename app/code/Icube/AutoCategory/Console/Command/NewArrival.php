<?php
namespace Icube\AutoCategory\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use \Magento\Catalog\Api\CategoryLinkManagementInterface;
use \Magento\Catalog\Model\CategoryLinkRepository;
use \Magento\Catalog\Model\CategoryFactory;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Icube\AutoCategory\Helper\Config;


/**
 * Class ExportTrainee
 */
class NewArrival extends Command
{
    /** @var \Magento\Catalog\Api\CategoryLinkManagementInterface */
    protected $categoryLinkManagement;

    /** @var \Magento\Catalog\Model\CategoryLinkRepository */
    protected $categoryLinkRepository;

    /**
     * @param \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement
     * @param \Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param Icube\AutoCategory\Helper\Config $helper
     */
    public function __construct
    (
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryLinkRepository $categoryLinkRepository,
        CategoryFactory $categoryFactory,
        CollectionFactory $productCollectionFactory,
        Config $helper
    ){
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->categoryFactory = $categoryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->helper = $helper;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected  function configure()
    {
        $this->setName('icube:autocategory:newarrival');
        $this->setDescription('Assign Product to New Arrival Category.');
        parent::configure();
    }

    /**
     * Execute the command
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return null|int
     */
    protected function  execute(InputInterface $input, OutputInterface $output)
    {
        $categoryIds = [];
        $categoryTitle = 'New Arrival';
		$collection = $this->categoryFactory->create()->getCollection()
                      ->addAttributeToFilter('name',$categoryTitle)->setPageSize(1);
        
        if ($collection->getSize()) {
            $categoryIds[] = $collection->getFirstItem()->getId();
        }

        $rangeConfig = $this->helper->getNewRange();
        $range = strtotime("-".$rangeConfig." day");
        $newRange = date('Y-m-d H:i:s', $range);
        
        $collections = $this->getProductInRange($newRange);
        if($collections):
            foreach ($collections as $product) {
                $output->writeln('Product Name = '.$product->getName());
                if($product->getExcludeFromNew() == 0):
                    foreach($product->getCategoryIds() as $categori_id):
                        array_push($categoryIds,$categori_id);
                    endforeach;
                    $this->categoryLinkManagement->assignProductToCategories($product->getSku(), $categoryIds); 
                elseif($product->getExcludeFromNew()):
                    if(in_array($categoryIds[0],$product->getCategoryIds())):
                        $this->categoryLinkRepository->deleteByIds($categoryIds[0],$product->getSku());
                    endif; 
                endif;
            }
        else:
            $categoriProducts = $this->getProductOnCategory($categoryIds);
            if($categoriProducts):
                foreach ($categoriProducts as $product) {
                    $this->categoryLinkRepository->deleteByIds($categoryIds[0],$product->getSku());
                }
            endif;
        endif;
    }
    
    public function getProductInRange($dateRange)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('created_at', ['gteq' => $dateRange]);

        return $collection;
        // return null;
    }

    public function getProductOnCategory($categoryIds)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['eq' => $categoryIds]);

        return $collection;
    }
}