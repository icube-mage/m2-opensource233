define(['jquery', 'jquery/ui', 'matchMedia'], function($){
    'use strict';
    return function(config , element){
        element.innerText = config.base_url;
        console.log(config);
    }
});