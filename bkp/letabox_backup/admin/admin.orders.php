<?php

?><script language="javascript" type="text/javascript">
<!--
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME?> | Orders";
//-->
</script>
<style>
    .orders_img{
        height: 60px;
    }
</style>

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
      <div class="panel-heading"> <i class="fa fa-sitemap fa-fw"></i> Order details </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <!--Begin Forms-->
		<?php
		$a = isset($_GET["task"])?$_GET["task"]:"";
		$recid = intval(! empty($_GET['recid']))?$_GET['recid']:0;
                $OrderId = intval(! empty($_GET['OrderId']))?$_GET['OrderId']:0;
		
		switch ($a) {
		case "add":?>
        
        <div class="table-responsive">
        <h3>Place an order</h3>
        <form  action="" method="post"/>
<table class="table table-bordered table-striped">
<tr>
<td width="40%">Order date</td>
<td>       <input  class="form-control datepicker required" type="text" value="" name="OrderDate" /></td>
</tr>
<tr>
<td >Order status:</td>
<td>  <select class="form-control" id="sel1" name="Status">      
      <option value="0">Pending</option>
    <option value="1">Purchase</option>
    <option value="2">Completed</option>
    <option value="3">On hold</option>
     <option value="4">Cancelled</option>
     
     
  </select></td>
</tr>
<tr>
<td >Customer:</td>
<td> <?php
 global $mysqli;
   $project_desc1 = $mysqli->query("SELECT * from lbs_customer")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
$select= '<select class="form-control" name="lbs_customer">';
while($obj_ona1= $project_desc1->fetch_object()){
      $select.='<option value="'.$obj_ona1->lbs_bill_shipping_id.'">'.$obj_ona1->Fname.'</option>';
  }

$select.='</select>';
echo $select;

?></td>
</tr>
<tr>
<td>Order Total</td>
<td>
    
  <input type="number" class="form-control" name="OrderTotal">
    
</td>
</tr>
<tr>
<td>Order Comments</td>
<td><div class="form-group">
  <textarea class="form-control" rows="5" name="orderRemarks"></textarea>
</div></td>
</tr>
<tr>
    <td colspan="2"><input type="submit" name="add_order" class="btn btn-success" value="Place order"/></td>

</tr>

</table>
    </form>
        <?php
        if(isset($_POST["add_order"])){
            global $mysqli;
		// Customer info		
		$OrderDate= $_POST['OrderDate'];
                $date = DateTime::createFromFormat('d/m/Y',$OrderDate);
                $regDate=$date->format("Y-m-d");                
		$Status = $_POST['Status'];
		$lbs_customer= $_POST['lbs_customer'];
                $shipping_cost = 0;
		$OrderTotal=$_POST['OrderTotal'];
                $Order_comments= $_POST['orderRemarks'];
                $query2 = "INSERT INTO  lbs_order (lbs_bill_shipping_id,shipping_cost,Status,OrderTotal,orderRemarks,OrderDate) VALUES(?,?,?,?,?,?)";
$statement2 = $mysqli->prepare($query2);
$statement2->bind_param('ssssss', $lbs_customer,$shipping_cost,$Status,$OrderTotal,$Order_comments,$regDate);
//$statement2->execute();
if(!$statement2->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}

//$_SESSION['MSG'] = ConfirmMessage("Announcement added successfully");
 print '<script type="text/javascript">'.'alert("Order Placed.");'.'</script>';
     
                          print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3'
       window.location.assign(myurl)
       </script>"; 


                
        }
        
        ?>
</div>
		
        <?php
//add_order();
		  break;
		case "view":
		
                    viewrec($OrderId);
		  break;
		case "edit":
		  editrec($recid);
		  break;
                  case "process";           
                 process_order($OrderId);
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
                function editrec(){
                    
                }

?>

<?php 
function select(){
	

	
        if(@$_GET['status']==='pending'){
            $count=sql_getrecordcount_p();
        $res=sql_select_pending();    
        }
        elseif(@$_GET['status']==='completed'){
                 $count=sql_getrecordcount_c();  
           $res=sql_select_completed();
       
        }
        else{
            $count = sql_getrecordcount();
        	$res = sql_select();    
        }
	
	if(isset($_GET['enable']) && isset($_GET['eid'])){
		$disabledFlag = intval(! empty($_GET['enable']))?$_GET['enable']:0;
		$editID = intval(! empty($_GET['eid']))?$_GET['eid']:0;
		
		sql_update_status($disabledFlag, $editID);
	}
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li class="active">Orders</li></ol>
<div id="hideMsg"><?php if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>

<?php showpagenav($pagecount); ?>
<div class="row filter" style="float:right; width:60%; margin:0 15px;">
	<div class="col-md-9">
		<div class="input-group input-daterange">
			<div class="input-group-addon">Date From</div>
			<input type="text" name="start_date" class="form-control" value="">
			<div class="input-group-addon">To</div>
			<input type="text" name="end_date" class="form-control" value="">		
		</div>
	</div>
	<div class="col-md-3">
		<div class="btn-group">
			<input type="button" name="filter" id="filter" value="Filter" class="btn btn-info">
		</div>
	</div>
	
	
	
</div>
<form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>	 
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid">Order</th>
<th>Date</th>
<th>Weight(Lbs)</th>
<th>Cost USD</th>
<th>Total USD(KES)</th>
<th>Selling USD(KES)</th>
<th>Profit USD(KES)</th>
<th>Margin</th>
<th class="no-sort">Status</th>
<th class="no-sort"><!--<input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" />-->
<input type="checkbox" name="select_all" id="select_all" value=""/>  
</th>
</tr>
</thead>
<tbody>
<?php
for ($i = 0; $i < $count; $i++){
	$row = db_fetch_array($res);
?>
<tr>

<td>
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
  
  //cost USD
    //Profit USD(KES)
  $costUsd+=$obj_onamargg->costUsd;
  
  
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
 
 //costUsd
   $costUsd=$obj_onamargg->costUsd;
        
    }
  
    
}
?>
    <a href="admin.php?tab=3&task=process&OrderId=<?php print $row['OrderId'];?>"><?php print $row['OrderId'].' '.$Fname=$obj_ona1->Fname; ?> <i  style="font-weight:bold;"class="fa fa-eye" aria-hidden="true"></i></a>
    </td>
<td><?php
 //$OrderDate=date("jS F, Y", strtotime("$OrderDate"));
$date=date_create($row["OrderDate"]);
echo date_format($date,"d/m/y");

     ?>

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
<td><?php print $costUsd;?></td>
<td><?php
print '$ '.$totalCost_Usd.'('.wits_money($totalCost_Ksh).')';
?></td>
<td><?php
 /*$pdts = $mysqli->query("SELECT * from  lbs_shipping WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    
   $shipamount=$obj_ptds->lbs_shipping_amount; 
     }
print $row["sellCostTotal"]+$shipamount;
*/
print '$ '.$convertedSellingcost_Usd.'('.wits_money($convertedSellingcost_Ksh).')';
?></td>

<td><?php
print '$ '.$profitUsd.'('.wits_money($profitKes).')';
?></td>
<td><?php
if($row_cnt==0){
    print $margin;
}
else{
print round(($margin/$row_cnt),2).' %';
}
?></td>

<td><?php
$Status=$row["Status"];
if($Status==0){ print '<i class="fa fa-stop" aria-hidden="true"></i> Pending'; }
      elseif($Status==1){ print '<i class="fa fa-spinner" aria-hidden="true"></i> Purchased'; }
      elseif($Status==2){ print '<i class="fa fa-check-square-o" aria-hidden="true"></i> Completed'; }
      elseif($Status==3){ print '<i class="fa fa-pause" aria-hidden="true"></i> On hold'; }
      elseif($Status==7){ print '<i class="fa fa-shopping-basket" aria-hidden="true"></i> Arrived'; }    
     elseif($Status==8){ print '<i class="fa fa-shopping-basket" aria-hidden="true"></i> Delivered'; } 
      else{ print '<i class="fa fa-times" style="color:red;" aria-hidden="true"></i> Cancelled'; }
        
        
        ?></td>




<td>
      <!--  <?php  if($Status==1){?>
    <a class="label label-sussess" href="admin.php?tab=3&task=process&OrderId=<?=$row['OrderId'] ?>"> <i class="fa fa-check"></i> View</a> 
    <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?=$row['OrderId'] ?>"/>
        <input type="hidden" name="Status" value="7"/>
           <input type="hidden" name="from" value="admin"/>
           <button class="label label-default" type="submit" name="to_pick" > <i class="fa fa-check"></i> Arrived</button> 
    </form>
   <?php } elseif($Status==7){?>
       <form action="new_process.php" method="post">
        <input type="hidden" name="OrderId" value="<?=$row['OrderId'] ?>"/>
        <input type="hidden" name="Status" value="8"/>
           <input type="hidden" name="from" value="admin"/>
           <button class="label label-success" type="submit" name="picked" > Delivered ? </button> 
    </form>
    
   <?php } elseif($Status==8){?>
    <a href="#" class="label label-success"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Order Delivered</a>     
           <?php }  else{ ?>
         <?php  if($Status==0){?>
    <a class="btn btn-success" href="admin.php?tab=3&task=process&OrderId=<?=$row['OrderId'] ?>"> <i class="fa fa-check"></i> Purchase</a> 
   <?php } } ?>                                                                                    
                                                                                            
<?php if( isSuperAdmin() || isSystemAdmin() ) { ?>
| <a href="admin.php?tab=3&task=del&recid=<?=$i ?>&OrderId=<?=$row['OrderId'] ?>">Delete</a>
<?php } ?>
      
       --> 
      <input type="checkbox" name="checked_id[]" class="checkbox" value="<?=$row['OrderId'] ?>"/>
</td>
</tr>        
<?php
}
db_free_result($res);
?>
</tbody>
<tfoot>
<tr><td colspan="10" class="text-right"> <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/></td></tr>
</tfoot>
</table>
</form>
<?php 
showpagenav($pagecount);
unset($_SESSION['MSG']);
} 
?>
<?php function showrow($row, $recid){?>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tr>
<td width="30%">Customer ID</td>
<td><?=$row["CustomerID"]; ?></td>
</tr>
<tr>
<td>Customer Name</td>
<td><?=$row["CustomerName"]; ?></td>
</tr>
</table>
</div>
<?php } ?>

