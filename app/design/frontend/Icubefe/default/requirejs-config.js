var config = {
    map: {
        "*" : {
            buttonQty: "Magento_Theme/js/uicomponent/buttonQty",
            myModal: "Magento_Theme/js/cartModal",
            modalWidget: "Magento_Theme/js/myModal"
        }
    },
    config:{
        mixins:{
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Magento_Theme/js/mixins/catalog-add-to-cart-mixin': true
            }
        }
    }

}