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
            <div class="huge"><?php echo getAllCustomers(); ?></div>
            <div>Customers</div>
          </div>
        </div>
      </div>
      <a href="?tab=4">
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
            <div class="huge"><?php echo getAllOrders(); ?></div>
            <div>All Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=2">
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
            <div class="huge"><?php echo getAllOrders("Pending"); ?></div>
            <div>Pending Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=2">
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
            <div class="huge"><?php echo getAllOrders("Completed"); ?></div>
            <div>Completed Orders</div>
          </div>
        </div>
      </div>
      <a href="?tab=2">
      <div class="panel-footer"> <span class="pull-left">View Details</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
      </div>
      </a> </div>
  </div>
</div>
<!-- /.row -->