<?php

namespace Icube\AutoCategory\Helper;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CATEGORY_NEW_NAME = 'New Arrivals';
    const CATEGORY_SALE_NAME = 'SALE';

    const ATTRIBUTE_NEW_CODE = 'exclude_from_new';
    const ATTRIBUTE_SALE_CODE = 'on_sale';

    /**
     * Get module status
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (
            $this->isModuleOutputEnabled('Icube_AutoCategory') && 
            (bool)(int)$this->scopeConfig->getValue(
                'autocategory/general/enable',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
        );
    }

    /**
     * Get day range for new arrivavl products
     *
     * @return int
     */
    public function getDayAsNew()
    {
        return (int)$this->scopeConfig->getValue(
            'autocategory/general/new_range',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get cron setting status
     *
     * @return bool
     */
    public function isCronEnabled()
    {
        return (bool)(int)$this->scopeConfig->getValue(
            'autocategory/general/cron',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get new arrivals category ID
     *
     * @return int
     */
    public function getNewCategoryId()
    {
        return (int)$this->scopeConfig->getValue(
            'autocategory/categories/new_category',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get SALE category ID
     *
     * @return int
     */
    public function getSaleCategoryId()
    {
        return (int)$this->scopeConfig->getValue(
            'autocategory/categories/sale_category',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
