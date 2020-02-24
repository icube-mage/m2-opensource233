<?php

namespace Icube\AutoCategory\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaleCategory implements ObserverInterface {
    protected $helperData;

    public function __construct(
        \Icube\AutoCategory\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $product   = $observer->getProduct();
        $categories = $this->helperData->getSaleCategories($product);
        if ($categories) {
            $product->setCategoryIds($categories);
        }
    }
}
