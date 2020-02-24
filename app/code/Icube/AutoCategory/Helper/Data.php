<?php 
namespace Icube\AutoCategory\Helper;

use \Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
    const NEW_ARRIVAL_ID = 41;
    const SALE_ID = 37;
    protected $customLogger;
    protected $helperConfig;
    protected $date;
    protected $productCollection;
    protected $categoryRepository;
    protected $categoryLinkRepository;
    protected $categoryLinkManagement;
    

    public function __construct(
        Context $context,
        \Icube\AutoCategory\Logger\Logger $customLogger,
        \Icube\AutoCategory\Helper\Config $helperConfig,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement
    ) {
        $this->customLogger = $customLogger;
        $this->helperConfig = $helperConfig;
        $this->date = $date;
        $this->productCollection = $productCollection;
        $this->categoryRepository = $categoryRepository;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->categoryLinkManagement = $categoryLinkManagement;
        parent::__construct($context);
    }    

    public function getNewArrivalId() {
        return self::NEW_ARRIVAL_ID;
    }

    public function getSaleId() {
        return self::SALE_ID;
    }

    public function getNewAssignment() {
        $this->customLogger->info('Executing new arrival assignment...');
        if ($this->helperConfig->isEnable() && (int)$this->helperConfig->getNewRange() >= 1) {
            //Category ID of New Arrival
            $categoryId = $this->getNewArrivalId();

            $newRange   = (int)$this->helperConfig->getNewRange();
            $now        = $this->date->gmtDate();
            $newDate    = strtotime('-'.$newRange.' day', strtotime($now));
            $newDate    = date('Y-m-d h:i:s', $newDate);
            $products   = $this->productCollection->create()
                            ->addAttributeToSelect('*')
                            ->addFieldToFilter('created_at', array('gteq' => $newDate))
                            ->addFieldToFilter('exclude_from_new', array('neq' => 1));

            if ($products->getSize()) {
                //Delete first unassignment product
                $newArray = array();
                foreach ($products as $product) {
                    $newArray[] = $product->getId();
                }

                $catLoad = $this->categoryRepository->get($categoryId);
                $catPids = $catLoad->getProductCollection();
                foreach ($catPids as $catPid) {
                    if (!in_array($catPid->getId(), $newArray)) {
                        $this->categoryLinkRepository->deleteByIds($categoryId,$catPid->getSku());
                    }
                }

                //Reassign product to category
                foreach ($products as $product) {
                    $categories = $product->getCategoryIds();
                    array_push($categories,$categoryId);
                    $this->categoryLinkManagement->assignProductToCategories($product->getSku(),$categories);
                }

                return $products;
            }
            else {
                $this->clearCategoryProducts($categoryId);
                return true;
            }
        }
        else {
            return false;
        }

    }

    public function clearCategoryProducts($categoryId) {
        $category = $this->categoryRepository->get($categoryId);
        $products = $category->getProductCollection();
        foreach ($products as $product) {
            $this->categoryLinkRepository->deleteByIds($categoryId,$product->getSku());
        }
    }

    public function getSaleCategories($product) {
        if ($product->getId()) {
            $categoryId = $this->getSaleId();
            $categories = $product->getCategoryIds();
            if ($product->getSale() == 1) {
                array_push($categories,$categoryId);
            }
            else {
                if (($key = array_search($categoryId, $categories)) !== false) {
                    unset($categories[$key]);
                }
            }
            return $categories;
        }
        else {
            return false;
        }

    }




    
}