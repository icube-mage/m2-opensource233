define (['jquery','mage/translate'],function($){
    'use strict';

    return function(config,element,$t) {
        element.innerText = config.base_url + $.mage.__('Icube assessment');
    }
});
