  <script language="javascript" type="text/javascript">
<!--
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME?> | Orders";
//-->
</script>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Orders</h1>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-sitemap fa-fw"></i> Manage Orders </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <!--Begin Forms-->
		<?php
                $dummyImagy = 'http://via.placeholder.com/350x400';
		$a = isset($_GET["task"])?$_GET["task"]:"";
		$recid = intval(! empty($_GET['recid']))?$_GET['recid']:0;
                $OrderId = intval(! empty($_GET['OrderId']))?$_GET['OrderId']:0;
		
		switch ($a) {
		case "add":
		  addrec();
		  break;
		case "view":
		  viewrec($OrderId);
		  break;
                case "process";           
                 process_order($OrderId);
		  break;
		case "edit":
		  editrec($recid);
		  break;
		case "del":
		  deleterec($recid);
		  break;
		default:
		  select();
		  break;
		}		
		?>
		<!--End Forms-->      
      </div>
      <!-- /.panel-body --> 
    </div>
    <!-- /.panel-default --> 
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->



<?php
/*function showpagenav(){
	
}*/

function select(){
	
	$res = sql_select();
	$count = sql_getrecordcount();	
	
	if(isset($_GET['enable']) && isset($_GET['eid'])){
		$disabledFlag = intval(! empty($_GET['enable']))?$_GET['enable']:0;
		$editID = intval(! empty($_GET['eid']))?$_GET['eid']:0;
		
		sql_update_status($disabledFlag, $editID);
	}
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li class="active">Orders</li></ol>

<div id="hideMsg"><?php //if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>
<div id="adv-tab-container"><ul class="nav nav-tabs cookie">
          <li class="active"><a data-toggle="tab" href="#tabs-1" title="Customers"><span>All Orders</span></a></li>
          <li><a data-toggle="tab" href="#tabs-2" title="Announcements"><span>Purchased orders</span></a></li>
          <li><a data-toggle="tab" href="#tabs-3" title="Login History"><span>Instore</span></a></li>
                    <li><a data-toggle="tab" href="#tabs-4" title="Login History"><span>Delivered</span></a></li>
                         <li><a data-toggle="tab" href="#tabs-5" title="Login History"><span>Pending</span></a></li>
                         <li class="" style="background:#ffff99;"><a data-toggle="tab" href="#tabs-6" title="Item Look up"> <i class="fa fa-search"></i> <span>Item Look Up</span></a></li>
                         
                           
        </ul>
    <?php
    function oTA($orderState){
global $mysqli;
//$orderState=0;


//$orderState=1;
if($orderState==='666'){
$countquery = $mysqli->query("select COUNT(*) FROM lbs_order")or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
$count = $countquery->fetch_row(); 
 $results = $mysqli->query("SELECT * FROM lbs_order ORDER BY OrderId DESC");
}
else{
$countquery = $mysqli->query("select COUNT(*) FROM lbs_order WHERE Status='$orderState'")or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
$count = $countquery->fetch_row();
    $results = $mysqli->query("SELECT * FROM lbs_order WHERE Status='$orderState' ORDER BY OrderId DESC");
}
//print 'count->'.$count2=$count[0];    
if($results->num_rows<1){
    print 'No records';
}
else{
    while($row = $results->fetch_array()){
?>
    <tr class="<?php if($OrderStatus==0){ print ' alert-danger';} elseif($OrderStatus==1){ print ' alert-info';}
    elseif($OrderStatus==7){ print ' alert-warning';}elseif($OrderStatus==8){ print ' alert-success';} else{ }?>">
<?php
global $mysqli;
$project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$row["lbs_bill_shipping_id"])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona1= $project_desc1->fetch_object();


$order_margins = $mysqli->query("SELECT * from lbs_order_margins WHERE OrderId=".$row["OrderId"])or die('Error : ('. $mysqli->errno .') '. $mysqli->error); 

$row_cnt = $order_margins->num_rows;
//fetctch order margins
 if($count[0]>1){
$totalCost_Usd=0;
$totalCost_Ksh=0;
$convertedSellingcost_Ksh=0;
$convertedSellingcost_Usd=0;
$profitKes=0;
$profitUsd=0;
 }
while($obj_onamargg= $order_margins->fetch_object()){
    if($row_cnt>1){
 //Total USD(KES)
  $totalCost_Usd+=$obj_onamargg->totalCost_Usd;
  $totalCost_Ksh+=$obj_onamargg->totalCost_Ksh;
  //Selling USD(KES)
  $convertedSellingcost_Ksh+=$obj_onamargg->convertedSellingcost_Ksh;
  $convertedSellingcost_Usd+=$obj_onamargg->convertedSellingcost_Usd;
  //Profit USD(KES)
  $profitKes+=$obj_onamargg->profitKes;
  $profitUsd+=$obj_onamargg->profitUsd;
  
  //profit margins
 $margin+=$obj_onamargg->margin;
    }
    else{
         //Total USD(KES)
  $totalCost_Usd=$obj_onamargg->totalCost_Usd;
  $totalCost_Ksh=$obj_onamargg->totalCost_Ksh;
  //Selling USD(KES)
  $convertedSellingcost_Ksh=$obj_onamargg->convertedSellingcost_Ksh;
  $convertedSellingcost_Usd=$obj_onamargg->convertedSellingcost_Usd;
  //Profit USD(KES)
  $profitKes=$obj_onamargg->profitKes;
  $profitUsd=$obj_onamargg->profitUsd;
  
  //profit margins
 $margin=$obj_onamargg->margin;
        
    }
  
    
}
?>
    <td>
        
     <a href="staff.php?tab=2&task=process&OrderId=<?php print $row['OrderId'];?>"><?php print $row['OrderId'].' '.$Fname=$obj_ona1->Fname; ?> <i  style="font-weight:bold;"class="fa fa-eye" aria-hidden="true"></i></a>   
    </td>

<td><?php
$project_desc1s = $mysqli->query("SELECT SUM(weight) as total_weight FROM lbs_orderitems WHERE OrderId=".$row["OrderId"])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_onas= $project_desc1s->fetch_object();
 $weight+=$obj_onas->total_weight; if($weight>0){
  print $weight;   
 }
 else{
     print 0.2;
 }
?></td>

<!--<td><?php //print 'Amazon';?></td>-->
<td><?php print '$ '.$totalCost_Usd; ?></td>

<!--<td><? //=$row["OrderTotal"]?></td>-->


<td><?php
$Status=$row["Status"];
if($Status==0){ print '<i class="fa fa-stop" aria-hidden="true"></i> Pending'; }
      elseif($Status==1){ print '<i class="fa fa-spinner" aria-hidden="true"></i> Purchased'; }
      elseif($Status==2){ print '<i class="fa fa-check-square-o" aria-hidden="true"></i> Completed'; }
      elseif($Status==3){ print '<i class="fa fa-pause" aria-hidden="true"></i> On hold'; }
      elseif($Status==7){ print '<i class="fa fa-shopping-basket" aria-hidden="true"></i> Arrived'; }    
     elseif($Status==8){ print '<i class="fa fa-shopping-basket" aria-hidden="true"></i> Picked'; } 
      else{ print '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i> Cancelled'; }
        
        
      ?><br>
       <br/>
     
                 <?php if($Status==1||$Status>1){?>               
                <?php  } else{ ?>
    <form action="new_process.php" method="post">
               <input type="hidden" name="Status"  value="<?php print 1; ?>"/>
           <input type="hidden" name="orderId"  value="<?php print $row['OrderId']; ?>"/>
                          <input type="hidden" name="from"  value="<?php print 'staff'; ?>"/>
                                 <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
                  <input type="submit" name="process_order" class="btn btn-primary" value="Process Order"/>
    </form>                
                <?php } ?>
                  
                   <?php  if($Status==1){?>
  
    <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $row["OrderId"]; ?>"/>
        <input type="hidden" name="Status" value="7"/>
             <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <input type="hidden" name="from" value="staff"/>
           <button class="label label-default" type="submit" name="to_pick" > <i class="fa fa-check"></i> Arrived?</button> 
    </form>
   <?php } elseif($Status==7){?>
       <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $row["OrderId"]; ?>"/>
        <input type="hidden" name="Status" value="8"/>
           <input type="hidden" name="from" value="staff"/>
                <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <button class="label label-success" type="submit" name="picked" > Delivered? </button> 
    </form>    
   <?php } elseif($Status==8){?>
    <a href="#" class="label label-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Order Delivered</a>     
           <?php } else{ } ?>

</td>

<td>   
      <input type="checkbox" name="checked_id[]" class="checkbox" value="<?=$row['OrderId'] ?>"/>
</td>
</tr>        
<?php
}
}

}
    ?>
       
