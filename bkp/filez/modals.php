  <?php if(@$_REQUEST['orderid']) {
      include 'includes/functions.php';
   @session_start();
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
   $con_id = $_REQUEST['orderid'];
   ?><div class="col-md-12 contentz" >
         <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            <div>
           <?php
            $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$con_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$OrderTotal=$obj_ona1->sellCostTotal; 
$orderRemarks=$obj_ona1->orderRemarks;
$OrderDate=date("jS F, Y", strtotime("$obj_ona1->OrderDate"));

    $in = $mysqli->query("SELECT * from lbs_shipping WHERE OrderId='$con_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ona1x= $in->fetch_object()){
     $shippingCost=$obj_ona1x->lbs_shipping_amount;
        
     }
     }   
    ?>  
<h4>Order #<?php print $order_id;?> was placed on <?php print $OrderDate;?> </h4>
<h4>ORDER DETAILS</h4>

<table  style="width: 100%;" border="1">    
    <tr ><th>Product</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$con_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr class="ona_order"><td>'.$obj_ptds->ProductName.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($obj_ptds->ProductCost).'</td></tr>';    
     }
     ?>
     <tr><td>Shipping:</td> <td>Kes <?php print $shippingCost; ?></td> </tr>    
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td>Kes <?php print wits_money($OrderTotal);?></td> </tr>  
</table>
       
                </div>
            </div>
  <?php } ?>
            