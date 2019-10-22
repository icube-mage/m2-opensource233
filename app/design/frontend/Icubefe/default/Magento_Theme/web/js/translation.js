define([
    'mage/translate'
], function($t) {
    'use strict';
    
    return function(config, element){
        element.innerText = $t('Icube Assesment');
    }
});