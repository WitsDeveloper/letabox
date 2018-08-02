<script type="text/javascript">
<!--//
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME?> | Dashboard";
//-->
</script>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Dashboard</h1>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->

<div class="row">
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-users fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php //echo getAllCustomers();
            $countquery = $mysqli->query("select COUNT(*) from lbs_customer")  or die('Error : ('. $mysqli->errno .') '. $mysqli->error);;
                            $count = $countquery->fetch_row();
                           print $count[0];?></div>
            <div>Customers</div>
          </div>
        </div>
      </div>
      <a href="?tab=5">
      <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-yellow">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-shopping-cart fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php //echo getAllCustomers();
            $countquery = $mysqli->query("select COUNT(*) from lbs_order")  or die('Error : ('. $mysqli->errno .') '. $mysqli->error);;
                            $count = $countquery->fetch_row();
                           print $count[0];?></div>
            <div>All Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=3">
      <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-truck fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php //echo getAllCustomers();
            $countquery = $mysqli->query("select COUNT(*) from lbs_order WHERE Status=0")  or die('Error : ('. $mysqli->errno .') '. $mysqli->error);;
                            $count = $countquery->fetch_row();
                           print $count[0];?></div>
            <div>Pending Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=3&status=pending">
      <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3"> <i class="fa fa-shopping-bag fa-5x"></i> </div>
          <div class="col-xs-9 text-right">
            <div class="huge"><?php
            $countquery = $mysqli->query("select COUNT(*) from lbs_order WHERE Status=2")  or die('Error : ('. $mysqli->errno .') '. $mysqli->error);;
                            $count = $countquery->fetch_row();
                           print $count[0];?></div>
            <div>Completed Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=3&status=completed">
      <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
</div>
<!-- /.row -->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-dashboard fa-fw"></i> Quick Links </div>
      <!-- /.panel-heading -->
      <div class="panel-body"> 
        <a class="btn btn-primary" href="admin.php?tab=2&task=add">Add Category</a> 
        <a class="btn btn-primary" href="admin.php?tab=5&task=add">Add Customer</a> 
        <a class="btn btn-primary" href="admin.php?tab=3&task=add">Add Order</a> 
        <a class="btn btn-primary" href="admin.php?tab=6&task=add">Add User</a> 
        <a class="btn btn-primary" href="admin.php?tab=7&task=edit">Global Settings</a>
      </div>
      <!-- /.panel-body --> 
    </div>
    <!-- /.panel-default --> 
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->