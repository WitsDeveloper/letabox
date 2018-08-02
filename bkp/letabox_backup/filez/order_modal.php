 <!-- modal for view order-->
   <?php 
   
  // include 'includes/functions.php';
   
   ?><div class="quickview" id="">
         <button type="button" class="close" data-dismiss="modal">&times;</button>        
            
              <?php if($_POST['rowid']) {
                $orderId= $_POST['rowid'];
                 $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$orderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$OrderTotal=$obj_ona1->sellCostTotal; 
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
    print '<tr><td>'.$obj_ptds->ProductName.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($obj_ptds->ProductCost).'</td></tr>';    
     }
     ?>
     <tr><td>Shipping:</td> <td>Kes 0.00</td> </tr>    
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td>Kes <?php print wits_money($OrderTotal);?></td> </tr>  
</table>
                   <br>
                                        

                
      <?php          
                
                
              } ?>
            </div>
        
       
<div id="modal_addcart_response" class="col-md-12">
    
</div>   