<?php
function showpagenav() {
?>
<div class="quick-nav btn-group">
<a class="btn btn-primary" href="admin.php?tab=3&task=add">Add Order</a>
<a class="btn btn-default" href="admin.php?tab=3&task=reset">Reset Filters</a>
</div>
<?php } 

//list orders
function sql_select(){
	global $conn;
	
	//$sql = "SELECT `UID`,`CustomerID`,`FName`,`MName`,`LName`,CONCAT(`FName`,' ',`LName`) AS `CustomerName`,`Gender`,`ProfilePhoto`,`RegDate`,`Email`,`DOB`,`Phone`,`Address1`,`Address2`,`City`,`State`,`PostCode`,`Country`,`disabledFlag` FROM `".DB_PREFIX."customers`";	
	$sql = "SELECT * FROM lbs_order ORDER BY OrderId DESC";	
	
        $res = db_query($sql,DB_NAME,$conn);
	return $res;
}
function sql_select_pending(){
	global $conn;		
	$sql = "SELECT * FROM lbs_order WHERE Status='0' ORDER BY OrderId DESC";
	
        $res = db_query($sql,DB_NAME,$conn);
	return $res;
}
function sql_select_completed(){
	global $conn;		
	$sql = "SELECT * FROM lbs_order WHERE Status='3' ORDER BY OrderId DESC";
	
        $res = db_query($sql,DB_NAME,$conn);
	return $res;
}

