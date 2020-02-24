<?php

namespace Icube\AutoCategory\Model;

use Icube\AutoCategory\Helper\Config;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class AssigneeManagement
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryLinkManagementInterface
     */
    protected $categoryLinkManagement;

    /**
     * @var CategoryLinkRepositoryInterface
     */
    protected $categoryLinkRepository;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private $_collection;

    /**
     * @var \Magento\Catalog\Model\Category
     */
    private $_newCategory;

    /**
     * @var \Magento\Catalog\Model\Category
     */
    private $_saleCategory;

    /**
     * @param CategoryFactory $categoryFactory
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param CategoryLinkRepositoryInterface $categoryLinkRepository
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Config $config
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryLinkRepositoryInterface $categoryLinkRepository,
        ProductCollectionFactory $productCollectionFactory,
        Config $config
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->config = $config;
    }

    /**
     * Assign all product matching to filter to "New Arrivals" Category
     *
     * @param int $range
     * @return \Magento\Catalog\Model\Product[]
     */
    public function assignNew($range = null)
    {
        if ($range === null) {
            $range = $this->config->getDayAsNew();
        }

        $from = strtotime('-'.$range.' day');
        $category = $this->getNewCategory();
        $collection = $this->getProducts()
            ->addAttributeToFilter([
                ['attribute' => Config::ATTRIBUTE_NEW_CODE, 'null' => true],
                ['attribute' => Config::ATTRIBUTE_NEW_CODE, 'eq' => '0']
            ])
            ->addAttributeToFilter('created_at', ['lt' => date('Y-m-d h:i:s', $from)])
            ->load();
            
        $products = [];
        
        try {
            foreach ($collection as $product) {
                if ($product->getSku()) {
                    $this->categoryLinkManagement->assignProductToCategories($product->getSku(), [$category->getId()]);
                    $products[$product->getSku()] = $product;
                }
            }
        } catch (\Exception $e) {
            return false;
        }

        return $products;
    }

    /**
     * Un-Assign filtered product from "New Arrivals" Category
     *
     * @return \Magento\Catalog\Model\Product[]
     */
    public function cleanNew()
    {
        $range = $this->config->getDayAsNew();
        $dateFrom = strtotime('-' . $range . ' day');
        $category = $this->getNewCategory();
        $collection = $category->getProductCollection();
        $productPositions = $category->getProductsPosition();

        $removed = [];
        foreach ($collection as $product) {
            if (isset($productPositions[$product->getId()]) && strtotime($product->getCreatedAt()) > $dateFrom) {
                unset($productPositions[$product->getId()]);
                $removed[$product->getSku()] = $product;
            }
        }

        try {
            $category->setPostedProducts($productPositions);
            $category->save();
        } catch (\Exception $e) {
            return false;
        }

        return $removed;
    }

    /**
     * Add product to new arrivals category
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    public function markAsNewProduct(Product $product)
    {
        $category = $this->getNewCategory();
        $productCategoryIds = (array)$product->getCategoryIds();
        $range = $this->config->getDayAsNew();
        $dateFrom = strtotime('-' . $range . ' day');

        if (!in_array($category->getId(), $productCategoryIds) && strtotime($product->getCreatedAt()) < $dateFrom) {
            try {
                $this->categoryLinkManagement->assignProductToCategories($product->getSku(), [$category->getId()]);
                array_push($productCategoryIds, $category->getId());
                $product->setData('category_ids', $productCategoryIds);
            } catch (\Throwable $th) {
                return false;
            }
        }
        return true;
    }

    /**
     * Remove product from new arrivals category
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    public function unassignNewProduct(Product $product)
    {
        $category = $this->getNewCategory();
        $productCategoryIds = (array)$product->getCategoryIds();

        if (in_array($category->getId(), $productCategoryIds)) {
            try {
                $this->categoryLinkRepository->deleteByIds($category->getId(), $product->getSku());
                if (($key = array_search($category->getId(), $productCategoryIds)) !== false) {
                    unset($productCategoryIds[$key]);
                    $product->setData('category_ids', $productCategoryIds);
                }
            } catch (\Throwable $th) {
                return false;
            }
        }
        return true;
    }

    /**
     * Assign all product matching to filter to "SALE" Category
     *
     * @return \Magento\Catalog\Model\Product[]
     */
    public function assignSale()
    {
        $category = $this->getSaleCategory();
        $collection = $this->getProducts()
            ->addAttributeToFilter(Config::ATTRIBUTE_SALE_CODE, ['eq' => '1'])
            ->load();

        $products = [];

        try {
            foreach ($collection as $product) {
                if ($product->getSku()) {
                    $this->categoryLinkManagement->assignProductToCategories($product->getSku(), [$category->getId()]);
                    $products[$product->getSku()] = $product;
                }
            }
        } catch (\Exception $e) {
            return false;
        }

        return $products;
    }

    /**
     * Un-Assign filtered product from "SALE" Category
     *
     * @return \Magento\Catalog\Model\Product[]
     */
    public function cleanSale()
    {
        $category = $this->getSaleCategory();
        $collection = $category->getProductCollection()->addAttributeToSelect('*');
        $productPositions = $category->getProductsPosition();

        $removed = [];
        foreach ($collection as $product) {
            if (isset($productPositions[$product->getId()]) && (bool)(int)$product->getData(Config::ATTRIBUTE_SALE_CODE) === false) {
                unset($productPositions[$product->getId()]);
                $removed[$product->getSku()] = $product;
            }
        }

        try {
            $category->setPostedProducts($productPositions);
            $category->save();
        } catch (\Exception $e) {
            return false;
        }

        return $removed;
    }

    /**
     * Add product to SALE category
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    public function markAsSaleProduct(Product $product)
    {
        $category = $this->getSaleCategory();
        $productCategoryIds = (array) $product->getCategoryIds();

        if (!in_array($category->getId(), $productCategoryIds)) {
            try {
                $this->categoryLinkManagement->assignProductToCategories($product->getSku(), [$category->getId()]);
                array_push($productCategoryIds, $category->getId());
                $product->setData('category_ids', $productCategoryIds);
            } catch (\Throwable $th) {
                return false;
            }
        }
        return true;
    }

    /**
     * Remove product from SALE category
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return bool
     */
    public function unassignSaleProduct(Product $product)
    {
        $category = $this->getSaleCategory();
        $productCategoryIds = (array) $product->getCategoryIds();

        if (in_array($category->getId(), $productCategoryIds)) {
            try {
                $this->categoryLinkRepository->deleteByIds($category->getId(), $product->getSku());
                if (($key = array_search($category->getId(), $productCategoryIds)) !== false) {
                    unset($productCategoryIds[$key]);
                    $product->setData('category_ids', $productCategoryIds);
                }
            } catch (\Throwable $th) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get category object for New Arrivals Category
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function getNewCategory()
    {
        if (!$this->_newCategory) {
            $this->_newCategory = $this->categoryFactory->create()
                ->load($this->config->getNewCategoryId());
        }
        return $this->_newCategory;
    }

    /**
     * Get category object for SALE Category
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function getSaleCategory()
    {
        if (!$this->_saleCategory) {
            $this->_saleCategory = $this->categoryFactory->create()
                ->load($this->config->getSaleCategoryId());
        }
        return $this->_saleCategory;
    }

    /**
     * Get all products
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProducts()
    {
        if (!$this->_collection) {
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $this->_collection = $this->productCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->setPageSize(false);
        }
        return $this->_collection;
    }
}
