var config = {
	map: {
		"*": {
			catalogAddToCartMixin :"Magento_Catalog/js/mixins/catalog-add-to-cart-mixin",
			myModal: "Magento_Catalog/js/myModal"
		}
	},
	config: {
		mixins:{
			"Magento_Catalog/js/catalog-add-to-cart": {
				catalogAddToCartMixin: true
			}
		}
	}
}