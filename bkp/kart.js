
$('#edded_nav_cart').hide();
jQuery(document).ready(function ($) {

    $('input').keypress(function (e) {
        if (this.value.length === 0 && e.which == 48) {
            return false;
        }
    });
//add to kart
    $(".form-item").submit(function (e) {
        var form_data = $(this).serialize();
       $(".loading").show();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data
        }).done(function (data) {
            
                console.log(data); 
            $("#cart-info").html(data.items);
            $("#zeus_total").html(data.items);            

            //end here
          var itemz = data.items;
            var pdt_code = data.product_code; 
            if (itemz >0) {
                $("#wits_barx").addClass("my_barx");
            }
                     
            $("#top-cart-collapse2").load(" #top-cart-collapse2>*","");            
            $("#header_cart").load(" #header_cart>*","");        

            $(".cart-box").trigger("click");
            $(".my_list").trigger("click");           
              window.location.reload();            
            $("#shopping-cart-results2").load("cart_process.php", {"load_cart": "2"});
           $(".loading").hide();
          
          
        
        })
                                .fail(function(data) {
		
				console.log(data);
			
});
        e.preventDefault();
    });
    //save cart to db 

    $(".save_cart_fossssssrm").submit(function (e) {
        var form_data = $(this).serialize();
        var button_content = $(this).find('button[type=submit]');
        button_content.html('<span="color:red !important;">Adding...</span>');

        $.ajax({
            url: "cart_processs.php",
            type: "POST",
            dataType: "json",
            data: form_data
        }).done(function (data) {
            //$("#cart-info").html(data.items); //total items in cart-info element
            // $("#zeus_total").html(data.items);
            button_content.html('Save cart'); //reset button text to original text
            alert("Cart saved!"); //alert user
            window.location = "http://localhost/letabox"

        })
        e.preventDefault();
    });

    $(".shopping-cart-box").fadeIn();
    $("#shopping-cart-results").load("cart_process.php", {"load_cart": "1"});
    //remove items

    $("#shopping-cart-results").on('click', 'a.remove-item', function (e) {
        e.preventDefault();
        $(".loading").show();
        var pcode = $(this).attr("data-code");
        $(this).closest('tr').fadeOut();
        $.getJSON("cart_process.php", {"remove_code": pcode}, function (data) { //get Item count from Server
            $("#cart-info").html(data.items); //update Item count in cart-info
            // $("#wits_cart_tot").html(data.total);
            var itemz = data.items;

            if (itemz < 1) {
                $("#wits_barx").removeClass("my_barx");
            }
            $(".cart-box").trigger("click");
            //$('#top-cart-collapse2').load(document.URL +  ' #top-cart-collapse2');
            $("#top-cart-collapse2").load(" #top-cart-collapse2 > *");
             window.location.reload();
            $(".loading").hide();
        });
    });

    $(".remove-item2").click(function () {
        $(".loading").show();
        var pcode = $(this).attr("data-code");
        $(this).closest('li').fadeOut();
        $.getJSON("cart_process.php", {"remove_code": pcode}, function (data) {
            $("#cart-info").html(data.items);
            $(".cart-box").trigger("click");
            //$("#top-cart-collapse2").load("includes/navcart.php");
            var itemz = data.items;
            if (itemz < 1) {
                $("#wits_barx").removeClass("my_barx");
            }
            $("#top-cart-collapse2").load(" #top-cart-collapse2 > *");
             window.location.reload();
           $(".loading").hide();
        });
    });

    //update quantity for nav
    $(".quantity").change(function () {
       $(".loading").show();
        var element = this;
        setTimeout(function () {
            update_quantity.call(element)
        }, 2000);
    });
    function update_quantity() {
        var pcode = $(this).attr("data-code");
        var quantity = $(this).val();
        $(this).parent().parent().fadeOut();
        $.getJSON("cart_process.php", {"update_quantity": pcode, "quantityx": quantity}, function (data) {
            window.location.reload();
            //$("#wits_barx").animate({ "margin-right": 0 },    "slow");
           // alert("afrer");
        });
                $(".loading").hide();
    }
