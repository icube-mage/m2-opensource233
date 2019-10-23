define(
    [
        'jquery'
    ],function($) {
        'use strict';
        $(document).ready( function() {
            $(".product-category .block-title").insertAfter(".image-category .image-banner");
        });
        return function(config, element){
            element.innerText = "Allhamdulillah Jalan";
        }
    });