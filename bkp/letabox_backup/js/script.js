$(function(){

    //disable all links with href='#'
    /*$('a[href="#"]').click(function() {
        return false;
    });*/

    // tabs
    $('.tabs').tabslet();

    // modal
   /* $('.signupModal').featherlight('#signupModal', {
        beforeOpen: function(){ $.featherlight.close() }
    });
    $('.signinModal').featherlight('#signinModal', {
        beforeOpen: function(){ $.featherlight.close() }
    });*/
   /*$('.quickViewModal').featherlight('#quickViewModal', {
       
        beforeOpen: function(){
     
            $.featherlight.close() }
    });*/

    // wishlist
    $(".wishlist").on("click", function() {
        if($(this).hasClass('outline')) {
            $(this).removeClass("outline").addClass("filled");
        } else {
            $(this).removeClass("filled").addClass("outline");
        }
        return false;
    });

    // switch images
    $('.itemGall a').click(function(e) {
        var img = $(":first-child", this).attr('src');
        $('#mainGall').attr('src', img);
        return false;
    });
    //for checkout togle
    $("#akkount").hide();
    $("#checkbtn").click(function(){    
        $("#akkount").fadeToggle("fast");
        
      
    });

});
