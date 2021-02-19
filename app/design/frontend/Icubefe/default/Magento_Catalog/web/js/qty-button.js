define([
    'ko',
    'uiElement'
], function (ko, Element) {
    'use strict';

    return Element.extend({
        defaults: {
            template: 'Magento_Catalog/input-qty'
        },

        initObservable: function () {
            this._super()
                .observe('qty');

            return this;
        },

        getDataValidator: function() {
            return JSON.stringify(this.dataValidate);
        },

        decreaseQty: function() {
            var qty;

            if (this.qty() > 1) {
                qty = this.qty() - 1;
            } else {
                qty = 1;
            }

            this.qty(qty);
        },

        increaseQty: function() {
            var qty = this.qty() + 1;

            this.qty(qty);
        }
    });
});