<div class="tab-content">
  
          <div id="tabs-1" class="tab-pane active">
                 <?php 

  showpagenav($pagecount); ?>
     <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	     
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid"># Order</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th class="no-sort">Status</th>

<th class="no-sort"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
</tr>
</thead>
<tbody>
<?php  

 oTA($orderState='666');

?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
              <?php 
showpagenav($pagecount);


 ?>

              


              </div>
     <div id="tabs-2" class="tab-pane">
         
    <?php 

  showpagenav($pagecount); ?>
     <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	     
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid"># Order</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th class="no-sort">Status</th>

<th class="no-sort"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
</tr>
</thead>
<tbody>
<?php  

 oTA($orderState=1);

?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
              <?php 
showpagenav($pagecount);


 ?>
                     </div>
          <div id="tabs-3" class="tab-pane">
          <?php 

  showpagenav($pagecount); ?>
     <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	     
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid"># Order</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th class="no-sort">Status</th>

<th class="no-sort"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
</tr>
</thead>
<tbody>
<?php  

 oTA($orderState=7);

?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
              <?php 
showpagenav($pagecount);


 ?>
          </div>
        <div id="tabs-4" class="tab-pane">
        <?php 

  showpagenav($pagecount); ?>
     <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	     
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid"># Order</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th class="no-sort">Status</th>

