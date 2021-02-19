define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function($, modal) {
    'use strict';
    
    $.widget('icube.myModal', $.mage.modal, {
        options: {
            closeOtomatis: 1000,
            buttons: []
        },
        openModal: function() {
            this._closeOtomatis();
            return this._super();
        },
        _closeOtomatis: function() {
            var self= this;
            setTimeout( function() {
                self.closeModal();
            }, self.options.closeOtomatis);
        }
    })

    return $.icube.myModal;
});