//toggle account create div
    $("#autoUpdate").hide();
    $('#kreate_acc').change(function () {
        if (this.checked)
            //  ^
            $('#autoUpdate').fadeIn('slow');
        else
            $('#autoUpdate').fadeOut('fast');
    });
    //load checkout
    $(".checkout_r").fadeIn(); //display cart box
    $("#checkout-cart-results").html('<img src="images/ajax-loader.gif">');
    $("#checkout-cart-results").load("cart_process.php", {"load_checkout": "1"});

//submit checkout
//$(".save_cart_form").submit(function(e)
    $(".leta_modal_checkout").submit(function (e)
    {   e.preventDefault();
        $(".loading").show();
        var form_data = $(this).serialize();
        var button_content = $(this).find('button[type=submit]');
        button_content.html('Submitting...');
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        }).success(function (data)
        {
            console.log(data);
            if (data === "saved") {
                //$(".edded_to_wish").html('<div class="alert alert-success"> <strong>Order placed !!</strong></div>');
                $(".loading").hide();
                $('.order_placedd').fadeIn('fast');

                $(".edded_to_wish").fadeOut(8000, function () {
                    window.location = "index.php";
                });
            }
        })
                .fail(function (data) {             
                    console.log(data);
                });
        //e.preventDefault();
        // }
    });

