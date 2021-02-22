var config = {
	map: {
		"*": {
			catalogAddToCartMixin :"Magento_Catalog/js/mixins/catalog-add-to-cart-mixin"
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