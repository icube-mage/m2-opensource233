<?php

namespace Icube\AutoCategory\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Icube\AutoCategory\Model\AssigneeManagement;
use Icube\AutoCategory\Helper\Config;

class BeforeProductSave implements ObserverInterface
{
    /**
     * @var AssigneeManagement
     */
    private $assigneeManagement;

    /**
     * @param AssigneeManagement $assigneeManagement
     */
    public function __construct(
        AssigneeManagement $assigneeManagement
    ) {
        $this->assigneeManagement = $assigneeManagement;
    }

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getProduct();
        if ($product->hasDataChanges()) {
            if ((int)$product->getData(Config::ATTRIBUTE_NEW_CODE) !== (int)$product->getOrigData(Config::ATTRIBUTE_NEW_CODE)) {
                $isExclude = (bool)(int) $product->getData(Config::ATTRIBUTE_NEW_CODE);
                if ($isExclude) {
                    $this->assigneeManagement->unassignNewProduct($product);
                } else {
                    $this->assigneeManagement->markAsNewProduct($product);
                }
            }

            if ((int)$product->getData(Config::ATTRIBUTE_SALE_CODE) !== (int)$product->getOrigData(Config::ATTRIBUTE_SALE_CODE)) {
                $isSale = (bool)(int) $product->getData(Config::ATTRIBUTE_SALE_CODE);
                if ($isSale) {
                    $this->assigneeManagement->markAsSaleProduct($product);
                } else {
                    $this->assigneeManagement->unassignSaleProduct($product);
                }
            }
        }
    }
}
