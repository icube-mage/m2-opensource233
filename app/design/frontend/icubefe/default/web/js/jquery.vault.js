define([
    'jquery',
    'jquery/ui',
    'matchMedia',

], function($,ui,mediaCheck){
    'use strict';
    $.widget('icube.vault',{
        _create: function(){
            this.initAllPages();
            this.initHomePage();
            this.initCategoryPage();
            this.initProductPage();
            this.initAccountPage();
        },
        initAllPages: function(){
            
        },
        initHomePage: function(){
            if($('body.cms-index-index').length){
                console.log('home page');
             
            }
        },
        initCategoryPage: function(){
            if($('body.catalog-category-view').length){
            }
        },
        initProductPage: function(){
            if($('body.catalog-product-view').length){
            }
        },
        initAccountPage: function(){
            if($('body.customer-account-index').length){
                console.log('account pageee');
            }
        },        
        
    });
    $(document).vault();
}
)
