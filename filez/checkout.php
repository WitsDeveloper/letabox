<?php

//sendy test
//Variables
//$sendy_api_url = "https://api.sendyit.com/v1/";
$sendy_api_url = "https://api.sendyit.com/v1/";
//$sendy_api_url = "https://apitest.sendyit.com/v1/";
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
?>
<section class="maincontent">
    <div class="cart cart2">
        <div class="container">
           

            <h2>Check out</h2>
            <div class="row">
       <div class="col-md-12">
        <br>
        <?php //print $_SESSION['user_id'];?>
        <?php if(!isset($_SESSION['user_id'])){ 
          
       ?>                                                
                                               
              
        <?php } ?>
            </div></div>
            <div class="row ">
        <div class="col-md-6">
           <br>
           <h3 class="my_center">Billing & Shipping</h3>
           <!--SHIPPING METHOD-->    
                       
                   <?php if(isset($_SESSION['user_id'])){
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      $obj_ona1= $project_desc1->fetch_object();      
       
 }     ?><?php if(!isset($_SESSION['user_id'])){?>
                      <p class="rex_center" >  Returning customer?  <a data-toggle="modal" href="#sIn"  class="signinModal btn btn-warning" >Click here to Sign in  </a></p>
 <?php } ?>     
           
              
                 
                     
                              
                      <form action="cart_process.php" method="post"/>
                   
                         <!--  <form method="post" action="" >-->
                      <div class="row">
                          <div class="col-md-12 checkout_formp">
                     <!--  <input type="hidden" name="kutoka" id="kutoka" value="<?php //echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" >   -->    
                              <p>
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" class="form-control" id="name" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required>
                  
                </p>
                <p>
                    <label for="email">Email Address</label>
                  <input type="text" name="Email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" required />
                 
                </p>    <p>
                    <label for="Phone">Phone</label>
                    <input type="text" name="Phone" id="Phone" class="form-control" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" required>
                    <input type="hidden" name="billing_country" id="billing_country" class="form-control" value="<?php print 'KE';?>" required>
                </p>
                     <p>
                    <label for="email">Street Address</label>
      <input type="text" id="billing_address_1" name="Address1" class="form-control" placeholder="Street address" autocomplete="address-line1" value="<?php echo $billing_address_1; ?>" data-geo="formatted_address"  required/>
                </p>  <?php if(!isset($_SESSION['user_id'])){ ?>
                <p>
                    <label for="password">Password</label>
                    <input id="inputPassword" type="Password" class="form-control" name="Password" placeholder="Your password"  />
           
                </p>
                <p>
                    <label for="confirm">Confirm Password</label>
                   <input type="Password" name="Confirm" class="form-control" placeholder="Confirm password"  required />
                  <!-- <input type="hidden" name="hidden_signup"/>-->
         
             
                   
              
                </p>
                <p><br>
                      
                </p>
                
                <?php } ?>
               
                    
                      </div>
                                 
                      </div>
        
                         <div class="col-md-6">
        <h3>Map View</h3>
        <div class="map_canvas" id="map_canvas" style="width: 555px;height: 400px;margin: 20px 0 10px 0;"></div>
        <div class="clear"></div>
        <pre id="logger">Log:</pre>
      </div>
                      <div class="row">
                          <div id="signup_response" style="width: 100%;">  
     
                </div>
                      </div>
                           <?php  ?>
                                    <br>

           <!-- <form id="shek_out" action="cart_process.php" method="post">-->
     <div class=" cart-body ">
   
              
                
                    
        
      
                            
                             
                             
                        
                    </div>
              
         
                          
                        
               
          
     </div>
          
             
   
       <div class="col-md-6 sheka_outt">
              <br>
              <h3  class="my_center">Your Order</h3>
                                    <br>
              
                     
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
                        $icon='<img src="'.$thumbnail.'" class="icon_img"/>';                                         
                         $currency='Kes';  ?>
                    <tr class="cart-item cart-item2"> <td class="rexxx"><?php print $icon; ?></td><td class="sheka_outt"><?php print $product_title; ?></td><td><?php print wits_money($sellCost); ?> X <b><?php print $product_qty;?></b></td></tr>
			<?php
                         $subtotal = ($sellCost * $product_qty);
			$total = ($total + $subtotal);
   	}
        ?>	
              
            </table>
            <table id="checkout_cargt2" class="" border="1" style="text-align: right;">
                     <tr><td>Sub total:</td><td><?php print wits_money($total); ?></td></tr>
                    <!-- <tr>   <td> TOTAL</td><td><?php //print $currency.sprintf("%01.2f",$total);
                      //print wits_money($total);
                    
                    ?></td> </tr>-->
                 </table>
        
   
		   
          
        <?php } ?>
                                                
                    <div class="row">
                        <br>
                        <div class="col-md-12">
                            
                        <h3 class="my_center">Delivery</h3>
                        <table>
                            <tr>
                                <td style="text-align: left !important;">Delivery Method</td>
                                <td><br>Pick up: <input class="rButton"  type="radio" name="method" value="pickup" required checked="checked">
                                        <br>
                           Sendy: <input class="rButton" id="watch-me" type="radio" name="method" value="sendy" required>          
                                    </td>
                                
                            </tr> 
                               <tr>
                                <td style="text-align: left !important;">Total</td>
                                <td id="sendu_processor">
                                                             <p>
              <input type="hidden" id="sendy_cost" name="sendy_cost" value="" class="input-text form-control"/>
            <input type="hidden" id="chechout_before_total" name="chechout_before_total" value="<?php print $total;?>" class="input-text form-control"/>
            <input type="hidden" id="chechout_net_total" name="" value="chechout_net_total" class="input-text form-control"/>
          </p>
          <h3 id="mbesa_amount">
                                    <?php print wits_money($total);?>    
                                    </h3> 
           
                                    </td>
                                
                            </tr>
                            
                        </table>
      
                                
                                <div id='show-me' style='display:none' class="col-md-12">here for sendy</div>
             </div>      
                        <div class="col-md-12 payment">
                            <h3 class="my_center">Payment Method</h3>
                       
                                <div class="form-group">
                                    <h4><input type="radio" name="method_pay" value="Mpesa" required> Mpesa</h4>
                                <h4><input type="radio" name="method_pay" value="Card" required> Credit Card</h4>
                                    
                                </div>
                        
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
            
                        <div id="resot"><!-- <button type="submit" name="post_checkout" class="btn btn-warning btn-lg">Place Order</button>-->
                        <input type="submit" name="post_checkout" class="btn btn-warning" value="Place Order"/>    
                        </div>
               </form>
             
   
   
  </div>
            

        </div>
            
            </div>
            

        </div>
    </div> </div>
  
