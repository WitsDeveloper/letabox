<?php
session_start(); 
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
require_once 'partials/config.php';


$header = array(
    'page'=>'account',
    'title'=>'Profile'
);
require_once 'partials/header.php';

?>
<style>
.contentz{
    background:white;
}.modal-dialog-order {
    position: relative;
    width: 54% !important;
    margin: 10% auto !important;
}
    </style>
</style>

<section class="maincontent">

    <div class="profile">
        <?php if($_GET['account']==='forgot'){?>
        <div class="container">
            <div class="col-md-12 kulwa">
                <br>
                    <h2> Enter your Email Address</h2>
                    <br>
          <form id=""  class="forgot_pass" > 
               <div class="form-group">
               
                
               </div>
                              <div class="col-md-12 col-xs-12">
                                    <strong>Email</strong>
                                    <input type="text" name="Email" class="form-control" value="" required />
                                </div>
          <input type="hidden" name="forgot_pass"> 
                             <div class="form-group">                               
                                  <button type="submit" name="forgot" class="">Submit</button> 
                                 <div id="forgot_response" class="col-md-12">
                                     
                                 </div>
                               
                            </div>
           </form>       
              </div>
            
        </div>
        <?php } else{ ?>
        <div class="container">

            <?php
                $controls = '<span>';
                $controls .= '<a href="">'.file_get_contents('images/icons/plus.svg').'</a>';
                $controls .= '<a href="">'.file_get_contents('images/icons/minus.svg').'</a>';
                $controls .= '</span>';
                //get user details
     $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);              
      $obj_ona1= $project_desc1->fetch_object();  
      $fname=$obj_ona1->Fname? $obj_ona1->Fname : 'N/A';
      $lname=$obj_ona1->Lname? $obj_ona1->Lname : 'N/A';
      $Email=$obj_ona1->Email? $obj_ona1->Email : 'N/A';
      $Phone=$obj_ona1->Phone? $obj_ona1->Phone : 'N/A';
      //$Phone=$obj_ona1->Phone? $obj_ona1->Phone : 'N/A';
      //$Phone=$obj_ona1->Phone? $obj_ona1->Phone : 'N/A';
            ?>

            <h2>My Account</h2>

            <div class="details">
                <img src="images/profile/1.jpg" alt="">
                <article>
                    <h3><?php print  $fname.' '.$lname;?></h3>
                    <p><a href=""><?php print $Email;?></a> <span>&bull;</span> <?php print $Phone;?></p>
                    <p><a href="my-profile.php">edit profile</a></p>
                </article>
                <span class="clearfix"></span>
            </div>

            <div class="tabs">
                <ul class="horizontal tablinks">
                    <li><a href="#orders">My Orders</a></li>
                    <li><a href="#wishlist">My Wishlist</a></li>
                     <li><a href="#history">My History</a></li>
                </ul>

                <div id="orders" class="tab cart myaccount_cart">
                   
                    <?php
                          //include 'partials/orders.php';  
                    ?>
                    <div class="loading-div"><img src="images/loader.gif" ></div>
                    <!--<a href="">back to orders</a>-->
                    <?php
                  if(@$_GET['view']==='ona_order'){                  
        
                $orderId= @$_GET['view'];
                 $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$orderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$OrderTotal=$obj_ona1->OrderTotal; 
$orderRemarks=$obj_ona1->orderRemarks;
$OrderDate=date("jS F, Y", strtotime("$obj_ona1->OrderDate"));
     }   
    ?>  
<h4>Order #<?php print $order_id;?> was placed on <?php print $OrderDate;?> </h4>
<h4>ORDER DETAILS</h4>

<table style="width: 100%;" border="1">    
    <tr><th>Product</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$orderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr><td>'.$obj_ptds->ProductName.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.$obj_ptds->ProductCost.'</td></tr>';    
     }
     ?>
     <tr><td>Shipping:</td> <td>Kes 0.00</td> </tr>    
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td>Kes <?php print $OrderTotal;?></td> </tr>  
</table>
                   <br>
                                        

                
      <?php          
            }  else{
                    
                    ?>
<div id="results2"><!-- content will be loaded here --></div>
               

<?php } ?>
 </div>
              

                <div id="wishlist" class="tab listing">
                    <?php //include_once 'partials/list.inc.php'; ?>
                       <?php
                          include 'partials/wish-list.php';  
                    ?>
                    <span class="clearfix"></span>
                </div>
                     <div id="history" class="tab cart myaccount_cart">
                    <?php //include_once 'partials/list.inc.php'; ?>
                       <?php
                          include 'partials/history.php';  
                    ?>
                    <span class="clearfix"></span>
                </div>
            </div>

        </div>
        <?php } ?>
    </div>

</section>
<?php require_once 'partials/footer.php'; ?>
<!-- for viewing orders-->
 <div class="modal fade" id="orderView" role="dialog">
    <div class="modal-dialog modal-dialog-order">
    
    
      <div class="modal-content">
          <div class="fetched-data2 row">
              
         
          </div>
  
      </div>
      
    </div>
        </div>
  

<!--end for viewing orders-->

<script>
$(document).ready(function(){
    $('#qView').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
     $.ajax({
            type : 'post',
            url : 'cart_process.php', 
            data :  'rowid='+ rowid, 
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
 
 //for slicing
     //$(".slide li").slice(1,3).css("background-color", "yellow");
     
    
    });
    
    //for pagination

$(document).ready(function() {
	$("#results" ).load( "partials/history_fetch.php"); //load initial records
	
	
	$("#results").on( "click", ".pagination a", function (e){
		e.preventDefault();
		$(".loading-div").show(); 
		var page = $(this).attr("data-page"); 
		$("#results").load("partials/history_fetch.php",{"page":page}, function(){ 
			$(".loading-div").hide(); 
		});
		
	});
        
        //for orders
        	$("#results2" ).load( "partials/orders.php"); 
	
	
	$("#results2").on( "click", ".pagination a", function (e){
		e.preventDefault();
		$(".loading-div").show(); 
		var page = $(this).attr("data-page"); 
		$("#results").load("partials/orders.php",{"page":page}, function(){
			$(".loading-div").hide(); 
		});
		
	});
        
        //view an order
       $('#orderView').on('show.bs.modal', function (e) {
        var orderid = $(e.relatedTarget).data('id');
     $.ajax({
            type : 'post',
            url : 'modals.php', 
            data :  'orderid='+ orderid, 
            success : function(data){
            $('.fetched-data2').html(data);
            }
        });
     });
     
     //view order 2
     
     
        
        
});

     </script>