<th class="no-sort"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
</tr>
</thead>
<tbody>
<?php  

 oTA($orderState=8);

?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
              <?php 
showpagenav($pagecount);


 ?>
          </div>
     <div id="tabs-5" class="tab-pane">
       <?php 

  showpagenav($pagecount); ?>
     <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	     
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid"># Order</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th class="no-sort">Status</th>

<th class="no-sort"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
</tr>
</thead>
<tbody>
<?php  

 oTA($orderState=0);

?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
              <?php 
showpagenav($pagecount);?>


          </div>
 <div id="tabs-6" class="tab-pane">
           <?php  if(isset($_POST['manthaOrder'])) { ?>  <div id="res_search" class="row fetched-datax">
            <!--<h3 class="">Order details</h3>-->
     <?php global $mysqli;
  $OrderId = $_POST['orderId'];
 global $mysqli;
   $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$sellCost=$obj_ona1->sellCostTotal; 
$orderRemarks=$obj_ona1->orderRemarks;
$OrderDate=date("jS F, Y", strtotime("$obj_ona1->OrderDate"));
$lbs_bill_shipping_id=$obj_ona1->lbs_bill_shipping_id;
$processedBy=$obj_ona1->processedBy;
     }   
    ?>  



<h4>Order #<?php print $OrderId;?> was placed on <?php print $OrderDate;?> </h4>