<br><br><br><br>
</section>
<?php require_once 'partials/footer.php'; ?>
<script>
$(document).ready(function(){
/*var table=document.getElementById("checkout_cart2").innerHTML; 
    $("#my_kart").val(table);  
    
    var total_s=document.getElementById("checkout_cargt2").innerHTML; 
    $("#my_total").val(total_s);  
});*/
   $('#shek_out').change(function() {
    if ($('#watch-me').attr('checked')) {
        $('#show-me').show();
    } else {
        $('#show-me').hide();
    }
});
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="partials/jquery.geocomplete.js"></script>
<script src="partials/logger.js"></script>
<script>
jQuery(document).ready(function ($) {
	
	var billing_country = $("#billing_country").val();
	var country = (typeof billing_country === 'undefined') ? toLowerCase(billing_country) : 'ke';
	$.log(country);
	
	var center = new google.maps.LatLng(-1.2920659,36.82194619999996);
	
	$("#billing_address_1").geocomplete({
	  country: country,
	  map: ".map_canvas",
	  details: "form",
	  detailsAttribute: "data-geo",
	  types: ["geocode", "establishment"],
	  mapOptions: {
		zoom: 14,
		center: center,
		scrollwheel: false,
		mapTypeId: "roadmap"
	  },
	}).bind("geocode:error", function(event, error){
		$.log(error);
	});

	$("#billing_address_1").on('change', function(e){
		//$(this).trigger("geocode");
	});
        
});
</script>

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

       
function show_submit_data()
    {        
    var billing_address_1= $("#billing_address_1").val(); 
    var chechout_before_total= $("#chechout_before_total").val(); 
    var chechout_net_total= $("#chechout_net_total").val(); 
    var checked_method=$('input[name=method]:checked').val();
    //alert(checked_method)
  $(".loading-div").show(); 
 
   $.ajax({
				url: "cart_process.php",
				type: "POST",
				dataType:"json", 				
                                data :  "billing_address_1="+billing_address_1+"&chechout_before_total="+chechout_before_total+"&chechout_net_total="+chechout_net_total,
			}).done(function(data){ 
                              console.log(data);  
			var sendy_cost=data.sendyAmount;
                        var chechout_net_total=data.chechout_net_total;
                        //alert(sendy_cost+" ");
                              $("#sendy_cost").val(sendy_cost);
                              if(checked_method==='sendy'){
                              $("#chechout_net_total").val(chechout_net_total);
                              $("#mbesa_amount").html(data.chechout_net_total);
                             
                          }
                             if(checked_method==='pickup'){
                                $("#chechout_net_total").val(chechout_before_total);  
                             }
                              $(".loading-div").hide(); 
                              
                                //alert(origAmount);
        

			})
                        .fail(function(data) {
		
				console.log(data);
			
});
}	

 



    </script>
    
    <script>
       /* $( ".rButton" ).change(function() {
 
     if (this.value == 'sendy') {
      alert("Sendy");   
     }
          if (this.value == 'pickup') {
      alert("pickup");   
     }
          
       
    });
               */ 
                </script>
</html>



