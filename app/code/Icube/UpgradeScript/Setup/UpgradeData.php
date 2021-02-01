<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icube\UpgradeScript\Setup;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

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

    /**
     * Init
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(
        BlockFactory $modelBlockFactory,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $modelBlockFactory;
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

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->cms_page();
            $this->cms_block1();
            $this->cms_block2();
        }
        
    }

    /* CMS for Return Exchange */

    

    public function cms_page()
    {
        $pageContent = <<<EOD
        <div class="page-wrapper">
            <div class="content-first">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="19"}}</div>
            <div class="content-second">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="20"}}</div>
        </div>
EOD;
        $identifier = 'homepage-training';
        $title = 'Homepage Training';
        $cmsPage = $this->createPage()->load($identifier, 'identifier');

        if (!$cmsPage->getId()) {
            $cmsPageContent = [
                'title' => $title,
                'content_heading' => '',
                'identifier' => $identifier,
                'content' => $pageContent,
                'is_active' => 1,
                'page_layout' => '1column',
                'stores' => [0],
                'sort_order' => 0,
            ];
            $this->createPage()->setData($cmsPageContent)->save();
        } else {
            $cmsPage->setContent($pageContent)->save();
        }
    }


    public function cms_block1()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-block-content">
            <div class="cms-block-row">
                <div class="cms-block-item"><img src="{{media url="catalog/tools.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>TOOLS &amp; EQUIPMENT</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
                <div class="cms-block-item-mid"><img src="{{media url="equip.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>CLIMBING EQUIPMENT</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
                <div class="cms-block-item"><img src="{{media url="accecories.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>ACCESSORIES</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
                </div>
                <div class="cms-block-row">
                <div class="cms-block-item"><img src="{{media url="headwear.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>HEADWEAR</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
                <div class="cms-block-item-mid"><img src="{{media url="foot.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>FOOT WEAR</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
                <div class="cms-block-item"><img src="{{media url="bags.jpg"}}" alt="">
                <div class="cms-block-desc">
                <p>BAGS &amp; PACKS</p>
                <button class="cms-block-button" type="button">SHOP NOW</button></div>
                </div>
            </div>
        </div>
EOD;
        $identifier = 'cms-block-top';
        $title = 'CMS Block Top';
        $cmsBlock = $this->createBlock()->load($identifier, 'identifier');

        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => $title,
                'identifier' => $identifier,
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function cms_block2()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-block-mw">
            <div class="cms-block-mens"><img src="{{media url="mens.jpg"}}" alt="">
            <div class="cms-block-mens-desc">
            <h2>MENS</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <button class="cms-block-button-mw" type="button">SHOP NOW</button></div>
            </div>
            <div class="cms-block-womens"><img src="{{media url="womens.jpg"}}" alt="">
            <div class="cms-block-womens-desc">
            <h2>WOMENS</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <button class="cms-block-button-mw" type="button">SHOP NOW</button></div>
            </div>
        </div>
EOD;
        $identifier = 'cms-block-men-womens';
        $title = 'CMS Block Mens and Womens';
        $cmsBlock = $this->createBlock()->load($identifier, 'identifier');

        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => $title,
                'identifier' => $identifier,
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    
    /* End of Return Exchange */
}