<div class="table-responsive">
<table class="table table-condensed table-striped table-bordered">    
   <?php if($OrderStatus<1) { ?><tr><th style="width: 2%">Image</th><th style="width: 60%">Title</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr><td>';
    
    if($obj_ptds->thumbnail!='') {?>
    
    <img class="orders_img" src="<?php print $obj_ptds->thumbnail; ?>"/>
    <?php } else{ ?>
     <img class="orders_img" src="<?php print $dummyImagy ?>"/>
    
    <?php } ?>
            
</td><td><a target="_blank" href="<?php print $obj_ptds->ProductLink;?>"><?php print $obj_ptds->ProductName;?></a><?php print 'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($obj_ptds->sellCost).'</td></tr>';    
   } }
     ?>    <tr><td>Shipping Method:</td> <td colspan="2"><?php
     $pdts = $mysqli->query("SELECT * from  lbs_shipping WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
  print $shipmethod=$obj_ptds->lbs_shipping_method;    
   $shipamount=$obj_ptds->lbs_shipping_amount; 
     }
     
     ?></td> </tr> 
    <tr><td>Shipping Cost:</td> <td colspan="2"><?php
     print 'Ksh '.$shipamount;
     ?></td> </tr>    
     <tr><td>Date Delivered :</td> <td colspan="2"><?php
     if($Status==8){
         $pdtsx = $mysqli->query("SELECT * from lbs_order_history WHERE OrderId='$OrderId' AND Status=8")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptdsx= $pdtsx->fetch_object())
     {       
   print date("jS F, Y", strtotime("$obj_ptdsx->regDate")); 
      
     }
    // date("jS F, Y", strtotime("$obj_ona1->OrderDate"))    
     }
     else{
     print 'N/A';
     }
     ?></td> </tr> 
      <tr><td>Processed By :</td> <td colspan="2"><?php
                 if($Status==0){
      print 'N/A';      
        }
           else{     
$pdts = $mysqli->query("SELECT * from lbs_sys_users WHERE ID='$processedBy'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptds= $pdts->fetch_object())
     {       
   print $obj_ptds->Username; 
     } 
     }
    
     ?></td> </tr> 
          <tr><td>Customer Name :</td> <td colspan="2"><?php
          
$pdts = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$lbs_bill_shipping_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptds= $pdts->fetch_object())
     {       
   print $obj_ptds->Fname; 
      
     }
    
     ?></td> </tr> 
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td> <?php print wits_money($sellCost+$shipamount);?></td> </tr>  
          <tr><td><b>Order Status:</b></td> <td colspan="2"><div class="form-group">
                      <form method="post" action="new_process.php">
  <select class="form-control" id="sel1" name="Status">
      <option value="<?php print $Status;?>" selected="selected"><?php if($Status==0){ print 'Pending'; }
      elseif($Status==1){ print 'Purchased <i class="fa fa-check" aria-hidden="true"></i>'; }
      elseif($Status==2){ print 'Completed'; }elseif($Status==3){ print 'On hold'; } else{ print 'Cancelled'; } ?></option>
      <option value="0">Pending</option>
    <option value="1">Purchase</option>
    <option value="2">Completed</option>
    <option value="3">On hold</option>
     <option value="4">Cancelled</option>
     
     
  </select>
                          <input type="hidden" name="orderId"  value="<?php print $OrderId; ?>"/>
                          <input type="hidden" name="from"  value="<?php print 'admin'; ?>"/>
                                 <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
                         
                                 
</div></td> </tr>  
          <tr><td colspan="3">
                 
                 <?php if($Status==1||$Status>1){?>
                  <a href="#" class="btn btn-primary" >Order Purchased</a>     
                <?php  } else{ ?>
                  <input type="submit" name="process_order" class="btn btn-primary" value="Process Order"/>
                
                <?php } ?>
                  
                   <?php  if($Status==1){?>
  
    <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $OrderId; ?>"/>
        <input type="hidden" name="Status" value="7"/>
             <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <input type="hidden" name="from" value="admin"/>
           <button class="label label-default" type="submit" name="to_pick" > <i class="fa fa-check"></i> Arrived?</button> 
    </form>
   <?php } elseif($Status==7){?>
       <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $OrderId; ?>"/>
        <input type="hidden" name="Status" value="8"/>
           <input type="hidden" name="from" value="admin"/>
                <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <button class="label label-success" type="submit" name="picked" > Delivered? </button> 
    </form>
    
   <?php } elseif($Status==8){?>
    <a href="#" class="label label-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Order Delivered</a>     
           <?php } else{ } ?>
              
              
              </td> </tr>  
</table> 
      
      
    </div><?php }  else{ ?>
         <div id="def_search" class="row" <h3 class="">Enter order Id to search</h3>
             <form class="mansthaOrderId" method="post" action="">
    <div class="form-group">
        <label class="sr-only" for="orderId">Order Id</label>
        <input type="text" class="form-control" id="orderId" name="orderId" placeholder="Order Id here....">
        <input type="hidden" name="manthaOrder"/>
    </div>   
    
             <button type="submit" class="btn btn-primary" name="manthaOrder"><i class="fa fa-search"></i> Search Order </button>
</form>
         </div>
         
<?php } ?>
          </div>
   

        </div>

</div>
                      <?php
}?>
              
              <?php

