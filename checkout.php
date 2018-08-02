<?php

$sendy_api_url = "https://api.sendyit.com/v1/";
$google_maps_api_key = "AIzaSyBAgQ-vCy1106_l1iZFudZeYQGx2ghCS3g";
$billing_state = "Harry Thuku Rd, Nairobi, Kenya";
//end sendy test
require_once 'apiconn.php';
require_once 'partials/config.php';

$header = array(
    'page'=>'checkout',
    'title'=>'Checkout page'
);
require_once 'partials/header.php';

?><link rel="stylesheet" type="text/css" href="partials/intlTelInput.css">



<section class="maincontent">
    <div class="cart cart2">
        <div class="container">
           

            <h2>Check out</h2>
      
            <div class="row ">
         
        <div class="col-md-6">
           <br>
           <h3 class="my_center">Billing & Shipping</h3>
          
                       
                   <?php if(isset($_SESSION['user_id'])){
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      $obj_ona1= $project_desc1->fetch_object();      
       
 }     ?><?php if(!isset($_SESSION['user_id'])){?>
           <p class="rex_center" >  Returning customer?  <a onclick="location.href = 'signin.php'"   class="signinModal btn btn-warning" >Click here to Sign in  </a></p>
 <?php } ?>     
                     <!-- <form action="cart_process.php" method="post">-->
           
                      <form class="leta_modal_checkout">
               
                      <div class="row">
                          <div class="col-md-12 checkout_formp">                    
                              <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" class="form-control" id="name" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required>
                  
                </div>
                  
                         
                            
     
                   <div class="form-group">
                    <label for="email">Email Address</label>
 <input type="text" name="Email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" data-validation="email required" data-validation-error-msg="You did not enter a valid e-mail" />
                 
                   </div>         <div class="form-group">
                    <label for="Phone">Phone</label>
                    <input type="text" name="Phone" id="Phone" class="form-control" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" required>
                    <input type="hidden" name="billing_country" id="billing_country" class="form-control" value="<?php print 'ke';?>" required>
                   </div>
                      <div class="form-group">
                    <label for="email">Street Address</label>
      <input type="text" id="billing_address_1" name="Address1" class="form-control" placeholder="Street address" autocomplete="address-line1" value="<?php echo $billing_address_1; ?>" data-geo="formatted_address"  required/>
                      </div> <?php if(!isset($_SESSION['user_id'])){ ?>
                     <div class="form-group">
                    <label for="password">Password</label>
                    <input id="inputPassword" type="Password" class="form-control" name="Password" placeholder="Your password" data-validation="length" data-validation-length="min8"  />
           
                     </div>                
               
                
                <?php } ?>
                    <div class="form-group payment">
                            <h3 class="my_center">Payment Method</h3>
                            <h3 class="my_center">Pay securely using our M-PESA .</h3>
                            <br>
                            <small>Enter Phone Number to pay</small>                           
                 
                              <input type="tel" id="phonenumber" name="MPESA_NUMBER" value="" maxlength="13" class="input-text form-control" required/>
                            
                            <span id="validate-msg" class="text-danger"></span>
                              
                        
                        </div>
               
                    
                      </div>
                                 
                      </div>    
                 
     </div>
          
             
   
       <div class="col-md-6 sheka_outt">
              <br>
              <h3  class="my_center">Your Order</h3>
              
                       <?php
                        // print_r($_SESSION["productsx"]);
                //$arr = print_r($_SESSION["productsx"],true);
                 //print_r($arr);
          ;
              /*  $arr=$_SESSION["productsx"];       
                foreach($arr as $x => $x_value) {  
                    if(array_key_exists('variations', $x_value)){
                     foreach($x_value as $my_key=>$value){
                       
                echo $my_key.'=>ssssss'.$value.'<br>';
                
                 
                         
                       

                     }
                    }
                     
 
}*/
                
                // $arr $arr=$_SESSION["productsx"];
         /*if($_SESSION["productsx"][$product_code]["variations"]){    
    $var_s = explode(",", $arr[$product_code]["variations"]);
foreach ($var_s as $key=>$values)
{  $var_value = $product[$values];
  $var_name = $product[$key];
 print '<b>'.$var_value.'</b> '.$var_value.'<br>';
}
    
    
}*/
                 ?>             
              
                     
<?php

	if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ ?>
           
            
                <table id="checkout_cart2" class="cart-products-loaded table table-bordered" border="1">
                    <tr><th>Image</th> <th><span style="margin-left: 3%">Product</span></th><th>Total</th></tr>
               