//for pending orders

//2
function sql_getrecordcount(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."order`";	
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}
function sql_getrecordcount_p(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM lbs_order WHERE Status='0'";	
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}

function sql_getrecordcount_c(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM lbs_order WHERE Status='3'";	
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
<a class="btn btn-default" href="admin.php?tab=3"><i class="fa fa-undo fa-fw"></i> Back to Orders</a>

</div>

<h4>Order #<?php print $OrderId;?> was placed on <?php print $OrderDate;?> </h4>

<div class="table-responsive">
<table class="table table-condensed table-striped table-bordered">    
    <tr><th style="width: 5%">Image</th><th style="width: 60%">Title</th> <th>Total</th> </tr>     
     <?php
     $pdts = $mysqli->query("SELECT * from  lbs_orderitems WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {
    print '<tr><td><img class="orders_img" src="'.$obj_ptds->thumbnail.'"/></td><td>'.$obj_ptds->ProductName.'X <b>'.$obj_ptds->ProductQty.'</b></td><td>'.$obj_ptds->ProductCost.'</td></tr>';    
     }
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
          <tr><td>Payment method:</td> <td>Cash Payment</td> </tr>
          <tr><td><b>Total:</b></td> <td><?php print wits_money($OrderTotal+$shipamount);?></td> </tr>  
          <tr><td><b>Order Status:</b></td> <td colspan="2"><div class="form-group">
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
          <tr><td colspan="3"><input type="submit" name="update_order" class="btn btn-primary" value="Update"/></td> </tr>  
</table>
                   <br>
                             
</div>
<?php	
  
}

	if(isset($_POST["update_order"])){
		
	$Status = secure_string($_POST['Status']);
        $recid = secure_string($_POST['recid']);
        
        $orderId = secure_string($_POST['orderId']);
     $statement = $mysqli->query("UPDATE lbs_order SET Status='$Status' WHERE OrderId='$OrderId'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
     
     print '<script type="text/javascript">'.'alert("Order Status Updated.");'.'</script>';
     
                          print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3&task=view&recid=$recid&OrderId=$orderId'
       window.location.assign(myurl)
       </script>";  
        }

?>
<?php function showrecnav($a, $recid, $count) { ?>
<div class="quick-nav btn-group">
<a class="btn btn-default" href="admin.php?tab=5"><i class="fa fa-undo fa-fw"></i> Back to Customers</a>
<?php if ($recid > 0) { ?>
<a class="btn btn-default" href="admin.php?tab=5&task=<?=$a ?>&recid=<?=$recid - 1 ?>"><i class="fa fa-arrow-left fa-fw"></i> Prior Record</a>
<?php } if ($recid < $count - 1) { ?>
<a class="btn btn-default" href="admin.php?tab=5&task=<?=$a ?>&recid=<?=$recid + 1 ?>"><i class="fa fa-arrow-right fa-fw"></i> Next Record</a>
<?php } ?>
</div>
<?php } ?>
<?php 
function deleterec($recid){
	if( isSuperAdmin() || isSystemAdmin() ) {
		// Commands
		if(isset($_POST["Delete"])){
			sql_delete();
		}
	  
		$res = sql_select();
		$count = sql_getrecordcount();
		db_data_seek($res, $recid);
		$row = db_fetch_array($res);  
		?>
		<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=3">Orders</a></li><li class="active">Delete Order</li></ol>
		<?php showrecnav("del", $recid, $count); ?>
		<form action="admin.php?tab=3&task=del&recid=<?=$recid?>" method="post">
		<input type="hidden" name="sql" value="delete" />
                <input type="hidden" name="eid" value="<?php print @$_GET['OrderId']?>" />
		<?php //showrow($row, $recid) ?>
		<strong>Are you sure you want to delete this record? </strong><div class="btn-group"><input class="btn btn-primary" type="submit" name="Delete" value="Yes" /> <input class="btn btn-default" type="button" name="Ignore" value="No" onclick="javascript:history.go(-1)" /></div>
		</form>
		<?php
		db_free_result($res);
	}else{
		echo ErrorMessage("You do not have the privilege to delete orders. Please contact the system admin for details.");
	}
}

//more functions
function sql_delete(){
	global $conn;
	
	$sql = "DELETE FROM `".DB_PREFIX."order` WHERE " .primarykeycondition();
	db_query($sql,DB_NAME,$conn);
	
	//Check if saved
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Order has been deleted successfully");
	}else{
		$_SESSION['MSG'] = ErrorMessage("Failed to delete selected order. Please try again later...");
	}
	redirect("admin.php?tab=3");
}

