define(['jquery','modalWidget'],function($, myModal){
    'use strict'

    return function(data){
        console.log(data);

        $('.modalCustom').myModal({
            "type":"popup",
            "closeOtomatis":3000,
            "trigger":"#triggermodal",
              "title":this.data.product,
              "autoOpen": false,
              "buttons": [{
                  "text":"Yea Boi",
                  "class":"action primary"
                }]
          });


        $(".tocart").click(function(){
            let name = $(".page-title span").html();
            name = data.product;
            
            $(".modaCustom").myModal('openModal');

        });

    }
})