<?php
		$total = 0;
		foreach($_SESSION["productsx"] as $product){ 


                    
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                        $sellCost= $product["sellCost"]; 
                        $product_price = $product["price"]; 
                        $product_qty = $product["quantity"]; 
                        $thumbnail = $product["thumbnail"];
                        $varz= $product["variations"];
                        $icon='<img src="'.$thumbnail.'" class="icon_img"/>';                                         
                         $currency='Kes';  ?>
                    <tr class="cart-item cart-item2"> <td class="rexxx"><?php print $icon; ?></td><td class="sheka_outt"><?php print $product_title.'<br>';
                    ?></td><td><?php print wits_money($sellCost); ?> X <b><?php print $product_qty;?></b><hr>
              <?php
             /* foreach($_SESSION["productsx"] as $x => $x_value) { 
                    foreach($x_value as $my_key=>$value){                   
                   echo print_r($var_s = explode(",", $arr[$product_code]["variations"]));
                     }
                
              }*/
 if($_SESSION["productsx"][$product_code]["variations"]){    
  $var_s = explode(",", $_SESSION["productsx"][$product_code]["variations"]);
foreach ($var_s as $key=>$values)
{  $var_value = $product[$values];
  $var_name = $product[$key];
 print '<br><b>'.$values.'</b> '.$var_value.'<br>';
}
   	}
              
              ?>
                        </td></tr>
			<?php
                         $subtotal = ($sellCost * $product_qty);
			$total = ($total + $subtotal);
                        
                        // echo '<pre>';           
              //print print_r($arr=$_SESSION["productsx"][$product_code]["variations"]).'fhfhfhfhfh';
               // echo '</pre>';
  
        
                }
        ?>	
             
            </table>
              <table>
                   <?php ?>
              </table>
            <table id="checkout_cargt2" class="" border="1" style="text-align: right;">
                     <tr><td>Sub total:</td><td><?php print wits_money($total); ?></td></tr>
           
                 </table>
               
             
      


        
   
		   
          
        <?php } ?>
                                                
                    <div class="row">
                        <br>
                        <div class="col-md-12">
                            
                        <h3 class="my_center">Delivery</h3>
                        <table>
                            <tr>
                                <td style="text-align: left !important;">Delivery Method</td>
                                <td style="text-align: left !important;">Total</td>
                                
                            </tr> 
                               <tr>
                               
                                   <td style="text-align: left !important;"><br>Pick up: <input class="rButton"  type="radio" name="method" value="pickup" required >
                                        <br>
                           Sendy: <input class="rButton" id="watch-me" type="radio" name="method" value="sendy" required checked="checked">          
                                    </td>
                                <td id="sendu_processor">
                                                             <p>
              <input type="hidden" id="sendy_cost" name="sendy_cost" value="" class="input-text form-control"/>
            <input type="hidden" id="chechout_before_total" name="chechout_before_total" value="<?php print $total;?>" class="input-text form-control"/>
            <input type="hidden" id="chechout_net_total" name="chechout_net_total" value="" class="input-text form-control"/>
            <!--for ajax sub-->
             <input type="hidden"  name="checkout_submit" value="" /> 
            <!--end for ajax sub-->
          </p>
          <h4 class="">Sendy Cost(Ksh): <span class="sendy_cost_html"></span></h4>
          <h3 id="mbesa_amount">
                                    <?php print wits_money($total);?>    
                                    </h3> 
           
                                    </td>
                                
                            </tr>
                            
                        </table>
      
                                
                                <div id='show-me' style='display:none' class="col-md-12">here for sendy</div>
             </div>      
                    
                    
                    </div>
                             
<div class="form-group">
     <?php if(isset($_SESSION['user_id'])){
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      $obj_ona1= $project_desc1->fetch_object();      
       
     ?>
    <input type="hidden" name="Email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>"  />
    <input type="hidden" name="Fname" class="form-control" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>"  />
    <input type="hidden" name="Phone" class="form-control" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>"  />
    
    <?php } ?>
    <input id="my_kart" name="my_kart" type="hidden" value=""/>
     <input id="my_total" name="my_total" type="hidden" value=""/>
    <div class="checkbox">
      <label>
        <input type="checkbox" id="terms" data-error="Accept terms" required>
        I’ve read and accept the <a href="#" target="_blank" class="woocommerce-terms-and-conditions-link">terms &amp; conditions</a>
      </label>
      <div class="help-block with-errors"></div>
    </div>
  </div>
            
                        <div id="resot">
                        <input type="submit" id="umya" name="post_checkout" class="btn btn-warning" value="Place Order"/>    
                        <br><br>
                        </div>
                                    <div id="checkout_resp" class="row"></div>
               </form>
             
   
   
  </div>
            

        </div>
            
            </div>
            

        </div>
    </div> </div>
  
