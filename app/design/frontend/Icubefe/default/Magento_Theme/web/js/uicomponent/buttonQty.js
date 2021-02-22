define(['jquery','uiElement'], function($, UiElement){
    'use strict';

    return UiElement.extend({
        defaults: {
            template: 'Magento_Theme/buttonQty'
        },
        initialize: function () {
            this._super();
            $('#qty').val(this.min);
            $("#qty").attr({
                "max" : this.max,
                "min" : this.min
             });
        },
        increment: function(){
            let qty = parseInt($('#qty').val())+1;
            if(qty<this.max){
                $('#qty').val(qty);
                console.log("qty increased", qty);
            }
            $("#buttonQtyMinus").removeAttr("disabled");

        },
        decrement: function(){
            let qty = parseInt($('#qty').val())-1;
            if(qty>=this.min){
                $('#qty').val(qty);
                console.log("qty decreased", qty);
            }
            if(qty===this.min){
                $("#buttonQtyMinus").attr("disabled", true);
            }

        }
    })
})