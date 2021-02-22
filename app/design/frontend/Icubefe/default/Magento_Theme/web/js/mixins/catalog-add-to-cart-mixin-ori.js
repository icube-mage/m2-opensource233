define(['jquery'], function($){
    'use strict';

    return function(catalogAddToCart){
        $.widget('mage.catalogAddToCart'), catalogAddToCart, {
            submitForm: function (form) {
                console.log('Add to Cart Berhasil testttttttttttttttttt!!!!!!');

                return this.super(form);
            }
        }
    }
})