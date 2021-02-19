var config = {
    map: {
        '*': {
            'qty-button': 'Magento_Catalog/js/qty-button',
            'myModal': 'Magento_Catalog/js/popup-product',
            'mixinToCart': 'Magento_Catalog/js/mixin/catalog-addtocart',
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                mixinToCart: true
            }
        }
    }
}