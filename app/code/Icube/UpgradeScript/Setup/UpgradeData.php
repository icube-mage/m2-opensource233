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
            $this->cmsPage_HomePage();
            $this->cmsBlock_Block6Images();
            $this->cmsBlock_BlockMensWomens();
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $this->cmsPage_HomePage();
            $this->cmsBlock_Block6Images();
            $this->cmsBlock_BlockMensWomens();
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

    /* CMS for Home Page */

    function cmsPage_HomePage() {
        $pageContent = <<<EOD
<p>{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cmsblock-6-images"}}</p>
<p>{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="cmsblock-mens-womens"}}</p>
EOD;
        $identifier = 'home';
        $title = 'Home Page';
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

    /* End of Home Page */

    /* CMS for Block 6 Images */

    function cmsBlock_Block6Images() {
        $cmsBlockContent = <<<EOD
<div class="cmsblock-6-images-wrapper">
    <div class="row-cat-1">
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/tools.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Tools & Equipment</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/equip.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Climbing Equipment</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/accecories.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Accessories</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/headwear.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Headwear</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/foot.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Footwear</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/bags.jpg"}}">
            <div class="cat-content">
                <div class="cat-name">Bags & Packs</div>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-1">Shop Now</a>
            </div>
        </div>
    </div>
</div>
EOD;
        $identifier = 'cmsblock-6-images';
        $title = 'CMS Block 6 Images';
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

    /* End of Block 6 Images */

    /* CMS for Block Mens Womens */

    function cmsBlock_BlockMensWomens() {
        $cmsBlockContent = <<<EOD
<div class="cmsblock-mens-womens-wrapper">
    <div class="row-cat-2">
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/mens.jpg"}}">
            <div class="cat-content">
                <div class="cat-name-2">Mens</div>
                <p class="cat-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etenim si delectamur, cum scribimus, quis est tam invidus, qui ab eo nos abducat? Quare attende, quaeso. Nam, ut paulo ante docui, augendae voluptatis finis est doloris omnis amotio.
                </p>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-2">Shop Now</a>
            </div>
        </div>
        <div class="cat-wrapper">
            <img src="{{media url="wysiwyg/img-category/womens.jpg"}}">
            <div class="cat-content">
                <div class="cat-name-2">Womens</div>
                <p class="cat-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etenim si delectamur, cum scribimus, quis est tam invidus, qui ab eo nos abducat? Quare attende, quaeso. Nam, ut paulo ante docui, augendae voluptatis finis est doloris omnis amotio.
                </p>
                <a href="{{store url="customer/account/login"}}" class="btn btn-category-2">Shop Now</a>
            </div>
        </div>
    </div>
</div>
EOD;
        $identifier = 'cmsblock-mens-womens';
        $title = 'CMS Block Mens Womens';
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

    /* End of Block Mens Womens */
}
