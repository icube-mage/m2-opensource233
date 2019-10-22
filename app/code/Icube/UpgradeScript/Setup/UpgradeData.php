<?php
/**
 * Copyright © 2018 Icube. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Icube\UpgradeScript\Setup;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use \Magento\Catalog\Model\Product;
/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Page factory
     *
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var BlockFactory
     */
    protected $blockFactory;
    protected $_eavAttribute;
    protected $_resourceConnection;
    protected $_attributeModel;
    private $_eavSetup;
    /**
     * Init
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(
        BlockFactory $modelBlockFactory,
        PageFactory $pageFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Customer\Model\Attribute $attributeModel,
        \Magento\Eav\Setup\EavSetup $eavSetup
    )
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $modelBlockFactory;
        $this->_eavAttribute = $eavAttribute;
        $this->_resourceConnection = $resourceConnection;
        $this->_attributeModel = $attributeModel;
        $this->_eavSetup = $eavSetup;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->blockTask4();
            $this->updateHomepage();
            
        }
    }
    /**
     * Create page
     *
     * @return Page
     */
    public function createPage()
    {
        return $this->pageFactory->create();
    }
    /**
     * Create block
     *
     * @return Page
     */
    public function createBlock()
    {
        return $this->blockFactory->create();
    }
    private function blockTask4(){
        /* adjust these vars value below whichever you need on your update */
        $cmsBlockContent = <<<EOD
        <div class="task4"><img src="{{media url="wysiwyg/Capture.PNG"}}" alt="">
        <div class="produk"><a class="lihatsemua" href="http://local.m2-opensource233.com/lmen.html">Lihat Semua</a> {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" show_pager="0" products_count="3" template="Magento_CatalogWidget::product/widget/content/grid.phtml" conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`operator`:`==`,`value`:`41`^]^]"}}</div>
        </div>
EOD;
        $identifier = 'task4';
        $title = 'task4';
        $isActive = 1;
        $cmsBlock = $this->createBlock()->load($identifier, 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => $title,
                'identifier' => $$identifier,
                'content' => $cmsBlockContent,
                'is_active' => $isActive,
                'stores' => [0],
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->setTitle($title)->save();
        }
    }
    private function updateHomepage(){
        /* adjust these vars value below whichever you need on your update */
        $pageContent = <<<EOD
        <p>{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="19"}}</p>
EOD;
        $identifier = 'home';
        $title = 'Home Page';
        $contentHeading = '';
        $pageLayout = '1column';
        $isActive = 1;
        $cmsPage = $this->createPage()->load($identifier, 'identifier');
        if (!$cmsPage->getId()) {
            $cmsPageContent = [
                'title' => $title,
                'content_heading' => $contentHeading,
                'page_layout' => $pageLayout,
                'identifier' => $identifier,
                'content' => $pageContent,
                'is_active' => $isActive,
                'stores' => [0],
                'sort_order' => 0,
            ];
            $this->createPage()->setData($cmsPageContent)->save();
        } else {
            $cmsPage->setContent($pageContent)->setTitle($title)->setContentHeading($contentHeading)->setLayout($pageLayout)->setIsActive($isActive)->save();
        }
    }
}