<br><br><br><br>
</section>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places"></script>
<?php require_once 'partials/footer.php'; ?>
<script src="partials/jquery.geocomplete.js"></script>
<script src="partials/logger.js"></script>


<script>
   $(document).ready(function () {
       
       
    $location_input = $("#billing_address_1");
 var options = {
        types: ["geocode", "establishment"],
        componentRestrictions: {
            country: 'ke'
        }
    };
    autocomplete = new google.maps.places.Autocomplete($location_input.get(0), options);    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
       //var data = $("#search_form").serialize();
     var data= $("#billing_address_1").val(); 
       //var origAmount= $("#chechout_before_total").val(); 
        console.log('blah')
        show_submit_data(data);
        return false;
        alert(address);
    });
   
});
//function show_submit_data(data)
 
   $(".sendy_cost_html").html(" 0");
       
function show_submit_data()
    {        
    var billing_address_1= $("#billing_address_1").val(); 
    var chechout_before_total= $("#chechout_before_total").val(); 
    var chechout_net_total= $("#chechout_net_total").val(); 
    var checked_method=$('input[name=method]:checked').val();
    //alert(checked_method)
 $(".loading").show();
 
   $.ajax({
				url: "cart_process.php",
				type: "POST",
				dataType:"json", 				
                                data :  "billing_address_1="+billing_address_1+"&chechout_before_total="+chechout_before_total+"&chechout_net_total="+chechout_net_total,
			}).done(function(data){ 
                              console.log(data);  
			var sendy_cost=data.sendyAmount;
                        var sendy_cost2='0';
                        var chechout_net_total=data.chechout_net_total; 
                        var chechout_net_total_x = 'Ksh ' + chechout_net_total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                              $("#sendy_cost").val(sendy_cost);
                              if(checked_method==='sendy'){
                              $("#chechout_net_total").val(chechout_net_total);
                             // $("#mbesa_amount").html(data.chechout_net_total);
                              $("#mbesa_amount").html(chechout_net_total_x);
                              $(".sendy_cost_html").html(data.sendyAmount);
                             
                          }
                             if(checked_method==='pickup'){
                                $("#chechout_net_total").val(chechout_before_total);  
                                //$(".sendy_cost_html").html(sendy_cost2);
                                $(".sendy_cost_html").html(" 0");
                             }
                             $(".loading").hide();                            
                            
        

			})
                        .fail(function(data) {
		
				console.log(data);
			
});
}	

 



    </script>
<script type="text/javascript" src="partials/intlTelInput.min.js"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function() {
	var telInput = $("#phonenumber");
	var validateMsg = $("#validate-msg");
	
	// initialise plugin
	telInput.intlTelInput({
		autoPlaceholder: false,
		formatOnDisplay: true,
		geoIpLookup: function(callback) {
			jQuery.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			var countryCode = (resp && resp.country) ? resp.country : "";
			callback(countryCode);
			});
		},
		initialCountry: "auto",
		nationalMode: false,
		preferredCountries: ['ke', 'ug', 'tz'],
		utilsScript: "js/utils.js"
	});
	
	var reset = function() {
		telInput.removeClass("error");
		validateMsg.addClass("hide");
	};
	
	// on blur: validate
	telInput.blur(function() {
		reset();
		if ($.trim(telInput.val())) {
			if (telInput.intlTelInput("isValidNumber")) {
				validateMsg.addClass("hide");		
			} else {				
				validateMsg.removeClass("hide");
				validateMsg.html( '<em id="phonenumber-error" class="error">Valid number is required.</em>' );
			}
		}
	});
	
	// on keyup / change flag: reset
	telInput.on("keyup change", reset);
        
        //added
       /* $("#umya").click(function(){
var bla = $('#phonenumber').val();
alert(bla); 
});*/
});




</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    validateOnBlur : false, // disable validation when input looses focus
    errorMessagePosition : 'top' // Instead of 'inline' which is default
    scrollToTopOnError : false // Set this property to true on longer forms
  });
</script>
<script>
  $.validate({
    modules : 'html5'
  });
</script>

</html>




