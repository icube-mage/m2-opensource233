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
            $this->cmsHomePageTraining_script(); //CMS PAGE
            $this->cmsBlockPertama_script(); // CMS Block
            $this->cmsBlockKedua_script(); // CMS Block
        }
    }

    /* CMS for Return Exchange */

//     function returnexchange()
//     {
//         $pageContent = <<<EOD
//         <p>Returns without the original receipt must reference the order number, which you may reprint from your order confirmation email. For customer convenience all orders are shipped with a prepaid JNE shipping label.</p>
//         <h2>RETURNS BY JNE:</h2>
//         <ol>
//         <li>Keep the order summary portion of your shipping form as well as your order number and JNE tracking number from the prepaid JNE shipping label.</li>
//         <li>On the Return Form, note the reason for the return: e.g. wrong item shipped; wrong color, etc. and include the form in the box.</li>
//         <li>Use the pre-addressed prepaid JNE shipping label and drop the package off at any JNE location or drop box.</li>
//         </ol>
//         <h2>WHAT IF I LOST MY RETURN SLIP ?</h2>
//         <p>If you do not have the mailing label from the original packing slip please use a signature-required service such as JNE to send your return back to us, or you can print the your data payment which we have sent to you by e-mail.<br><br>Mail your package to:<br><strong>New York, NY, 00841</strong><br>1-800-000-0000<br>yourmail@yourdomain.com</p>
//         <h2>WHAT IF I DON’T HAVE MY ORDER NUMBER ?</h2>
//         <p>If you don’t have your order number, please contact Customer Service so we can help you to get the order number. Please contact them via email at yourmail@yourdomain.com or call them at 1-800-000-0000.</p>
//         <h2>SHIPPING DAMAGE:</h2>
//         <p>If you receive an item that was damaged during shipment, contact our Customer Service team within 10 days of delivery at 1-800-000-0000. Please have your order number, item number and tracking number from your original confirmation e-mail.</p>
//         <h2>GUARANTEED FOR LIFE</h2>
//         <p>Quality. Durability. Reliability.<br> So if your pack ever breaks down, simply return it to our warranty center. We’ll fix it and if we can’t we’ll replace it*.</p>
//         <h2>CUSTOMER SERVICE</h2>
//         <p>We want to make sure you're happy with your shopping experience. Our Customer Service team can help resolve any problems you may have experienced with your purchase. Please contact them via email at yourmail@yourdomain.com or call them at 1-800-000-0000.</p>
//         <p><br>*terms and conditions apply.</p>
// EOD;

//         $cmsPage = $this->createPage()->load('return-exchange', 'identifier');

//         if (!$cmsPage->getId()) {
//             $cmsPageContent = [
//                 'title' => 'Return & Exchange',
//                 'content_heading' => '',
//                 'page_layout' => '1column',
//                 'identifier' => 'return-exchange',
//                 'content' => $pageContent,
//                 'is_active' => 1,
//                 'stores' => [1],
//                 'sort_order' => 0,
//             ];
//             $this->createPage()->setData($cmsPageContent)->save();
//         } else {
//             $cmsPage->setContent($pageContent)->save();
//         }
//     }

    /* End of Return Exchange */
    // Start CMS Page by Script
    public function cmsHomePageTraining_script()
    {
        $pageContent = <<<EOD
        <div class="cms-page-shop">
            <div class="cms-block-one">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cms-block-pertama"}}</div>
            <div class="cms-block-two">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cms-block-kedua"}}</div>
        </div>
EOD;
        $identifier = 'custom-page'; // nama identifier
        $title = 'Homepage Training'; // title pada CMS Page
        $cmsPage = $this->createPage()->load($identifier, 'identifier'); // declare Identifier

        if (!$cmsPage->getId()) {
            $cmsPageContent = [
                'title' => $title, //Title
                'content_heading' => '',
                'page_layout' => '1column',
                'identifier' => $identifier, //IDentifier
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
    // End CMS Page by Script

    // Start CMS Block Pertama by Script
    public function cmsBlockPertama_script()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-sub-block-one">
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/tools.jpg"}}" alt="tools and equipment">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2>TOOLS &amp; EQUIPMENT</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/equip.jpg"}}" alt="climbing equipment">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2>CLIMBING EQUIPMENT</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>    
                </div>
            </div>
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/accecories.jpg"}}" alt="accessories">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2><br>ACCESSORIES</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cms-sub-block-two">
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/headwear.jpg"}}" alt="headwear">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2><br>HEADWEAR</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/foot.jpg"}}" alt="footwear">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2><br>FOOTWEAR</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>     
                </div>
            </div>
            <div class="cms-content-template">
                <img src="{{media url="wysiwyg/bags.jpg"}}" alt="bags and packs">
                <div class="cms-content-layout">
                    <div class="cms-content-title">
                        <h2>BAGS &amp; PACKS</h2>
                    </div>
                    <div class="cms-content-button">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop">SHOP NOW</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
EOD;
        $identifier = 'cms-block-pertama'; // Identifier
        $title = 'CMS Block Pertama'; // Title CMS Block
        $cmsBlock = $this->createBlock()->load($identifier, 'identifier');

        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => $title, // Title
                'identifier' => $identifier, // Identifier
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }
    // End CMS Block pertama by Script
    // Start CMS Block Kedua by Script
    public function cmsBlockKedua_script()
    {
        $cmsBlockContent = <<<EOD
        <div class="cms-content-men">
            <div class="cms-content-template-2">
                <img src="{{media url="wysiwyg/mens.jpg"}}" alt="mens">
                <div class="cms-content-layout-2">
                    <div class="cms-content-title-2">
                        <h1>MENS</h1>
                    </div>
                    <div class="cms-content-description-2">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, dolore? Eligendi ab autem optio hic iure officiis iste repellat fuga?</p>
                    </div>
                    <div class="cms-content-button-2">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop-2">SHOP NOW</button>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="cms-content-women">
            <div class="cms-content-template-2">
                <img src="{{media url="wysiwyg/womens.jpg"}}" alt="womens">
                <div class="cms-content-layout-2">
                    <div class="cms-content-title-2">
                        <h1>WOMENS</h1>
                    </div>
                    <div class="cms-content-description-2">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti, dolore? Eligendi ab autem optio hic iure officiis iste repellat fuga?</p>
                    </div>
                    <div class="cms-content-button-2">
                        <a href="http://local.m2-opensource233.me/customer/account/login">
                            <button class="cms-button-shop-2">SHOP NOW</button>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>


EOD;
        $identifier = 'cms-block-kedua'; // Identifier
        $title = 'CMS Block Kedua'; // Title CMS Block
        $cmsBlock = $this->createBlock()->load($identifier, 'identifier');

        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => $title, // Title
                'identifier' => $identifier, // Identifier
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }
    // End CMS Block by Script

}