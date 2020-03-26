define(['jquery', 'jquery/ui', 'matchMedia'], function($){
    'use strict';

    mediaCheck({
        media: '(min-width: 768px)',
        // Switch to Desktop Version
        entry: function () {
          
            /* The function that toggles page elements from desktop to mobile mode is called here */
        },
        
        // Switch to Mobile Version
        exit: function () {
           
            /* The function that toggles page elements from mobile to desktop mode is called here*/
        }
    }); /*...*/
    return function(config, element){
        alert('ada product');
        console.log('ada product');
        $.getJSON(config.base_url + 'rest/V1/directory/currency', function(result){
           element.innerText = result.base_currency_code;
        });
    }
});