//new
//list orders
function sql_select(){
	global $conn;
	
	//$sql = "SELECT `UID`,`CustomerID`,`FName`,`MName`,`LName`,CONCAT(`FName`,' ',`LName`) AS `CustomerName`,`Gender`,`ProfilePhoto`,`RegDate`,`Email`,`DOB`,`Phone`,`Address1`,`Address2`,`City`,`State`,`PostCode`,`Country`,`disabledFlag` FROM `".DB_PREFIX."customers`";	
	$sql = "SELECT * FROM `".DB_PREFIX."order";	
	
        $res = db_query($sql,DB_NAME,$conn);
	return $res;
}

//2
function sql_getrecordcount(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."order`";	
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}
//view
function viewrec($OrderId) {
 global $mysqli;
   $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$OrderTotal=$obj_ona1->OrderTotal; 
$orderRemarks=$obj_ona1->orderRemarks;
$OrderDate=date("jS F, Y", strtotime("$obj_ona1->OrderDate"));
$lbs_bill_shipping_id=$obj_ona1->lbs_bill_shipping_id;
     }   
    ?>  

<div class="quick-nav btn-group">
<a class="btn btn-default" href="staff.php?tab=2"><i class="fa fa-undo fa-fw"></i> Back to Orders</a>

</div>

<h4>Order #<?php print $OrderId;?> was placed on <?php print $OrderDate;?> </h4>

<div class="table-responsive">
<table class="table table-condensed table-striped table-bordered">    
    <tr><th style="width: 60%">Product</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr><td>'.$obj_ptds->ProductName.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($obj_ptds->ProductCost).'</td></tr>';    
     }
     ?>
     <tr><td>Shipping:</td> <td>Kes 0.00</td> </tr>    
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td>Kes <?php print $OrderTotal;?></td> </tr>  
          <tr><td><b>Order Status:</b></td> <td><div class="form-group">
                      <form method="post" action="">
  <select class="form-control" id="sel1" name="Status">
      <option value="<?php print $Status;?>" selected="selected"><?php if($Status==0){ print 'Pending'; }
      elseif($Status==1){ print 'Purchased'; }
      elseif($Status==2){ print 'Completed'; }elseif($Status==3){ print 'On hold'; } else{ print 'Cancelled'; } ?></option>
      <option value="0">Pending</option>
    <option value="1">Purchase</option>
    <option value="2">Completed</option>
    <option value="3">On hold</option>
     <option value="4">Cancelled</option>
     
     
  </select>
                          <input type="hidden" name="orderId"  value="<?php print $OrderId; ?>"/>
                          <input type="hidden" name="recid"  value="<?php print @$_GET['recid']; ?>"/>
                                 
</div></td> </tr>  
          <tr><td colspan="2"><input type="submit" name="update_order"  class="btn btn-primary"/></td> </tr>  
</table>
                   <br>
                             
</div>
<?php	
  
}
?>

<?php
function showpagenav() {
?>
<div class="quick-nav btn-group">
<a class="btn btn-primary" href="staff.php?tab=2&task=add">Add Order</a>
<a class="btn btn-default" href="staff.php?tab=2&task=reset">Reset Filters</a>
</div>
<?php } ?>

<?php function showrecnav($a, $recid, $count) { ?>
<div class="quick-nav btn-group">
<a class="btn btn-default" href="staff.php?tab=2"><i class="fa fa-undo fa-fw"></i> Back to Orders</a>
<?php if ($recid > 0) { ?>
<a class="btn btn-default" href="staff.php?tab=2&task=<?=$a ?>&recid=<?=$recid - 1 ?>"><i class="fa fa-arrow-left fa-fw"></i> Prior Record</a>
<?php } if ($recid < $count - 1) { ?>
<a class="btn btn-default" href="staff.php?tab=2&task=<?=$a ?>&recid=<?=$recid + 1 ?>"><i class="fa fa-arrow-right fa-fw"></i> Next Record</a>
<?php } ?>
</div>
<?php } ?>
<?php
function process_order($OrderId){
	

?>
<div class="row order_panel">
    <div class="col-md-12">
        <div class="quick-nav btn-group">
<a class="btn btn-default" href="staff.php?tab=2"><i class="fa fa-undo fa-fw"></i> Back to Orders</a>

</div>
    </div>
   <div class="col-md-6">
       <h2> From the System</h2>
        <?php
   global $mysqli;
   $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$shipping_cost=$obj_ona1->shipping_cost; 
$Status=$obj_ona1->Status; 
$sellCost=$obj_ona1->sellCostTotal; 
$orderRemarks=$obj_ona1->orderRemarks;
$OrderDate=date("jS F, Y", strtotime("$obj_ona1->OrderDate"));
$lbs_bill_shipping_id=$obj_ona1->lbs_bill_shipping_id;
$processedBy=$obj_ona1->processedBy;
     }   
    ?>  



