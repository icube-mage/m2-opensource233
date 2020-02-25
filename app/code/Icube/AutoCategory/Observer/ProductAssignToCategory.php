<?php

namespace Icube\AutoCategory\Observer;

use \Magento\Catalog\Api\CategoryLinkManagementInterface;
use \Magento\Catalog\Model\CategoryLinkRepository;
use \Magento\Catalog\Model\CategoryFactory;

class ProductAssignToCategory implements \Magento\Framework\Event\ObserverInterface
{
    /** @var \Magento\Catalog\Api\CategoryLinkManagementInterface */
    protected $categoryLinkManagement;

    /** @var \Magento\Catalog\Model\CategoryLinkRepository */
    protected $categoryLinkRepository;

    /**
     * @param \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement
     * @param \Magento\Catalog\Model\CategoryLinkRepository $categoryLinkRepository
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryLinkRepository $categoryLinkRepository,
        CategoryFactory $categoryFactory
    ) {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();

        $categoryTitle = 'Sale';
		$collection = $this->categoryFactory->create()->getCollection()
                      ->addAttributeToFilter('name',$categoryTitle)->setPageSize(1);
                      
		if ($collection->getSize()) {
		    $categoryIds[] = $collection->getFirstItem()->getId();
		}

        $isSale = $product->getSale();
        if($isSale):
            if ($product->getCategoryIds()):
                $categories = $product->getCategoryIds();
                array_push($categories,$categoryIds[0]);
                $product->setCategoryIds($categories);
                $categoryIds = $product->getCategoryIds(); 
            endif;
            $this->categoryLinkManagement->assignProductToCategories($product->getSku(), $categoryIds); 
        else:
            if(in_array($categoryIds[0],$product->getCategoryIds())):
	            $this->categoryLinkRepository->deleteByIds($categoryIds[0],$product->getSku());
            endif; 
        endif;

    }
}