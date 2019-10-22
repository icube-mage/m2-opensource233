define(function($) {
    'use strict';

    return function(config, element) {
        element.innerText = config.base_url;
    }
});