$(document).ready(function(){
     $('.close_popup').click(function () {       
         $(this).parents('.modal.fade').hide();
         $('.modal-backdrop').hide();
         $('body').removeClass('modal-open');       

     });
    $(".btn_communication").attr("data-target","#myModal-1");
    $(".form_news").attr("data-target","#myModal-2");
});
