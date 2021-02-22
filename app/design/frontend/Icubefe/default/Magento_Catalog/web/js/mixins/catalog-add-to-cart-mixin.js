define(["jquery", "myModal"], function ($, myModal) {
	"use strict";

	return function (catalogAddToCart) {
		$.widget("mage.catalogAddToCart", catalogAddToCart, {
			_create: function () {
				this._super();
				$(this.element).parent().append('<div id="popup"></div>');
				this.popup = $("#popup");
				this.initPopup();
			},
			initPopup: function () {
				this.popup.myModal({
					closeOtomatis: 3000,
				});
			},
			submitForm: function (form) {
				this._super(form);

				var productName = $(this.element)
					.parents(".product-item-details")
					.find(".product-item-link").length
					? $(this.element)
							.parents(".product-item-details")
							.find(".product-item-link")
							.text()
					: $(".catalog-product-view .page-title-wrapper").text();
				var popupText = "<b>" + productName + "</b> sudah ditambah !!!!!!!!!";
				var qty = $("#qty").length ? $("#qty").val() : null;

				if (qty)
					popupText =
						qty + "pcs <b>" + productName + "</b> sudah ditambah !!!!!!!!!";

				this.popup.html(popupText);
				this.popup.myModal("openModal");
			},
		});
		return $.mage.catalogAddToCart;
	};
});
