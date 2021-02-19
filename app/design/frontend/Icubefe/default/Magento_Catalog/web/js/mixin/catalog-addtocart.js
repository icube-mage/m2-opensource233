define(['jquery','myModal'], function ($, myModal) {
    'use strict';
  
    return function(catalogAddToCart) {
      $.widget('mage.catalogAddToCart', catalogAddToCart, {
        _create: function () {
          this._super();
          $(this.element).parent().append('<div id="popup"></div>');
          this.popup = $('#popup');
          this.initPopup();
        },
        initPopup: function () {
          this.popup.myModal({
            "closeOtomatis": 5000
          });
        },
        submitForm: function (form) {
          this._super(form);
  
          var productName = ($(this.element).parents('.product-item-details').find('.product-item-link').length)?$(this.element).parents('.product-item-details').find('.product-item-link').text():$('.catalog-product-view .page-title-wrapper').text();
          var popupText = '<b>'+ productName +'</b> successfully added to cart';
          var qty = $('#qty').length?$('#qty').val():null;
  
          if(qty)
            popupText = qty + ' <b>'+ productName +'</b> successfully added to cart';
  
          this.popup.html(popupText)
          this.popup.myModal('openModal');
        }
      })
      return $.mage.catalogAddToCart;
    }
  })
  