function primarykeycondition(){
	
	$pk = "";
	$pk .= "(`OrderId`";
	if (@$_POST["eid"] == "") {
		$pk .= " IS NULL";
	}else{
		$pk .= " = " .intval(@$_POST["eid"]);
	};
	$pk .= ")";
	return $pk;
}

function add_order(){?>
    
    
<?php }
?>


<?php
function process_order($OrderId){
	

?>
<div class="row order_panel">
    <div class="col-md-12">
        <div class="quick-nav btn-group">
<a class="btn btn-default" href="admin.php?tab=3"><i class="fa fa-undo fa-fw"></i> Back to Orders</a>

</div>
    </div>
   <div class="col-md-4">
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
                   <br>
                             
</div>
        
    </div>
    <div class="col-md-4"> 
     
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
    
    <div class="col-md-4">
                            <h2> Order Process History for Order # <?php print $OrderId; ?></h2>
                            
                            <table class="table table-condensed table-hover table-striped">
                                <tr><th>Date</th><th>Narration</th><th>By</th></tr>
                                   <?php 
    $project_desc1 = $mysqli->query("SELECT * from lbs_order_history WHERE OrderId='$OrderId' ORDER BY lbs_order_history_id DESC")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    if ($project_desc1->num_rows < 1) {
       print "<tr><td colspan='3'><i>No records</i></td>";
   } 
                                   else{
                                                

   while($obj_ona1= $project_desc1->fetch_object())
     {?>      
  
       <tr>
           <td>
          <?php  
$date=date_create($obj_ona1->regDate);
echo date_format($date,"d/m/y");
          
          ?>                         
           </td>
                 <td>
          <?php 
  if($obj_ona1->Status==1){
      print 'Order Purchased';
  }
  elseif($obj_ona1->Status==7){
            print 'Order Approved as arrived';
      
  }
  elseif($obj_ona1->Status==8){
        print 'Order Confirmed as Delivered';
  }
          ?>                         
           </td>
                                <td>
          <?php 
    $pdts = $mysqli->query("SELECT * from lbs_sys_users WHERE ID=".$obj_ona1->processedBy)or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    while($obj_ptds= $pdts->fetch_object())
     {       
   print $obj_ptds->Username; 
      
     } ?>                         
           </td>             
       </tr>
                 
    <?php   
       
   }
                                   }?>
                                   
                                
                            </table>
                                
    </div>
    
    
</div>



<?php } ?>

                <script type="text/javascript" language="javascript" >