//sign up	
    $(".leta_signup").submit(function (e) {
        e.preventDefault();
        $(".loading").show();
        var form_data = $(this).serialize();
        var url_from = $('#url_from').val();

        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })  .success(function (data)
                {
                    console.log(data);
                    if (!data.success) {
                        if (data.errors.confirm) {
                            $("#signup_response").html('<div class="alert alert-danger my_error"> Passwords Dont Match!!</div></div>');
                        }
                        if (data.errors.tukonamail) {
                            $("#signup_response").html('<div class="alert alert-danger my_error"> Email in use !</div>');
                        }
                         if (data.errors.tukonasimu) {
                            $("#signup_response").html('<div class="alert alert-danger my_error"> Phone Number In use !!</div>');
                        }
                    } else {
                        $("#signup_response").html('<div class="alert alert-success ">Sign Up Successful...Check Your mail to activate your account</div>');
                        $("#signup_response").fadeOut(4000, function () {
                            //$('#sUp').modal('hide');
                            window.location = url_from;
                        });                    }
                  $(".loading").hide();
                })
                .fail(function (data) {
                    console.log(data);
                });   });
    //SIGN IN

    //modal
    $(".leta_signin").submit(function (e) {
        e.preventDefault();
   $(".loading").show();
        var url_from = $('#url_from').val();
        var form_data = $(this).serialize();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })                .success(function (data)
                {
                    console.log(data);
                    if (data === 'wrong') {
                        $("#signup_response2").html('<div class="alert alert-danger my_error">Wrong Login details.</div>');
                    }
                    if (data === 'notactive') {
                        $("#signup_response2").html('<div class="alert alert-danger my_error">Your account is not activated. check activation link in your email.</div>');
                    }
                    if (data === 'success') {
                        $("#signup_response2").html('<div class="alert alert-success ">Login successful ......</div>');
                        $("#signup_response2").fadeOut(4500, function () {
                            /* if(kutoka==='signin.php'){
                             
                             window.location = 'index.php ';
                             }
                             else{
                             window.location = kutoka;
                             }*/
                            window.location = url_from;

                        });

                    }

        $(".loading").hide();

                })
                .fail(function (data) {

                    console.log(data);
                });


        //quickview modal


    });
    //on checkout
    $(".checkout_signin").submit(function (e) {

        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })
                .success(function (data)
                {
                    console.log(data);
                    if (data === 'wrong') {
                        $("#response_myaccount").html('<div class="alert alert-danger my_error">Wrong Login details</div>');
                    }      if (data === 'success') {
                        $("#response_myaccount").html('<div class="alert alert-success my_error"> <strong>Sign in access</strong></div>');

                        window.location = "checkout.php"
                    }
                })
                .fail(function (data) {
                    // show any errors
                    // best to remove for production
                    console.log(data);
                });
        //e.preventDefault();
        //quickview modal
    });

    //check out manage account
    $(".checkout_update").submit(function (e) {
        e.preventDefault();
        var form_data = $(this).serialize();

        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })
                .success(function (data)
                {
                    console.log(data);
                    if (data === 'passwrong') {
                        $("#manage_response").html('<div class="alert alert-danger"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Wrong password</strong></div>');
                    }
                    /* if(data==='passwrong') {
                     $("#manage_response").html('<div class="alert alert-danger"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Wrong password</strong></div>'); 
                     } */
                    else if (data === 'passconfirmnot') {
                        $("#manage_response").html('<div class="alert alert-danger"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Passwords not matching</strong></div>');
                    } else {
                        $("#manage_response").html('<div class="alert alert-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Success in update</strong></div>');

                    }

                })
                .fail(function (data) {
                    console.log(data);
                });


    });

    //check out addres details
    $(".billing_edit").submit(function (e) {
                $(".loading").show();
        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })
                .success(function (data)
                {
                    console.log(data);

                    if (!data.success) {
                        $("#billing_response").html('<div class="alert alert-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Profile saved !!</strong></div>');
                        $("#billing_response").fadeOut(4000, function () {
                            window.location = "my-profile.php";
                                    $(".loading").hide();
                        });

                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        e.preventDefault();

        //quickview modal


    });

    //forgot password
    $(".forgot_pass").submit(function (e) {
        e.preventDefault();
                $(".loading").show();
        var form_data = $(this).serialize();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })
                .success(function (data)
                {
                    console.log(data);

                    if (data === 'invalid_email') {
                        $("#forgot_response").html('<div class="alert alert-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <strong>Invalid Email</strong></div>');
                    }
                    if (data === 'no_record') {
                        $("#forgot_response").html('<div class="alert alert-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <strong>No record of your email</strong></div>');
                    }
                    if (data === 'success') {
                        $("#forgot_response").html('<div class="alert alert-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <strong>Passord Changed check your email</strong></div>');

                    }
        $(".loading").hide();
                })
                .fail(function (data) {
                    console.log(data);
                });
        e.preventDefault();

        //quickview modal


    });

    //scroller update

    $('.add').click(function () {
        //new
       // $(".loading").show();
        $(this).prev().val(+$(this).prev().val() + 1);
        var pcode = $(this).attr("data-code");
        //var quantity = $(this).val(); 
        var quantity = $(this).prev().val();
        /*alert('aa=>'+quantity);
         $(".quantity").val(quantity);
         var v = $(this).closest('tr,li,div').find('.quantity').val();*/
        if (pcode != 'nullz') {

            $.getJSON("cart_process.php", {"update_quantity": pcode, "quantityx": quantity}, function (data) {
                window.location.reload();
             
            });
        }
          // $(".loading").hide();
    });
    $('.sub').click(function () {
       // $(".loading").show();
        var pcode = $(this).attr("data-code");

        var v = $(this).closest('tr,li,div,.input-group').find('.quantity').val();

        if (v > 0) {
            var quantity = $(this).closest('tr,li,.input-group').find('.quantity').val() - 1;
        }
        if (pcode != 'nullz') {
            //var quantity=$(this).next().val();

            $.getJSON("cart_process.php", {"update_quantity": pcode, "quantityx": quantity}, function (data) {
                window.location.reload();
            });
        }
       // $(".loading").hide();

    });

