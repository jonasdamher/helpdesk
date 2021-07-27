'use strict';
$(()=>{

    $('.btnMenu').on('click',function(){

        const menu = $('#menu');
        let visible = menu.css('visibility');
 
        if(visible==='visible'){
            menu.removeClass('show');
        }else{
            menu.addClass('show');
        }
    });

});