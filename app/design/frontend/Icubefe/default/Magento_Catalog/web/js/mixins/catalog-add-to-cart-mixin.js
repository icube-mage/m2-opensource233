define(["jquery"], function ($) {
	"use strict";

	return function (catalogAddToCart) {
		$.widget("mage.catalogAddToCart", catalogAddToCart, {
			submitForm: function (form) {
				this._super(form);

				alert("Added to cart!!");
			},
		});
		return $.mage.catalogAddToCart;
	};
});