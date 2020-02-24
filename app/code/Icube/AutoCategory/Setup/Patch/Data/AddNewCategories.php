<?php

namespace Icube\AutoCategory\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Icube\AutoCategory\Helper\Config;

class AddNewCategories implements DataPatchInterface
{
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @param CategoryFactory $categoryFactory
     * @param StoreManagerInterface $storeManager
     * @param WriterInterface $configWriter
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        StoreManagerInterface $storeManager,
        WriterInterface $configWriter
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->storeManager = $storeManager;
        $this->configWriter = $configWriter;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function apply()
    {
        /** @var \Magento\Store\Api\Data\StoreInterface $store */
        $store = $this->storeManager->getWebsite(1)->getDefaultStore();
        $parentId = $store->getRootCategoryId();

        $newArrivalCategory = $this->categoryFactory->create()
            ->setName(Config::CATEGORY_NEW_NAME)
            ->setParentId($parentId)
            ->setIsActive(true)
            ->setStoreId(0)
            ->save();

        if ($newArrivalCategory->getId()) {
            $newArrivalCategory->setPath('1/'.$parentId.'/'.$newArrivalCategory->getId())->save();
            $this->configWriter->save(
                'autocategory/categories/new_category',
                $newArrivalCategory->getId()
            );
        }

        $saleCategory = $this->categoryFactory->create()
            ->setName(Config::CATEGORY_SALE_NAME)
            ->setParentId($parentId)
            ->setIsActive(true)
            ->setStoreId(0)
            ->save();

        if ($saleCategory->getId()) {
            $saleCategory->setPath('1/'.$parentId.'/'.$saleCategory->getId())->save();
            $this->configWriter->save(
                'autocategory/categories/sale_category',
                $saleCategory->getId()
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            \Magento\Catalog\Setup\Patch\Data\InstallDefaultCategories::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