$(document).ready(function(){
 
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format: "yyyy-mm-dd",
  autoclose: true
 });

 fetch_data('no');

 function fetch_data(is_date_search, start_date='', end_date='')
 {
  var dataTable = $('#order_data').DataTable({
   "processing" : true,
   "serverSide" : true,
   "order" : [],
   "ajax" : {
    url:"ajax.php",
    type:"POST",
    data:{
     is_date_search:is_date_search, start_date:start_date, end_date:end_date
    }
   }
  });
 }

 $('#search').click(function(){
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  if(start_date != '' && end_date !='')
  {
   $('#order_data').DataTable().destroy();
   fetch_data('yes', start_date, end_date);
  }
  else
  {
   alert("Both Date is Required");
  }
 }); 
 
});

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>
<?php
  if(isset($_POST['bulk_delete_submit'])){
        $idArr = $_POST['checked_id'];
        foreach($idArr as $id){
$results = $mysqli->query("DELETE FROM lbs_order WHERE OrderId='$id'");

if($results){
     print '<script type="text/javascript">'.'alert("Records deleted.");'.'</script>';  
  print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3'
       window.location.assign(myurl)
       </script>";
}else{
    print 'Error : ('. $mysqli->errno .') '. $mysqli->error;
}
        }
       
    }
    ?>