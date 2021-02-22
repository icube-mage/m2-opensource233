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
    }
    if (version_compare($context->getVersion(), '1.0.2', '<')) {
      $this->cmsBlock_categoryByProduct();
      $this->cmsBlock_categoryByGender();
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

  public function cmsBlock_categoryByProduct()
  {
    $cmsBlockContent = <<<EOD
    <div class="container">
<div class="category-product-container">
<div class="row">
<div class="col-md-4 col-sm-6 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Tools &amp; Equipment</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img src="{{media url="catalog/category/tools.jpg"}}" alt=""></div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Climbing Equipment</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img src="{{media url="catalog/category/equip.jpg"}}" alt=""></div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Accessories</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img class="img-item-fluid" src="{{media url="catalog/category/accecories.jpg"}}" alt=""></div>
</div>
</div>
<div class="row">
<div class="col-md-4 col-sm-6 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Headwear</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img src="{{media url="catalog/category/headwear.jpg"}}" alt=""></div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Footwear</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img src="{{media url="catalog/category/foot.jpg"}}" alt=""></div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12 p-0">
<div class="img_item_wrapper">
<div class="banner_content_wrapper">
<div class="content_label mb-5">Bags &amp; Packs</div>
<div><a class="button_shop" href="{{store url="customer/account/login"}}">SHOP NOW</a></div>
</div>
<img class=" img-item-fluid" src="{{media url="catalog/category/bags.jpg"}}" alt=""></div>
</div>
</div>
</div>
</div>
EOD;
    $identifier = 'category_by_product';
    $title = 'Category By Product';
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

  public function cmsBlock_categoryByGender()
  {
    $cmsBlockContent = <<<EOD
    <div class="category-by-gender">
<div class="row no-gutters">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="img_item_wrapper m-0 p-0">
<div class="banner_content_wrapper by_gender">
<div class="content_label mb-10 font-2xl">Mens</div>
<div class="content_description">Lorem Ipsum è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo, quando un anonimo tipografo prese una cassetta di caratteri e li assemblò per preparare un testo campione.</div>
<div><a class="button_shop bg_white" href="#">SHOP NOW</a></div>
</div>
<img class="img_fullW" src="{{media url="catalog/category/mens.jpg"}}" alt="mens"></div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="img_item_wrapper m-0 p-0">
<div class="banner_content_wrapper by_gender">
<div class="content_label mb-10 font-2xl">Womens</div>
<div class="content_description">Lorem Ipsum è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo, quando un anonimo tipografo prese una cassetta di caratteri e li assemblò per preparare un testo campione.</div>
<div><a class="button_shop bg_white" href="#">SHOP NOW</a></div>
</div>
<img class="img_fullW" src="{{media url="catalog/category/womens.jpg"}}" alt="womens"></div>
</div>
</div>
</div>
EOD;
    $identifier = 'category_by_gender';
    $title = 'Category By Gender';
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
}