<h4>Order #<?php print $OrderId;?> was placed on <?php print $OrderDate;?> </h4>

<div class="table-responsive">
<table class="table table-condensed table-striped table-bordered">    
    <tr><th style="width: 2%">Image</th><th style="width: 60%">Title</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr><td>';
    
    if($obj_ptds->thumbnail!='') {?>
    
    <img class="orders_img" src="<?php print $obj_ptds->thumbnail; ?>"/>
    <?php } else{ ?>
     <img class="orders_img" src="<?php print $dummyImagy ?>"/>
    
    <?php } ?>
            
</td><td><a target="_blank" href="<?php print $obj_ptds->ProductLink;?>"><?php print $obj_ptds->ProductName;?></a><?php print 'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($obj_ptds->sellCost).'</td></tr>';    
     }
     ?>    <tr><td>Shipping Method:</td> <td colspan="2"><?php
     $pdts = $mysqli->query("SELECT * from  lbs_shipping WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
  print $shipmethod=$obj_ptds->lbs_shipping_method;    
     }
     
     ?></td> </tr> 
   
     <tr><td>Date Delivered :</td> <td colspan="2"><?php
     if($Status==8){
         $pdtsx = $mysqli->query("SELECT * from lbs_order_history WHERE OrderId='$OrderId' AND Status=8")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptdsx= $pdtsx->fetch_object())
     {       
   print date("jS F, Y", strtotime("$obj_ptdsx->regDate")); 
      
     }
    // date("jS F, Y", strtotime("$obj_ona1->OrderDate"))    
     }
     else{
     print 'N/A';
     }
     ?></td> </tr> 
      
          <tr><td>Customer Name :</td> <td colspan="2"><?php
          
$pdts = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$lbs_bill_shipping_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptds= $pdts->fetch_object())
     {       
   print $obj_ptds->Fname; 
      
     }
    
     ?></td> </tr> 
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
         
          <tr><td><b>Order Status:</b></td> <td colspan="2"><div class="form-group">
                      <form method="post" action="new_process.php">
  <select class="form-control" id="sel1" name="Status">
      <option value="<?php print $Status;?>" selected="selected"><?php if($Status==0){ print 'Pending'; }
      elseif($Status==1){ print 'Purchased <i class="fa fa-check" aria-hidden="true"></i>'; }
      elseif($Status==2){ print 'Completed'; }elseif($Status==3){ print 'On hold'; } else{ print 'Cancelled'; } ?></option>
      <option value="0">Pending</option>
    <option value="1">Purchase</option>
    <option value="2">Completed</option>
    <option value="3">On hold</option>
     <option value="4">Cancelled</option>
     
     
  </select>
                          <input type="hidden" name="orderId"  value="<?php print $OrderId; ?>"/>
                          <input type="hidden" name="from"  value="<?php print 'staff'; ?>"/>
                                 <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
                         
                                 
</div></td> </tr>  
          <tr><td colspan="3">
                 
                 <?php if($Status==1||$Status>1){?>
                  <a href="#" class="btn btn-primary" >Order Purchased</a>     
                <?php  } else{ ?>
                  <input type="submit" name="process_order" class="btn btn-primary" value="Process Order"/>
                
                <?php } ?>
                  
                   <?php  if($Status==1){?>
  
    <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $OrderId; ?>"/>
        <input type="hidden" name="Status" value="7"/>
             <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <input type="hidden" name="from" value="staff"/>
           <button class="label label-default" type="submit" name="to_pick" > <i class="fa fa-check"></i> Arrived?</button> 
    </form>
   <?php } elseif($Status==7){?>
       <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?php print $OrderId; ?>"/>
        <input type="hidden" name="Status" value="8"/>
           <input type="hidden" name="from" value="staff"/>
                <input type="hidden" name="processedBy"  value=" <?php print $_SESSION['sysUserID']; ?>"/>
           <button class="label label-success" type="submit" name="picked" > Delivered? </button> 
    </form>
    
   <?php } elseif($Status==8){?>
    <a href="#" class="label label-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Order Delivered</a>     
           <?php } else{ } ?>
              
              
              </td> </tr>  
