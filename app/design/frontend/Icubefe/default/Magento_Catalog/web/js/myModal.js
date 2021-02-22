define(["jquery", "Magento_Ui/js/modal/modal"], function (	$, modal) {
	"use strict";

	$.widget("icube.myModal", $.mage.modal, {
		options: {
			closeOtomatis: 1500,
		},
		openModal: function () {
			this._closeOtomatis();
			return this._super();
		},
		_closeOtomatis: function () {
			let self = this;

			setTimeout(function () {
				self.closeModal();
			}, self.options.closeOtomatis);
		},
	});

	return $.icube.myModal;
});