//new sub for single.php decrement 
    $('.sub2').click(function () {
        //$(".loading").show();
        //var pcode = $(this).attr("data-code");

        var v = $(this).closest('.input-group').find('.quantity').val();
//alert("value"+v);
        if (v > 1) {
            var quantity = $(this).closest('.input-group').find('.quantity').val() - 1;
            // $(".input-group").val(quantity);
            $(this).closest('.input-group').find('.quantity').val(quantity);
        }
       // $(".loading").hide();
        //alert("value"+quantity);



    });

//custom orders
//forgot password
    $(".custom_quote").submit(function (e) {
        e.preventDefault();
        $(".loading").show();
        var form_data = $(this).serialize();
        $.ajax({
            url: "cart_process.php",
            type: "POST",
            dataType: "json",
            data: form_data,
            encode: true
        })  .done(function (data)
                {
                    console.log(data);

                    if (data === 'success') {
                        $("#custom_order_response").html('<div class="alert alert-success"> <strong>Custom order placed</strong></div>');
                        $("#custom_order_response").fadeOut(4000, function () {
                            window.location = "index.php";
                        });
                    } else {
                        $("#custom_order_response").html('<div class="alert alert-danger"> <strong>Error occured</strong></div>');

                    }
$(".loading").hide();
                })
                .fail(function (data) {
                    console.log(data);
                });
        e.preventDefault();

    });
    //add to wish list
    $(".wish-form").submit(function (e) {
        var form_data = $(this).serialize();
        var user = $(".user_id_wish").val();
        if (user === '') {
            alert("Sign in to add wishlist !!!!");
            return false;
        } else {
            $.ajax({
                url: "cart_process.php",
                type: "POST",
                dataType: "json",
                data: form_data
            }).done(function (data) {

                if (data === 'success') {
                    $('.edded_to_wish').fadeIn('fast').delay(1000).fadeOut('slow');
                } else if (data === 'wish_iko') {
                    $('.edded_wish_exists').fadeIn('fast').delay(1000).fadeOut('slow');
                } else {

                    $('.edded_to_login').fadeIn('fast').delay(1000).fadeOut('slow');
                }

            })
            e.preventDefault();
        }
    });

    //validate search
    $('#btnSubmit').click(function (e) {
        var isValid = true;
        var category=$("#category" ).val();
        //alert(category);
                    ///e.preventDefault();
       $('input[type="search"]').each(function () {
            if ($.trim($(this).val()) == ''||category==='Select') {
                isValid = false;
          
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE"
                });
              
            }

        });
        if (isValid == false) {
            e.preventDefault();
        }

    });

    //itina
    $("#backLink").click(function (event) {
        event.preventDefault();
        history.back(1);
    });
    $("#toshop").click(function (event) {
        event.preventDefault();
        history.back(1);
    });
//swap sign=>in/up pop-up

    $('.signinModal').click(function (event) {
        event.preventDefault();
        $('#sUp').modal('hide');
        // $('#sIn').modal('show');
    });
    $('.signupModal').click(function (event) {
        event.preventDefault();
        $('#sIn').modal('hide');
        // $('#sUp').modal('show');
    });   

    $(".form_mobile").hide();
    $("#ona_seacrh_mob").click(function () {
        $(".form_mobile").toggle();
    });

    //mob toggle

    var expanded = false;
    $(".drawer-handle").click(function () {
      if (expanded = !expanded) {
            $("#wits_barx").animate({"margin-right": 234}, "fast");
        } else {
            $("#wits_barx").animate({"margin-right": -263}, "fast");
        }
       // alert("Clicked");
    });

    //left
    //right
    var expanded2 = false;
    $(".drawer-handle2").click(function () {
        if (expanded2 = !expanded2)

        {
            $("#wits_barx2").animate({"margin-left": 0}, "fast");
        } else {
            $("#wits_barx2").animate({"margin-left": -263}, "fast");
        }
    });

    //social share
    $(".social_share").click(function () {
        $("#share-buttons").fadeToggle("slow", "linear");

    });
    
    //for single page
    

});





