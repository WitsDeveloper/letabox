<?php
/*********************************************
Company:	Wits Technologies Ltd
Developer:	Sammy Mwaura Waweru
Mobile:		+254721428276
Email:		sammy@witstechnologies.co.ke
Website:	http://www.witstechnologies.co.ke/
*********************************************/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

// NOTE: Requires PHP version 5 or later
if (version_compare(PHP_VERSION, '5.3.0', '>') ){
	# Load includes
	$incl_dir = "../includes";
	$class_dir = "../classes";
	$logs_dir = "../logs";
	
	include "$incl_dir/config.php";
	require_once("$incl_dir/mysqli.functions.php");
	require_once("$incl_dir/functions.php");
	require_once("admin.functions.php");
	$dummyImagy = 'http://via.placeholder.com/350x400';
} 
else { 
	# PHP version not sufficient
	exit("This system will only run on PHP version 5.3 or higher!\n");
}



$tab = intval(! empty($_GET['tab']))?$_GET['tab']:0;
$menu1 = $menu2 = $menu3 = $menu4 = $menu5 = $menu6 = $menu7 = $menu8 = "";

if(checkLoggedin()){
//Open database connection
$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

switch ($tab) {
	case 0:
	case 1:
break;
	case 2: $menu2 = "active";
break;
	case 3: $menu3 = "active";
break;
	case 4: $menu4 = "active";
break;
	case 5: $menu5 = "active";
break;
	case 6: $menu6 = "active";
break;
	case 7: $menu7 = "active";
break;
	case 8: $menu8 = "active";
break;
}

add_header("admin");
?>
<script>
<!--

//JQuery Functions
$(document).ready(function() {
	
	//Validator
	//$("#validateform").validate();
	
	//Timepicker
	$('.timepicker').timepicker({ 	  
	  'step': 15, 
	  'timeFormat': 'H:i' 
	});
	
	//Timepicker time range
	$('.timepickerrange').timepicker({ 
	  'minTime': '08:00',
      'maxTime': '22:00',
	  'step': 5,
	  'timeFormat': 'H:i' 
	});
	
	//Datepicker
	$( ".datepicker" ).datepicker({
	  autoclose: true,
	  format: 'dd/mm/yyyy',
	  changeMonth: true,
	  changeYear: true
	});
	
	//Datepicker date range
	$('.datepicker-daterange input').each(function() {
	  $(this).datepicker({		  
		  autoclose: true,
		  format: 'dd/mm/yyyy',
		  changeMonth: true,
		  changeYear: true
	  });
	});
	
	$('#myModal').modal('show');
	
});

//Javascript Functions
function comfirmDelete(){
	return confirm('This operation will DELETE the selected records. Are you sure you want to delete?');
}
//
function checkAll(field){
	if(document.view.master.checked == true){
		for(var i=0; i < field.length; i++){
			field[i].checked=true;
		}
	}
	else{
		for(var i=0; i < field.length; i++){
			field[i].checked=false;
		}
	}
}
//-->
</script>

<div class="wrapper">
  
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="<?=SYSTEM_LOGO_URL?>" class="img-responsive"></a>
      </div>
      <!-- /.navbar-header -->
      
      <div class="text-right navbar-top-date"><?=date('l, F j, Y');?> | Logged in as: <strong><?=$_SESSION['sysUsername'];?></strong> </div>
      
      <ul class="nav navbar-top-links navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu dropdown-messages">
                  <?php echo list_message_snapshots($_SESSION['sysEmail']); ?>
                  <li><a class="text-center" href="?tab=4"><strong>Read All Messages</strong><i class="fa fa-angle-right"></i></a></li>
              </ul>
              <!-- /.dropdown-messages -->
          </li>
          <!-- /.dropdown -->
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu dropdown-user">                        
                  <li><a href="?tab=5&task=edit&eid=<?=$_SESSION['sysUserID'];?>"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                  <li class="divider"></li>
                  <li><a href="./?do=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
              </ul>
              <!-- /.dropdown-user -->
          </li>
          <!-- /.dropdown -->
      </ul>
      <!-- /.navbar-top-links -->

      <div class="navbar-default sidebar" role="navigation">
          <div class="sidebar-nav navbar-collapse">
              <ul class="nav" id="side-menu">
                  <li>
                      <a href="?tab=1" class="menu_link <?=$menu1?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                  </li>
                  <li>
                      <a href="?tab=2" class="menu_link <?=$menu2?>"><i class="fa fa-shopping-cart fa-fw"></i> Orders</a>
                  </li>                  
                  <li>
                      <a href="?tab=3" class="menu_link <?=$menu3?>"><i class="fa fa-comments fa-fw"></i> Messages</a>
                  </li>
                  <li>
                      <a href="?tab=4" class="menu_link <?=$menu4?>"><i class="fa fa-users fa-fw"></i> Customers</a>
                  </li>
                  <li>
                      <a href="?tab=5" class="menu_link <?=$menu5?>"><i class="fa fa-users fa-fw"></i> Account</a>
                  </li>
              </ul>
                                  
              
          </div>
          <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->
  </nav>
  
  <!-- page wrapper -->
  <div id="page-wrapper">
	<?php        
    switch ($tab) {
        case 0:
        case 1:
            require_once('staff.dashboard.php');
        break;
        case 2:
            require_once('staff.orders.php');
        break;
        case 3:
            require_once('admin.messages.php');
        break;
        case 4:
            require_once('admin.customers.php');
        break;
		case 5:
            require_once('staff.account.php');
        break;
         case 6:
            require_once('staff.process.php');
        break;
    }
    ?>
  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php
add_footer("admin");

//Close connection
db_close($conn);
}
else{
	//Sorry! Your session has expired!
    $_SESSION['message'] = AttentionMessage("Your session has expired due to inactivity. Try login again.");
	redirect("./?url=".urlencode("staff.php?".$_SERVER['QUERY_STRING']));
}

ob_flush(); 
?>