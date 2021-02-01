define([
    'ko',
    'uiComponent'
], function(ko, Element) {
    'use strict';

        return Element.extend({
            initialize: function() {
                this._super();
                this.qty = ko.observable(this.defaultQty);
            },
            decreaseQty: function() {
                var newQty = this.qty() - 1;
                // Jika quantity kurang dari 1 maka nilainya akan tetap 1
                if (newQty < 1) 
                {
                    newQty = 1;
                }
                this.qty(newQty);
            },
            increaseQty: function() {
                var newQty = this.qty() + 1;
                // Jika quantity lebih dari 10 maka nilainya akan tetap 10
                if (newQty > 10) 
                {
                    newQty = 10;
                }
                this.qty(newQty);
            }
        })
    
    
});