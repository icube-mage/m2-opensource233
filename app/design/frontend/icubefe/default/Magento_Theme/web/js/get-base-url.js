define(['jquery'], function($){
    'use strict';

    return function(config, element){
        alert('ada custom_class');
        element.innerText = config.base_url;
        
    }
});

