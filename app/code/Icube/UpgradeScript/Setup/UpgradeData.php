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
            $this->returnexchange();
            
            $this->CmsPage_Home();
            $this->CmsBlock_Category();
            $this->CmsBlock_CategoryGender();
        }
    }

    /* CMS for Return Exchange */

    function returnexchange()
    {
        $pageContent = <<<EOD
        <p>Returns without the original receipt must reference the order number, which you may reprint from your order confirmation email. For customer convenience all orders are shipped with a prepaid JNE shipping label.</p>
        <h2>RETURNS BY JNE:</h2>
        <ol>
        <li>Keep the order summary portion of your shipping form as well as your order number and JNE tracking number from the prepaid JNE shipping label.</li>
        <li>On the Return Form, note the reason for the return: e.g. wrong item shipped; wrong color, etc. and include the form in the box.</li>
        <li>Use the pre-addressed prepaid JNE shipping label and drop the package off at any JNE location or drop box.</li>
        </ol>
        <h2>WHAT IF I LOST MY RETURN SLIP ?</h2>
        <p>If you do not have the mailing label from the original packing slip please use a signature-required service such as JNE to send your return back to us, or you can print the your data payment which we have sent to you by e-mail.<br><br>Mail your package to:<br><strong>New York, NY, 00841</strong><br>1-800-000-0000<br>yourmail@yourdomain.com</p>
        <h2>WHAT IF I DON’T HAVE MY ORDER NUMBER ?</h2>
        <p>If you don’t have your order number, please contact Customer Service so we can help you to get the order number. Please contact them via email at yourmail@yourdomain.com or call them at 1-800-000-0000.</p>
        <h2>SHIPPING DAMAGE:</h2>
        <p>If you receive an item that was damaged during shipment, contact our Customer Service team within 10 days of delivery at 1-800-000-0000. Please have your order number, item number and tracking number from your original confirmation e-mail.</p>
        <h2>GUARANTEED FOR LIFE</h2>
        <p>Quality. Durability. Reliability.<br> So if your pack ever breaks down, simply return it to our warranty center. We’ll fix it and if we can’t we’ll replace it*.</p>
        <h2>CUSTOMER SERVICE</h2>
        <p>We want to make sure you're happy with your shopping experience. Our Customer Service team can help resolve any problems you may have experienced with your purchase. Please contact them via email at yourmail@yourdomain.com or call them at 1-800-000-0000.</p>
        <p><br>*terms and conditions apply.</p>
EOD;

        $cmsPage = $this->createPage()->load('return-exchange', 'identifier');

        if (!$cmsPage->getId()) {
            $cmsPageContent = [
                'title' => 'Return & Exchange',
                'content_heading' => '',
                'page_layout' => '1column',
                'identifier' => 'return-exchange',
                'content' => $pageContent,
                'is_active' => 1,
                'stores' => [1],
                'sort_order' => 0,
            ];
            $this->createPage()->setData($cmsPageContent)->save();
        } else {
            $cmsPage->setContent($pageContent)->save();
        }
    }
    /* End of Return Exchange */
    
    /* CMS Homepage training */
    function CmsPage_Home()
    {
        $pageContent = <<<EOD
        <div class="page-wrapper">
            <div class="cms-block-satu">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cms-block-category"}}</div>
            <div class="cms-block-dua">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cms-block-category-gender"}}</div>
        </div>
EOD;
        $identifier='homepage-training';
        $title='Homepage Training';

        $cmsPage = $this->createPage()->load($identifier, 'identifier');

        if (!$cmsPage->getId()) {
            $cmsPageContent = [
                'title' => $title,
                'content_heading' => 'Home Page',
                'page_layout' => '1column',
                'identifier' => $identifier,
                'content' => $pageContent,
                'is_active' => 1,
                'stores' => [1],
                'sort_order' => 0,
            ];
            $this->createPage()->setData($cmsPageContent)->save();
        } else {
            $cmsPage->setContent($pageContent)->save();
        }
    }

    /* End of CMS homepage training*/

    /* CMS block Category */
    public function cmsBlock_Category()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-block-row">
            <div class="cms-block-item"><img src="{{media url="wysiwyg/tools.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>TOOLS &amp; EQUIPMENT</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
            <div class="cms-block-item-mid"><img src="{{media url="wysiwyg/equip.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>CLIMBING EQUIPMENT</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
            <div class="cms-block-item"><img src="{{media url="wysiwyg/accecories.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>ACCESSORIES</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
        </div>
        <div class="cms-block-row">
            <div class="cms-block-item"><img src="{{media url="wysiwyg/headwear.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>HEADWEAR</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
            <div class="cms-block-item-mid"><img src="{{media url="wysiwyg/foot.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>FOOT WEAR</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
            <div class="cms-block-item"><img src="{{media url="wysiwyg/bags.jpg"}}" alt="">
                <div class="cms-block-description">
                    <p>BAGS &amp; PACKS</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
        </div>
        
EOD;
        $identifier = 'cms-block-category';
        $title = 'CMS Block Category';
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
    /* End of CMS block Category*/

    /* CMS block Category Gender*/

    public function cmsBlock_CategoryGender()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-block-wrapper">
            <div class="cms-block-mens"><img src="{{media url="wysiwyg/mens.jpg"}}" alt="">
                <div class="cms-block-mens-desc">
                    <h2>MENS</h2>
                    <p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
            <div class="cms-block-womens"><img src="{{media url="wysiwyg/womens.jpg"}}" alt="">
                <div class="cms-block-womens-desc">
                    <h2>WOMENS</h2>
                    <p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <button class="cms-block-button" type="button">SHOP NOW</button>
                </div>
            </div>
        </div>
EOD;
        $identifier = 'cms-block-category-gender';
        $title = 'CMS Block Category Gender';
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

    /* End of CMS block Category*/
}
