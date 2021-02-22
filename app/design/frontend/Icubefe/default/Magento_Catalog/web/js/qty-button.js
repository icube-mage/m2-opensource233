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
            this._super();
            this.qty= ko.observable(this.defaultQty);
            this.min= ko.observable(this.minQty);
            this.max= ko.observable(this.maxQty);

            return this;
        },

        getDataValidator: function() {
            return JSON.stringify(this.dataValidate);
        },

        decreaseQty: function() {
            var minValue = this.min();
            var minusQty = this.qty() - 1;

            if (minusQty < 1) {
                minusQty = minValue;
            }

            this.qty(minusQty);
        },

        increaseQty: function() {
            var maxValue = this.max();
            var plusQty = this.qty() + 1;

            if(plusQty > maxValue) {
                plusQty = maxValue;
            } 

            this.qty(plusQty);
        }
    });
});