</table>
                   <br>
                             
</div>
        
    </div>
    <div class="col-md-6"> 
     
          <h2> From the Amazon</h2>


<h4>Order #<?php print $OrderId;?> as on <?php $now=date("Y-m-d h:i:s"); print date("jS F, Y", strtotime("$now"));?> </h4>
       <div class="table-responsive">
<table class="table table-condensed table-striped table-bordered">    
    <tr><th style="width: 2%">Image</th><th style="width: 60%">Title</th> <th>Total</th> </tr>  
          <?php      
 

//finish api
include 'api.php';
   $asin_order = $mysqli->query("SELECT * from lbs_orderitems WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona21= $asin_order->fetch_object())
     {
//$obj_ona1->lbs_bill_shipping_id; 
$productID=$obj_ona21->ProductId;

 //Variables
  $ItemAttributes = array();
  
  $response = $client->lookup($productID);
    
  $response  = json_encode( $client->lookup($productID) );
  
  $response = json_decode($response, true);  
  if( $response["Items"]["Request"]["IsValid"] ) {
    
      if( is_array( $response["Items"]["Item"] ) ) {			
              
          $ASIN = $response["Items"]["Item"]["ASIN"];
		  $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
		  $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                  $MediumImageURL = $response["Items"]["Item"]["MediumImage"]["URL"];
		  $ItemAttributes["Binding"] = $response["Items"]["Item"]["ItemAttributes"]["Binding"];
		  $ItemAttributes["Brand"] = $response["Items"]["Item"]["ItemAttributes"]["Brand"];
		  $ItemAttributes["Color"] = $response["Items"]["Item"]["ItemAttributes"]["Color"];
          $ItemAttributes["Manufacturer"] = $response["Items"]["Item"]["ItemAttributes"]["Manufacturer"];
		  $ItemAttributes["Model"] = $response["Items"]["Item"]["ItemAttributes"]["Model"];
		  $ItemAttributes["Size"] = $response["Items"]["Item"]["ItemAttributes"]["Size"];
		  $Title = $response["Items"]["Item"]["ItemAttributes"]["Title"];
          $ListPrice = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]:"";
		  $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
		  $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]:"";
		  $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
		  $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
		  $ConvertedWeight = !empty($Weight)?$Weight/100:0;
		  
		  $Amount = $Amount/100;
		  $BuyingCost = ($Amount+SHIPPING_RATE)*(1+TAX_RATE);
		  $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
		  $TotalCost = $BuyingCost+($ConvertedWeight/2.2*10);
		  $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
		  $ConvertedSellingCost = $ConvertedTotalCost*(1+0.16);
		  $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                  $MediumImageURL = $response["Items"]["Item"]["MediumImage"]["URL"];
                  //new variables added
                     // $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"][1]["URL"];
                   $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"]["1"]["URL"];
 
               // print '<li>'.$Title.'</li>';
                     print '<tr><td>';
    
    if($MediumImageURL!='') {?>
    
    <img class="orders_img" src="<?php print $MediumImageURL; ?>"/>
    <?php } else{ ?>
     <img class="orders_img" src="<?php print $dummyImagy ?>"/>
    
    <?php } ?>
            
 <?php  print '</td><td>'.$Title.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.wits_money($ConvertedSellingCost).'</td></tr>';  
          }
          
          
      }
     }
     
          
          ?>
</table>
            </div>
    </div>
    
    
    
    
</div>



<?php } 
?>

 <script>$(document).ready(function(){
                          
                          // store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
var id = $(e.target).attr("href").substr(1);
window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#adv-tab-container a[href="' + hash + '"]').tab('show');
});
                                </script>
                                
                               
