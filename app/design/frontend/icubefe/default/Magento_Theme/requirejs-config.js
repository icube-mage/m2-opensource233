var config ={
    paths:{// make alias
        'pathjs' : 'Magento_Theme/js/path', 'vault':'js/lib/jquery.vault'//vault
        
    },

    shim: { //set dependencies
       
        'vault':{ //vault
            deps:['jquery']
        }
    },

    deps:['js/jquery.vault'//vault
    
    ],//load on all page
    

    map: { //make alias
        '*' : {
            aliasbaseurl: 'Magento_Theme/js/get-base-url',
            
            
        }
    },
    
   
    
    
};