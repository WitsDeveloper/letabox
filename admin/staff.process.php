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
      <div class="panel-heading"> <i class="fa fa-sitemap fa-fw"></i> Order Process</div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <!--Begin Forms-->
		<?php
		$a = isset($_GET["task"])?$_GET["task"]:"";
		//$recid = intval(! empty($_GET['recid']))?$_GET['recid']:0;
                $OrderId = intval(! empty($_GET['OrderId']))?$_GET['OrderId']:0;
		
		switch ($a) {
		case "add":
		  addrec();
		  break;
		case "view":
		  viewrec($OrderId);
		  break;
		case "edit":
		  editrec($recid);
		  break;
		case "del":
		  deleterec($recid);
		  break;
		default:
		  process_order($OrderId);
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

function process_order($OrderId){
	

?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li class="active">Orders</li></ol>

<div id="hideMsg"><?php if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>
<div class="row">
    <div class="col-md-6">
        <?php
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
          <tr><td><b>Total:</b></td> <td>Kes <?php print $OrderTotal+$shipamount;?></td> </tr>  
          <tr><td><b>Order Status:</b></td> <td colspan="2"><div class="form-group">
                      <form method="post" action="">
  <select class="form-control" id="sel1" name="Status">
      <option value="<?php print $Status;?>" selected="selected"><?php if($Status==0){ print 'Pending'; }
      elseif($Status==1){ print 'Processing'; }
      elseif($Status==2){ print 'Completed'; }elseif($Status==3){ print 'On hold'; } else{ print 'Cancelled'; } ?></option>
      <option value="0">Pending</option>
    <option value="1">Processing</option>
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
        
    </div>
     <div class="col-md-6">ssssssss</div>
</div>


<?php 
} 

?>


