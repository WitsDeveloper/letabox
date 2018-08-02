<script language="javascript" type="text/javascript">
<!--
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME?> | Customers";
//-->
</script>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Customers</h1>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-users fa-fw"></i> Manage Customers </div>
      <!-- /.panel-heading -->
      <div class="panel-body">

        <ul class="nav nav-tabs cookie">
          <li class="active"><a data-toggle="tab" href="#tabs-1" title="Customers"><span>Customers</span></a></li>
          <li><a data-toggle="tab" href="#tabs-2" title="Announcements"><span>Announcements</span></a></li>
          <li><a data-toggle="tab" href="#tabs-3" title="Login History"><span>Login History</span></a></li>
        </ul>
        <div class="tab-content">
          <div id="tabs-1" class="tab-pane active">
            <!--Begin Forms-->
            <?php
            $a = isset($_GET["task"])?$_GET["task"]:"";
            $recid = intval(! empty($_GET['recid']))?$_GET['recid']:0;            
            $LoginID = !empty($_GET['customerID'])?$_GET['customerID']:"";
            
            switch ($a) {
            case "add":
                new_customer();
              break;
            case "view":
              viewrec($recid);
              break;
            case "edit":
              editrec2($LoginID);
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
          <div id="tabs-2" class="tab-pane">
            <!--Begin Forms-->        
            <?php manage_announcements("Customer"); ?>
            <!--End Forms-->
          </div>
          <div id="tabs-3" class="tab-pane">
            <!--Begin Forms-->
            <?php show_loginhistory(); ?>
            <!--End Forms-->
          </div>
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.panel-body --> 
    </div>
    <!-- /.panel-default --> 
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->

<?php 
function select(){
	
	$res = sql_select();
	$count = sql_getrecordcount();	
	
	if(isset($_GET['enable']) && isset($_GET['eid'])){
		$disabledFlag = intval(! empty($_GET['enable']))?$_GET['enable']:0;
		$editID = intval(! empty($_GET['eid']))?$_GET['eid']:0;
		
		sql_update_status($disabledFlag, $editID);
	}
?>
<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li class="active">Customers</li></ol>

<div id="hideMsg"><?php if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>

<?php showpagenav($pagecount); ?>
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>

<th>Customer ID</th>
<th>Orders</th>
<th>Customer Name</th>
<th>Phone</th>
<th class="no-sort">Email</th>
<th class="no-sort">Active</th>
<th class="no-sort">Actions</th>
</tr>
</thead>
<tbody>
<?php
for ($i = 0; $i < $count; $i++){
	$row = db_fetch_array($res);
?>
<tr>

<td><?=$row["lbs_bill_shipping_id"]?></td>
<td><?php
global $mysqli;
$project_desc12 = $mysqli->query("SELECT COUNT(*) from lbs_order WHERE lbs_bill_shipping_id=".$row["lbs_bill_shipping_id"])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
//$obj_ona12= $project_desc12->fetch_object();
 $get_total_rows = $project_desc12->fetch_row();
print $get_total_rows[0];
 

?></td>
<td><?=$row["Fname"]?></td>
<td><?=$row["Phone"]?></td>
<td><?="<a href=\"staff.php?tab=4&amp;task=add&amp;email=".$row['Email']."\" title=\"Send Email\"><img border=\"0\" src=\"".IMAGE_FOLDER."/icons/mail.png\" height=\"22\" width=\"22\" alt=\"Send\"></a>";?></td>
<?php
if($row['disabledFlag'] == 0){
	echo "<td align=\"center\"><a href=\"staff.php?tab=5&enable=1&eid=".$row['UID']."\" title=\"Click to disable ".$row['CustomerName']."\"><img border=\"0\" src=\"".IMAGE_FOLDER."/icons/yes.png\" height=\"12\" width=\"12\" alt=\"Disable ".$row['CustomerName']."\"></a></td>";
}else{
	echo "<td align=\"center\"><a href=\"staff.php?tab=5&enable=0&eid=".$row['UID']."\" title=\"Click to enable ".$row['CustomerName']."\"><img border=\"0\" src=\"".IMAGE_FOLDER."/icons/no.png\" height=\"12\" width=\"12\" alt=\"Enable ".$row['CustomerName']."\"></a></td>";
}
?>
<td><a href="staff.php?tab=5&task=view&recid=<?=$i ?>&customerID=<?=$row['lbs_bill_shipping_id'] ?>">Manage</a> | <a href="staff.php?tab=5&task=edit&recid=<?=$i ?>&customerID=<?=$row['lbs_bill_shipping_id'] ?>">Edit</a> 
<?php if( isSuperAdmin() || isSystemAdmin() ) { ?>
| <a href="staff.php?tab=5&task=del&recid=<?=$i ?>&customerID=<?=$row['lbs_bill_shipping_id'] ?>">Delete</a>
<?php } ?>
</td>
</tr>        
<?php
}
db_free_result($res);
?>
</tbody>
</table>
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
function showrowdetailed($row, $recid){
global $conn;
?>
<div id="hideMsg"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></div>

<div class="head-details">
<h2 class="text-uppercase text-primary"><?=$row["CustomerName"]; ?> <span class="small text-muted"><?=$row["CustomerID"]; ?></span></h2>
</div>

<div id="adv-tab-container">
  <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#sub-tabs-1" title="<?=SYSTEM_SHORT_NAME?> | Customer Details">Customer Details</a></li>
      <li><a data-toggle="tab" href="#sub-tabs-2" title="<?=SYSTEM_SHORT_NAME?> | Customer Orders">Customer Orders</a></li>
  </ul>
  <div class="tab-content">
    <!--sub-tabs-1-->
    <div id="sub-tabs-1" class="tab-pane active">
      <p>&nbsp;</p>
      <div class="row">
        <div class="col-md-6">
          <table class="table table-bordered table-striped">
          <tr><td><strong>Portal Status:</strong> </td><td><?=$row["Status"]; ?></td></tr>
          <tr><td><strong>Full Name:</strong> </td><td>   <?=$row["Fname"]; ?></td></tr>
          <tr><td><strong>Registration Date:</strong> </td><td>   <?=fixdatelong($row["regDate"]); ?></td></tr>
          <tr><td><strong>Orders:</strong> </td><td><?php 
          $user_d=$row["lbs_bill_shipping_id"];
          global $mysqli;
          $countquery = $mysqli->query("select COUNT(*) from lbs_order WHERE lbs_bill_shipping_id=".$row["lbs_bill_shipping_id"]);
           $count = $countquery->fetch_row();
           print $count[0];
          
          ?></td></tr>        
          <tr><td><strong>Email:</strong> </td><td><a href="staff.php?tab=4&task=add&email=<?=$row["Email"]; ?>" title="Send Email"><?=$row["Email"]; ?></a></td></tr>
          <tr><td><strong>Phone:</strong> </td><td><?=$row["Phone"]; ?></td></tr>
          
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-bordered table-striped">
         <tr><td valign="top"><strong>Street Address :</strong> </td><td><?=decode($row["Address1"]); ?></td></tr>
          <tr><td><strong>Country:</strong> </td><td><?=get_country($row["Country"]); ?></td></tr>
          <tr><td><strong>City/Town:</strong> </td><td><?=$row["City"]; ?></td></tr>
         

          <tr><td><strong>Zip/Postal Code:</strong> </td><td><?=$row["Zcode"]; ?></td></tr>
   
          </table>
        </div>
      </div>
    </div>
    <!--sub-tabs-2-->
    <div id="sub-tabs-2" class="tab-pane">
      <p>&nbsp;</p>
	  <?php
             global $mysqli;
    
     $CustomerID = isset($_GET['customerID']) ? $_GET['customerID'] : '';
     $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE lbs_bill_shipping_id='$CustomerID'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   print '<ul>';
  if($project_desc1->num_rows<1){
   print '<li> No records</li>';    
  }
  else{
while($obj_ona1= $project_desc1->fetch_object())
     {
print '<li> Order ID# '.$obj_ona1->OrderId.'</li>'; 
     }
  }
      print '</ul>';
          
    
      $OrderIDs = explode(",", $row['Orders']);
      
      reset($OrderIDs);
      if(!empty($OrderIDs)){}else{
          echo "<p>This customer has not made any orders.</p>";
      }
      ?>
    </div>
    
    <div class="quick-nav btn-group">
      <a class="btn btn-default" href="staff.php?tab=5&task=add"><i class="fa fa-file-o fa-fw"></i>Add Customer</a>
      <a class="btn btn-default" href="staff.php?tab=5&task=edit&recid=<?=$recid ?>&customerID=<?=$row['lbs_bill_shipping_id'] ?>"><i class="fa fa-pencil-square-o fa-fw"></i>Edit Customer</a>
      <a class="btn btn-default" href="staff.php?tab=5&task=del&recid=<?=$recid ?>&customerID=<?=$row['lbs_bill_shipping_id'] ?>"><i class="fa fa-trash-o fa-fw"></i>Delete Customer</a>
    </div>
    
  </div>
</div>

<?php } ?>
<?php 
//function showroweditor($row, $iseditmode, $ERRORS){
global $a;
function new_customer(){
    global $mysqli;
?>
<p class="text-center lead"><strong><?=strtoupper($a)?> CUSTOMER DETAILS</strong></p>
<p class="text-center small"><span class="text-danger">FIELDS MARKED WITH ASTERISKS (*) ARE REQUIRED</span></p>

<h2>Customer Information</h2>
<form method="post" enctype="multipart/form-data" action="" >
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
    <label for="">Full Name: <span class="text-danger">*</span></label>
    <input type="text" value="" name="Fname" class="form-control required" />
    </div>
  </div>
 <div class="col-md-4">
    <div class="form-group">
    <label for="">Phone: <span class="text-danger">*</span></label>
    <input  type="text" value="" name="Phone" class="form-control required" />
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
    <label for="">Email: <span class="text-danger">*</span></label>
    <input  type="text" value="" name="Email" class="form-control required email" />
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">

  <div class="form-group">
  <label for="">Address :</label>
  <textarea name="Address1" class="form-control" rows="4"></textarea>
  </div>
  
 
  
  <div class="form-group">
  <label for="">City/Town: <span class="text-danger">*</span></label>
  <input  type="text" value="" name="City" class="form-control required" />
  </div>
  
  <div class="form-group">
  <label for="">Zip/Postal Code:</label>
  <input type="text" value="" name="Zcode" class="form-control" maxlength="5" />
  </div>
  
  <div class="form-group">
  <label for="">Country: <span class="text-danger">*</span></label>
  <select name="Country" class="form-control">
  
  <option value="None">--Select--</option>
  <?php
  foreach(list_countries() as $k => $v){
      
      if($v == $obj_ona1->Country){
          $select = 'selected="selected"';
      }
      else{
          $select = "";
      }
      echo "<option $select value=\"$v\">$v</option>";
  }
  ?>
  </select>
  </div>

  </div>
  <div class="col-md-6">

  <h2>Login Information</h2>
  <p class="small">Required to login to the customer portal</p>
  
  <!--<div class="form-group">
  <label for="">Customer ID: <span class="text-danger">*</span></label>
  <input type="email" value="" name="Email" class="form-control required" />
  </div>-->
  
  <div class="form-group">
  <label for="">Assign Password:</label>
  <input type="password" value="" name="Password" class="form-control" /><span class="text-danger"></span>
  </div>
  
  <div class="form-group">
  <label for="">Verify Password:</label>
  <input type="password" value="" name="VerifyPass" class="form-control" /><span class="text-danger"></span>
  </div>    

  </div>
</div>
    <input type="hidden" name="sql" value="insert" />

<p class="text-center">
<input class="btn btn-primary" type="submit" name="add_customerr" value="Save" />
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='staff.php?tab=5'" />
</p>
</form>

<?php 
if(isset($_POST['add_customerr'])){
//print '<script type="text/javascript">'.'alert("error.");'.'</script>';
    global $mysqli;
	 $null='null';
   $null_int='0';
   $null_date='0000-00-00 00:00:00'; 
  
                          //shipping & billing details        
                     $OrderID_Cart =$null_int; 
                        $Fname = $_POST["Fname"]; 
                        $Lname = $null; 
                        $Company= $null; 
                        $Country = $null; 
                        $Address1 = $_POST["Address1"]; 
                        $Address2= $null; 
                        $City= $_POST["City"]; 
                        $State= $null; 
                        $Zcode = $_POST["Zcode"]; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"]; 
                        $encryptedPassword = md5(@$_POST["Password"]);  
                        $regDate=date("Y-m-d h:i:s");
                        $my_kart= $_POST["my_kart"]; 
                        $my_total= $_POST["my_total"];                        
                                                    
$query = "INSERT INTO lbs_customer (OrderID_Cart,Fname,Lname,Company,Country,Address1,Address2,City,State,Zcode,Phone,Email,Password,regDate,oauth_provider,"
        . "oauth_uid,date_modified) VALUES(?, ? ,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);

$statement->bind_param('issssssssssssssis', $OrderID_Cart,$Fname,$Lname,$Company,$Country,$Address1,$Address2,$City,$State,$Zcode,$Phone,$Email,$encryptedPassword,$regDate,$null,$null_date,$null);
//;
if(!$statement->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
else{
$_SESSION['MSG'] = ConfirmMessage("New customer has been added successfully");   
     //print '<script type="text/javascript">'.'alert("Order Placed.");'.'</script>';
     redirect("staff.php?tab=5");
}
            

	

    
}


      } ?>

<?php
function showpagenav() {
?>
<div class="quick-nav btn-group">
<a class="btn btn-primary" href="staff.php?tab=5&task=add">Add Customer</a>
<a class="btn btn-default" href="staff.php?tab=5&task=reset">Reset Filters</a>
</div>
<?php } ?>

<?php function showrecnav($a, $recid, $count) { ?>
<div class="quick-nav btn-group">
<a class="btn btn-default" href="staff.php?tab=5"><i class="fa fa-undo fa-fw"></i> Back to Customers</a>
<?php if ($recid > 0) { ?>
<a class="btn btn-default" href="staff.php?tab=5&task=<?=$a ?>&recid=<?=$recid - 1 ?>"><i class="fa fa-arrow-left fa-fw"></i> Prior Record</a>
<?php } if ($recid < $count - 1) { ?>
<a class="btn btn-default" href="staff.php?tab=5&task=<?=$a ?>&recid=<?=$recid + 1 ?>"><i class="fa fa-arrow-right fa-fw"></i> Next Record</a>
<?php } ?>
</div>
<?php } ?>

<?php 
function viewrec($recid){
	
	$res = sql_select();
	$count = sql_getrecordcount();
	db_data_seek($res, $recid);
	$row = db_fetch_array($res); 
	
	if($row['disabledFlag'] == 0){
		$row["Status"] = "Enabled";
	}else{
		$row["Status"] = "Disabled";
	}	 
	?>
	<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">View Customer</li></ol>
	<?php 
	showrecnav("view", $recid, $count);
	showrowdetailed($row, $recid);
	db_free_result($res);
} 
?>

<?php 
function addrec() { 
  	global $class_dir,$conn;
	require_once("$class_dir/class.validator.php3");
	
	// Variables
	$ERRORS = array();
	$FIELDS = array();
	$ERR = 'id="highlight"';//Error highlighter
	
	// Commands
	if(isset($_POST["Addxx"])){
		// Customer info		
		$FIELDS['FName'] = secure_string(ucwords($_POST['FName']));
		$FIELDS['MName'] = secure_string(ucwords($_POST['MName']));
		$FIELDS['LName'] = secure_string(ucwords($_POST['LName']));
		$FIELDS['Gender'] = secure_string($_POST['Gender']);
		$FIELDS['Email'] = secure_string(strtolower($_POST['Email']));
		$FIELDS['DOB'] = secure_string($_POST['DOB']);
		$FIELDS['Phone'] = secure_string($_POST['Phone']);
		$FIELDS['Address1'] = secure_string($_POST['Address1']);
		$FIELDS['Address2'] = secure_string($_POST['Address2']);
		$FIELDS['City'] = secure_string($_POST['City']);
		$FIELDS['State'] = secure_string($_POST['State']);
		$FIELDS['PostCode'] = secure_string($_POST['PostCode']);
		$FIELDS['Country'] = secure_string($_POST['Country']);
		$FIELDS['CustomerID'] = secure_string(whitespace_trim(strtoupper($_POST['CustomerID'])));
		$FIELDS['Password'] = isset($_POST['Password'])?secure_string($_POST['Password']):"";
		$FIELDS['VerifyPass'] = isset($_POST['VerifyPass'])?secure_string($_POST['VerifyPass']):"";
		$FIELDS['EncryptPass'] = hashedPassword($FIELDS['VerifyPass']);
		$FIELDS['RegDate'] = date('Y-m-d');
		
		// Validator data
		$check = new validator();
		// validate entry		
		// validate "FName" field
		if(!$check->is_String($FIELDS['FName']))
		$ERRORS['FName'] = $ERR;
		// validate "LName" field
		if(!$check->is_String($FIELDS['LName']))
		$ERRORS['LName'] = $ERR;
		// validate "Email" field
		if(!$check->is_email($FIELDS['Email']))
		$ERRORS['Email'] = $ERR;
		// validate "DOB" field
		if(!empty($FIELDS['DOB'])){
			$SplitDate = explode('/', $FIELDS['DOB']);// Split date by '/'
			//checkdate($month, $day, $year)
			if(is_date($SplitDate[0],$SplitDate[1],$SplitDate[2])){
				$FIELDS['dbDOB'] = db_fixdatetime($FIELDS['DOB']);// YYYY-dd-mms
			}else{
				$ERRORS['DOB'] = $ERR;
			}
		}
		// validate "Phone" field
		if(!$check->is_phone($FIELDS['Phone']))
		$ERRORS['Phone'] = $ERR;
		// validate "City" field
		if(!$check->is_String($FIELDS['City']))
		$ERRORS['City'] = $ERR;
		// validate "PostCode" field
		if(!isset($FIELDS['PostCode']) && !$check->is_zipcode($FIELDS['PostCode']))
		$ERRORS['PostCode'] = $ERR;
		// validate "Country" field
		if($FIELDS['Country'] == "None")
		$ERRORS['Country'] = $ERR;
		// validate "CustomerID" field
		if(empty($FIELDS['CustomerID']))
		$ERRORS['CustomerID'] = $ERR;
		// validate "Password" field
		if(!empty($FIELDS['Password'])){
			// validate "Password" field
			if(!$check->is_password($FIELDS['Password']))
			$ERRORS['Password'] = "Password must be at least 7 letters mixed with digits and symbols";
			// validate "VerifyPass" field
			if(!$check->cmp_string($FIELDS['VerifyPass'],$FIELDS['Password']))
			$ERRORS['VerifyPass'] = "Passwords entered do not match";
		}
		
		
		//Check if this customer ID is already registered	
		$checkDuplicateSql = sprintf("SELECT `CustomerID` FROM `".DB_PREFIX."customer` WHERE `CustomerID` = '%s'", $FIELDS['CustomerID']);
		//check if any results were returned
		if(checkDuplicateEntry($checkDuplicateSql)){
			$ERRORS['CustomerID'] = "This customer ID ".$FIELDS['CustomerID']." is already taken.";
		}
		
		//Check if this email address is already registered	
		$checkDuplicateSql2 = sprintf("SELECT `Email` FROM `".DB_PREFIX."customer` WHERE `Email` = '%s'", $FIELDS['Email']);
		//check if any results were returned
		if(checkDuplicateEntry($checkDuplicateSql2)){
			$ERRORS['Email'] = "This email ".$FIELDS['Email']." is already attached to another account.";
		}
		
		// check for errors
		if(sizeof($ERRORS) > 0){
			$ERRORS['MSG'] = ErrorMessage("PLEASE CORRECT HIGHLIGHTED FIELDS!");
		}
		else{
			sql_insert($FIELDS);
		}
	}
		
	$row["FName"] = !empty($FIELDS['FName'])?$FIELDS['FName']:"";
	$row["MName"] = !empty($FIELDS['MName'])?$FIELDS['MName']:"";
	$row["LName"] = !empty($FIELDS['LName'])?$FIELDS['LName']:"";
	$row["Gender"] = !empty($FIELDS['Gender'])?$FIELDS['Gender']:"";
	$row["Email"] = !empty($FIELDS['Email'])?$FIELDS['Email']:"";
	$row["DOB"] = !empty($FIELDS['DOB'])?$FIELDS['DOB']:"";
	$row["Phone"] = !empty($FIELDS['Phone'])?$FIELDS['Phone']:"";
	$row["Address1"] = !empty($FIELDS['Address1'])?$FIELDS['Address1']:"";
	$row["Address2"] = !empty($FIELDS['Address2'])?$FIELDS['Address2']:"";
	$row["City"] = !empty($FIELDS['City'])?$FIELDS['City']:"";
	$row["State"] = !empty($FIELDS['State'])?$FIELDS['State']:"";
	$row["PostCode"] = !empty($FIELDS['PostCode'])?$FIELDS['PostCode']:"";
	$row["Country"] = !empty($FIELDS['Country'])?$FIELDS['Country']:"KE";
	$row["CustomerID"] = !empty($FIELDS['CustomerID'])?$FIELDS['CustomerID']:"";
?>
<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">Add Customer</li></ol>

<a class="btn btn-default" href="staff.php?tab=5"><i class="fa fa-undo fa-fw"></i> Back to Customers</a>

<p class="text-center"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></p>
<!--<form id="validateform" enctype="multipart/form-data" action="staff.php?tab=5&task=add" method="post">
<input type="hidden" name="sql" value="insert" />
<?php
//showroweditor($row, false, $ERRORS);
?>
<p class="text-center">
<input class="btn btn-primary" type="submit" name="Add" value="Save" />
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='staff.php?tab=5'" />
</p>
</form>-->
<?php
new_customer();
                } ?>

<?php 
function editrec2($LoginID){
    global $a;
    global $mysqli;
                                   
      $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$LoginID'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
       $obj_ona1= $project_desc1->fetch_object(); 
    ?>
<p class="text-center lead"><strong><?=strtoupper($a)?> CUSTOMER DETAILS</strong></p>
<p class="text-center small"><span class="text-danger">FIELDS MARKED WITH ASTERISKS (*) ARE REQUIRED</span></p>

<h2>Customer Information</h2>
<form method="post" enctype="multipart/form-data" action="" >
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
    <label for="">Full Name: <span class="text-danger">*</span></label>
    <input type="text" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" name="Fname" class="form-control required" />
    </div>
  </div>
 <div class="col-md-4">
    <div class="form-group">
    <label for="">Phone: <span class="text-danger">*</span></label>
    <input  type="text" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" name="Phone" class="form-control required" />
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
    <label for="">Email: <span class="text-danger">*</span></label>
    <input  type="text" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" name="Email" class="form-control required email" />
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">

  <div class="form-group">
  <label for="">Address :</label>
  <textarea name="Address1" class="form-control" rows="4"><?php print $obj_ona1->Address1 ? $obj_ona1->Address1 : ''; ?></textarea>
  </div>
  
 
  
  <div class="form-group">
  <label for="">City/Town: <span class="text-danger">*</span></label>
  <input  type="text" value="<?php print $obj_ona1->City ? $obj_ona1->City : ''; ?>" name="City" class="form-control required" />
  </div>
  
  <div class="form-group">
  <label for="">Zip/Postal Code:</label>
  <input type="text" value="<?php print $obj_ona1->Zcode ? $obj_ona1->Zcode : ''; ?>" name="Zcode" class="form-control" maxlength="5" />
  </div>
  
  <div class="form-group">
  <label for="">Country: <span class="text-danger">*</span></label>
  <select name="Country" class="form-control">

  <?php if($obj_ona1->Country==='null'){?>
        <option value="None">--Select--</option>
  ><?php } else{ ?>
  
    <option value="<?php print $obj_ona1->Country; ?>" selected="selected"><?php print $obj_ona1->Country; ?></option
  <?php } ?>
  <?php
  foreach(list_countries() as $k => $v){
      if($v == $row['Country']){
          $select = 'selected="selected"';
      }
      else{
          $select = "";
      }
      echo "<option $select value=\"$v\">$v</option>";
  }
  ?>
  </select>
  </div>

  </div>
  <div class="col-md-6">

  <h2>Login Information</h2>
  <p class="small">Required to login to the customer portal</p>
  
  <!--<div class="form-group">
  <label for="">Customer ID: <span class="text-danger">*</span></label>
  <input type="email" value="" name="Email" class="form-control required" />
  </div>-->
  
  <div class="form-group">
  <label for="">New Password:</label>
  <input type="password" value="" name="Password" class="form-control" /><span class="text-danger"></span>
  </div>
  
  <div class="form-group">
  <label for="">Verify Password:</label>
  <input type="password" value="" name="VerifyPass" class="form-control" /><span class="text-danger"></span>
  </div>    

  </div>
</div>
    <input type="hidden" name="sql" value="insert" />

<p class="text-center">
<input class="btn btn-primary" type="submit" name="edit_customerr" value="Save Changes" />
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='staff.php?tab=5'" />
</p>
</form>

    
 <?php   
  if(isset($_POST["edit_customerr"])){ 
      global $mysqli;
      global $a;
    $customer_id= $LoginID; 
                        $Fname = $_POST["Fname"];                         
                        $Country = $_POST["Country"]; 
                        $Address1 = $_POST["Address1"]; 
                        
                        $City= $_POST["City"];                         
                        $Zcode = $_POST["Zcode"]; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"]; 
                        $regDate=date("Y-m-d h:i:s");                        
                        //update
    $statement = $mysqli->query("UPDATE lbs_customer SET Fname='$Fname',Country='$Country',Address1='$Address1',City='$City',"
            . "Zcode='$Zcode',Email='$Email',Phone='$Phone',date_modified='$regDate'"
         . " WHERE lbs_bill_shipping_id='$customer_id'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
    
   //$msg='edited';
    	$_SESSION['MSG'] = ConfirmMessage("Customer details edited successfully");   
     //print '<script type="text/javascript">'.'alert("Order Placed.");'.'</script>';
     redirect("staff.php?tab=5");
}
}

function editrec($recid){
  	global $class_dir;
	require_once("$class_dir/class.validator.php3");
	
	// Variables
	$ERRORS = array();
	$FIELDS = array();
	$ERR = 'id="highlight"';//Error highlighter
	
	// Commands
	if(isset($_POST["Edit"])){
		// Customer info		
		$FIELDS['FName'] = secure_string(ucwords($_POST['FName']));
		$FIELDS['MName'] = secure_string(ucwords($_POST['MName']));
		$FIELDS['LName'] = secure_string(ucwords($_POST['LName']));
		$FIELDS['Gender'] = secure_string($_POST['Gender']);
		$FIELDS['Email'] = secure_string($_POST['Email']);
		$FIELDS['DOB'] = secure_string($_POST['DOB']);
		$FIELDS['Phone'] = secure_string($_POST['Phone']);
		$FIELDS['Address1'] = secure_string($_POST['Address1']);
		$FIELDS['Address2'] = secure_string($_POST['Address2']);
		$FIELDS['City'] = secure_string($_POST['City']);
		$FIELDS['State'] = secure_string($_POST['State']);
		$FIELDS['PostCode'] = secure_string($_POST['PostCode']);
		$FIELDS['Country'] = secure_string($_POST['Country']);
		$FIELDS['CustomerID'] = secure_string(whitespace_trim(strtoupper($_POST['CustomerID'])));
		$FIELDS['Password'] = isset($_POST['Password'])?secure_string($_POST['Password']):"";
		$FIELDS['VerifyPass'] = isset($_POST['VerifyPass'])?secure_string($_POST['VerifyPass']):"";
		$FIELDS['EncryptPass'] = hashedPassword($FIELDS['VerifyPass']);
		$FIELDS['Token'] = md5(time());
		
		// Validator data
		$check = new validator();
		// validate entry		
		// validate "FName" field
		if(!$check->is_String($FIELDS['FName']))
		$ERRORS['FName'] = $ERR;
		// validate "LName" field
		if(!$check->is_String($FIELDS['LName']))
		$ERRORS['LName'] = $ERR;
		// validate "Email" field
		if(!$check->is_email($FIELDS['Email']))
		$ERRORS['Email'] = $ERR;
		// validate "DOB" field
		if(!empty($FIELDS['DOB'])){
			$SplitDate = explode('/', $FIELDS['DOB']);// Split date by '/'
			//checkdate($month, $day, $year)
			if(checkdate($SplitDate[0],$SplitDate[1],$SplitDate[2])){
				$FIELDS['dbDOB'] = db_fixdatetime($FIELDS['DOB']);// YYYY-dd-mms
			}else{
				$ERRORS['DOB'] = $ERR;
			}
		}
		// validate "Phone" field
		if(!$check->is_phone($FIELDS['Phone']))
		$ERRORS['Phone'] = $ERR;
		// validate "City" field
		if(!$check->is_String($FIELDS['City']))
		$ERRORS['City'] = $ERR;
		// validate "PostCode" field
		if(!isset($FIELDS['PostCode']) && !$check->is_zipcode($FIELDS['PostCode']))
		$ERRORS['PostCode'] = $ERR;
		// validate "Country" field
		if($FIELDS['Country'] == "None")
		$ERRORS['Country'] = $ERR;
		// validate "CustomerID" field
		if(empty($FIELDS['CustomerID']))
		$ERRORS['CustomerID'] = $ERR;
		// validate "Password" field
		if(!empty($FIELDS['Password'])){
			// validate "Password" field
			if(!$check->is_password($FIELDS['Password']))
			$ERRORS['Password'] = "Password must be at least 7 letters mixed with digits and symbols";
			// validate "VerifyPass" field
			if(!$check->cmp_string($FIELDS['VerifyPass'],$FIELDS['Password']))
			$ERRORS['VerifyPass'] = "Passwords entered do not match";
		}
		
		// check for errors
		if(sizeof($ERRORS) > 0){
			$ERRORS['MSG'] = ErrorMessage("PLEASE CORRECT HIGHLIGHTED FIELDS!");
		}
		else{
			sql_update($FIELDS);
		}
  	}
	
	$res = sql_select();
	$count = sql_getrecordcount();
	db_data_seek($res, $recid);
	$row = db_fetch_array($res);
		
	$row["FName"] = !empty($FIELDS['FName'])?$FIELDS['FName']:$row['FName'];
	$row["MName"] = !empty($FIELDS['MName'])?$FIELDS['MName']:$row['MName'];
	$row["LName"] = !empty($FIELDS['LName'])?$FIELDS['LName']:$row['LName'];
	$row["CustomerName"] = !empty($FIELDS['CustomerName'])?$FIELDS['CustomerName']:$row['CustomerName'];
	$row["Gender"] = !empty($FIELDS['Gender'])?$FIELDS['Gender']:$row['Gender'];
	$row["Email"] = !empty($FIELDS['Email'])?$FIELDS['Email']:$row['Email'];
	$row["DOB"] = !empty($FIELDS['DOB'])?$FIELDS['DOB']:fixdatepicker($row['DOB']);
	$row["Phone"] = !empty($FIELDS['Phone'])?$FIELDS['Phone']:$row['Phone'];
	$row["Address1"] = !empty($FIELDS['Address1'])?$FIELDS['Address1']:$row['Address1'];
	$row["Address2"] = !empty($FIELDS['Address2'])?$FIELDS['Address2']:$row['Address2'];
	$row["City"] = !empty($FIELDS['City'])?$FIELDS['City']:$row['City'];
	$row["State"] = !empty($FIELDS['State'])?$FIELDS['State']:$row['State'];
	$row["PostCode"] = !empty($FIELDS['PostCode'])?$FIELDS['PostCode']:$row['PostCode'];
	$row["Country"] = !empty($FIELDS['Country'])?$FIELDS['Country']:$row['Country'];
	$row["CustomerID"] = !empty($FIELDS['CustomerID'])?$FIELDS['CustomerID']:$row['CustomerID'];
?>
<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">Edit Customer</li></ol>
<?php showrecnav("edit", $recid, $count); ?>
<form id="validateform" enctype="multipart/form-data" action="staff.php?tab=5&task=edit&recid=<?=$recid?>" method="post">
<p class="text-center"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></p>
<input type="hidden" name="sql" value="update" />
<input type="hidden" name="eid" value="<?=$row["UID"] ?>" />
<?php showroweditor($row, true, $ERRORS); ?>
<p class="text-center">
<input class="btn btn-primary" type="submit" name="Edit" value="Save" />
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='staff.php?tab=5'" />
</p>
</form>
<?php
db_free_result($res);
} 
?>

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
		<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">Delete Customer</li></ol>
		<?php showrecnav("del", $recid, $count); ?>
		<form action="staff.php?tab=5&task=del&recid=<?=$recid?>" method="post">
		<input type="hidden" name="sql" value="delete" />
		<input type="hidden" name="eid" value="<?=$row["UID"] ?>" />
		<?php showrow($row, $recid) ?>
		<strong>Are you sure you want to delete this record? </strong><div class="btn-group"><input class="btn btn-primary" type="submit" name="Delete" value="Yes" /> <input class="btn btn-default" type="button" name="Ignore" value="No" onclick="javascript:history.go(-1)" /></div>
		</form>
		<?php
		db_free_result($res);
	}else{
		echo ErrorMessage("You do not have the privilege to delete customers. Please contact the system admin for details.");
	}
}
?>

<?php
function manage_announcements($UserType){
	global $conn;
	global $_POST, $_GET;
	
	// Variables
	$ERRORS = array();
	$subtab = isset($_GET["subtab"])?$_GET["subtab"]:"";
	$action = isset($_GET["action"])?$_GET["action"]:"view";
	$action = strtolower($action);
	
	$editID = intval(! empty($_GET['eid']))?$_GET['eid']:0;
	
	$Title = "";
	$Announcement = "";
	$PublishFrom = "";
	$PublishTo = "";
	
	switch ($action) {
		case "add":
		case "edit":
			if(isset($_POST["Save"])){
				$Title = secure_string($_POST['Title']);
				$Announcement = secure_string($_POST['Announcement']);
				$PublishFrom = secure_string($_POST['PublishFrom']);
				$PublishTo = secure_string($_POST['PublishTo']);
				
				// Validate Fields
				// validate "Announcement" field
				if(empty($Announcement))
				$ERRORS['Announcement'] = "Announcement cannot be left empty";
				// validate "PublishFrom" field
				if(!empty($PublishFrom)){
					$SplitDate = explode('/', $PublishFrom);// Split date by '/'
					//checkdate($month, $day, $year)
					if(checkdate($SplitDate[0],$SplitDate[1],$SplitDate[2])){
						$dbPublishFrom = db_fixdatetime($PublishFrom);// YYYY-dd-mms
					}else{
						$ERRORS['PublishFrom'] = "A valid date is required";
					}
				}
				// validate "PublishTo" field
				if(!empty($PublishTo)){
					$SplitDate = explode('/', $PublishTo);// Split date by '/'
					//checkdate($month, $day, $year)
					if(checkdate($SplitDate[0],$SplitDate[1],$SplitDate[2])){
						$dbPublishTo = db_fixdatetime($PublishTo);// YYYY-dd-mms
					}else{
						$ERRORS['PublishTo'] = "A valid date is required";
					}
				}
				
				// check for errors
				if(sizeof($ERRORS) > 0){			
					$ERRORS['MSG'] = ErrorMessage("PLEASE CORRECT HIGHLIGHTED FIELDS!");
				}else{
					if($action == "add"){
						//Add announcement
						$sqlAdd = sprintf("INSERT INTO `".DB_PREFIX."announcements` (`Title`, `Announcement`, `UserType`, `PublishFrom`, `PublishTo`) VALUES ('%s', '%s', '%s', '%s', '%s')", $Title, $Announcement, $UserType, $dbPublishFrom, $dbPublishTo);
						db_query($sqlAdd,DB_NAME,$conn);
						//Check if added
						if(db_affected_rows($conn)){
							$_SESSION['MSG'] = ConfirmMessage("Announcement added successfully");
							//Redirect
							redirect("staff.php?tab=5#tabs-2");
						}else{
							$ERRORS['MSG'] = ErrorMessage("Failed to add new announcement. Please try again later.");
						}
					}else{
						//Update record
						$sqlUpdate = sprintf("UPDATE `".DB_PREFIX."announcements` SET `Title`='%s', `Announcement`='%s', `PublishFrom`='%s', `PublishTo`='%s' WHERE `UID` = '%s'", $Title, $Announcement, $dbPublishFrom, $dbPublishTo, $editID);
						db_query($sqlUpdate,DB_NAME,$conn);
						//Check if updated
						if(db_affected_rows($conn)){
							$_SESSION['MSG'] = ConfirmMessage("Announcement updated successfully");
							//Redirect
							redirect("staff.php?tab=5#tabs-2");
						}else{
							$ERRORS['MSG'] = WarnMessage("No changes made!");
						}
					}
				}
			}
			
			if(!empty($editID)){
				//Get data
				$resGetSql = sprintf("SELECT `Title`,`Announcement`,`PublishFrom`,`PublishTo` FROM `".DB_PREFIX."announcements` WHERE `UID` = %d LIMIT %d;", $editID, 1);
				//run the query
				$result = db_query($resGetSql,DB_NAME,$conn);
				$rowAnnounce = db_fetch_array($result);
				
				$Title = !empty($Title)?$Title:$rowAnnounce['Title'];
				$Announcement = !empty($Announcement)?$Announcement:$rowAnnounce['Announcement'];
				$PublishFrom = !empty($PublishFrom)?$PublishFrom:fixdatepicker($rowAnnounce['PublishFrom']);
				$PublishTo = !empty($PublishTo)?$PublishTo:fixdatepicker($rowAnnounce['PublishTo']);
			}
			?>
            <ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li><a href="staff.php?tab=5#tabs-2">Announcements</a></li><li class="active"><?=ucwords($action)?> Announcements</li></ol>
            <p class="text-center"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></p>
            <form id="validateform" enctype="multipart/form-data" action="staff.php?tab=5&subtab=announcements&action=<?=$action?>&eid=<?=$editID?>#tabs-2" method="post">
            <table align="center" border="0" cellpadding="1" cellspacing="1">
            <tr><td style="text-align:center" colspan="2"><strong><?=strtoupper($action)?> ANNOUNCEMENT</strong></td></tr>
            <tr><td style="text-align:center" colspan="2"><span class="text-danger"><strong>FIELDS MARKED WITH ASTERISKS (*) ARE REQUIRED</strong></span></td></tr>
            <tr>
            <td align="right">Title:</td>
            <td><input type="text" value="<?=$Title; ?>" name="Title" /></td>
            </tr>
            <tr>
            <td align="right" valign="top">Announcement: <span class="text-danger">*</span></td>
            <td><textarea name="Announcement" cols="40" rows="5" class="required"><?=$Announcement; ?></textarea><br /><span class="text-danger"><?=$ERRORS['Announcement'];?></span></td>
            </tr>
            <tr>
            <td align="right">Publish From: <span class="text-danger">*</span></td>
            <td><input class="datepickerfrom required" type="text" value="<?=$PublishFrom; ?>" name="PublishFrom" /><span class="text-danger"><?=$ERRORS['PublishFrom'];?></span></td>
            </tr>
            <tr>
            <td align="right">Publish To: <span class="text-danger">*</span></td>
            <td><input class="datepickerto required" type="text" value="<?=$PublishTo; ?>" name="PublishTo" /><span class="text-danger"><?=$ERRORS['PublishTo'];?></span></td>
            </tr>
            <tr>
            <td style="text-align:center" colspan="2"><input class="btn btn-primary" type="submit" name="Save" value="Save" /> <input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='staff.php?tab=5#tabs-2'" /></td>
            </tr>
            </table>
            </form>
            <?php
		break;
		default:
		//Delete selected announcements
		if(isset($_POST['DELETE']) && isset($_POST['announcementIDs']) && isSuperAdmin()){	
			foreach($_POST['announcementIDs'] as $selectedID){
				$sqlDelete = sprintf("DELETE FROM `".DB_PREFIX."announcements` WHERE `UID` = %d LIMIT %d", intval($selectedID), 1);
				//Run query
				db_query($sqlDelete,DB_NAME,$conn);
			}
			$_SESSION['MSG'] = ConfirmMessage("Selected announcements have been deleted!");
		}
		//Get announcements
		$resSql = sprintf("SELECT `UID` FROM `".DB_PREFIX."announcements` WHERE `UserType` = '%s' AND `deletedFlag` = 0", $UserType);
		//run the query
		$res = db_query($resSql,DB_NAME,$conn);	
		$ann_num_rows = db_num_rows($res);
		
		$resLimitedSql = sprintf("SELECT `UID`,`Title`,`Announcement`,`PublishFrom`,`PublishTo` FROM `".DB_PREFIX."announcements` WHERE `UserType` = '%s' AND `deletedFlag` = 0 LIMIT %d;", $UserType, 20);
		//run the query
		$result = db_query($resLimitedSql,DB_NAME,$conn);	
		?>
		<script>
		//<!--
		function checkDelAnnounce(field){
			if(document.announcements.del.checked == true){
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
		<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">Announcements</li></ol>
		<p>Announcements you add here will be published to all customers who login to the portal. To send announcements to specific customers, please use the messages tab.</p>
		<form name="announcements" method="post" action="#tabs-2">
		<div id="hideMsg"><?php if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>
        <a class="btn btn-primary" href="staff.php?tab=5&subtab=announcements&action=add#tabs-2">Add Announcement</a>        
        <p class="text-center">CUSTOMER ANNOUNCEMENTS</p>
        <table width="100%" class="display table table-striped table-bordered table-hover">				
        <thead>
		<tr>
		<th>Title</th>
		<th>Announcement</th>
		<th>Published</th>
		<th class="no-sort">Actions</th>
		<th class="no-sort" style="text-align:center"><input type="checkbox" name="del" title="Check All" onclick="checkDelAnnounce(document.getElementsByName('announcementIDs[]'));" value="" /></th>
		</tr>
        </thead>
		<?php
		//check if any rows returned
		if(db_num_rows($result)>0){
		  echo "<tbody>";
		  while($announce = db_fetch_array($result)){
			  echo "<tr>
			  <td>".$announce['Title']."</td>
			  <td>".$announce['Announcement']."</td>
			  <td>".$announce['PublishFrom']." to ".$announce['PublishTo']."</td>
			  <td><a href=\"?tab=5&subtab=announcements&action=view&eid=".$announce['UID']."#tabs-2\" title=\"View\">View</a> | <a href=\"?tab=5&subtab=announcements&action=edit&eid=".$announce['UID']."#tabs-2\" title=\"Edit\">Edit</a></td>
			  <td align=\"center\"><input type=\"checkbox\" id=\"selectedIDs\" name=\"announcementIDs[]\" value=\"".$announce['UID']."\"></td>
			  </tr>";		
		  }
		  echo "</tbody>";
		  ?>
		  <tfoot>
		  <tr>
		  <td colspan="5" align="right">
          <div class="form-inline">
          <div class="form-group">
          <label>With Selected:&nbsp;</label>
          <input type="submit" value="Delete" name="DELETE" class="btn btn-default" />
          </div>
          </div>
          </td>
		  </tr>
		  </tfoot>
		  <?php
		}
		?>
		</table>
		</form>
		<?php
		unset($_SESSION['MSG']);
		break;
	}
}
?>

<?php
function show_loginhistory(){
	global $a;
	global $conn;
	global $LoginID;
	
	
	//Delete script
	if(isset($_POST['DELETE']) && isset($_POST['logsIDs']) && isSuperAdmin()){	
		foreach($_POST['logsIDs'] as $selectedID){
			$sqlDelete = sprintf("DELETE FROM `".DB_PREFIX."portal_logs` WHERE `LogID` = %d LIMIT %d", intval($selectedID), 1);
			//Run query
			db_query($sqlDelete,DB_NAME,$conn);
		}
		$UsrMSG = ConfirmMessage("Selected customer login history deleted!");
	}
	
	//Display login history
	if(!empty($LoginID)){
		//Begin display script for selected customer
		$sqlUsrLogins = sprintf("SELECT `PL`.`LogID` FROM `".DB_PREFIX."portal_logs` AS `PL` INNER JOIN `".DB_PREFIX."portal` AS `P` ON `PL`.`LoginID` = `P`.`LoginID` WHERE  `P`.`UserType` = 'Customer' AND `PL`.`LoginID` = '%s'", $LoginID);
		$rowUsrResult = db_query($sqlUsrLogins,DB_NAME,$conn);
		$usr_num_rows = db_num_rows($rowUsrResult);
		//set sql
		$resSql = sprintf("SELECT `PL`.`LogID`, `PL`.`LoginID`, `PL`.`LoginDate`, `PL`.`Source` FROM `".DB_PREFIX."portal_logs` AS `PL` INNER JOIN `".DB_PREFIX."portal` AS `P` ON `PL`.`LoginID` = `P`.`LoginID` WHERE  `P`.`UserType` = 'Customer' AND `PL`.`LoginID` = '%s' ORDER BY `LoginDate` DESC LIMIT %d;", $LoginID, 10);
	}
	else{
		//Begin normal display script
		$sqlUsrLogins = "SELECT `PL`.`LogID`, `PL`.`LoginID`, `PL`.`LoginDate`, `PL`.`Source` FROM `".DB_PREFIX."portal_logs` AS `PL` INNER JOIN `".DB_PREFIX."portal` AS `P` ON `PL`.`LoginID` = `P`.`LoginID` WHERE  `P`.`UserType` = 'Customer'";
		$rowUsrResult = db_query($sqlUsrLogins,DB_NAME,$conn);
		$usr_num_rows = db_num_rows($rowUsrResult);
		//set sql
		$resSql = sprintf("SELECT `PL`.`LogID`, `PL`.`LoginID`, `PL`.`LoginDate`, `PL`.`Source` FROM `".DB_PREFIX."portal_logs` AS `PL` INNER JOIN `".DB_PREFIX."portal` AS `P` ON `PL`.`LoginID` = `P`.`LoginID` WHERE  `P`.`UserType` = 'Customer' ORDER BY `LoginDate` DESC LIMIT %d;", 20);
	}		
	?>
    <script>
	//<!--
	function checkDelLogins(field){
		if(document.std_logins.del.checked == true){
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
	<ol class="breadcrumb"><li><a href="staff.php" title="Dashboard">Dashboard</a></li><li><a href="staff.php?tab=5">Customers</a></li><li class="active">Login History</li></ol>
	<form name="std_logins" method="post" action="#tabs-3">
	<div id="hideMsg"><?php if(isset($UsrMSG)) echo $UsrMSG;?></div>
	<p class="text-center">CUSTOMER LOGIN HISTORY</p>
    <table width="100%" class="display table table-striped table-bordered table-hover">
	<thead>
	<tr>
	<th>Customer ID</th>
	<th>Login Date</th>
	<th>Source</th>
	<th class="no-sort" style="text-align:center"><input type="checkbox" name="del" title="Check All" onclick="checkDelLogins(document.getElementsByName('logsIDs[]'));" value="" /></th>
	</tr>
    </thead>    
	<?php
	//run the query
	$result = db_query($resSql,DB_NAME,$conn);
	//check if any rows returned
	if(db_num_rows($result)>0){
	  echo "<tbody>";
	  while($user_logs = db_fetch_array($result)){
		  echo "<tr>
		  <td>".$user_logs['LoginID']."</td>
		  <td>".fixdatetime($user_logs['LoginDate'])."</td>
		  <td>".$user_logs['Source']."</td>
		  <td align=\"center\"><input type=\"checkbox\" id=\"selectedIDs\" name=\"logsIDs[]\" value=\"".$user_logs['LogID']."\"></td>
		  </tr>";
	  }
	  echo "</tbody>";
	  ?>    
	  <tfoot>
	  <tr>
	  <td colspan="4" align="right">
      <div class="form-inline">
      <div class="form-group">
      <label>With Selected:&nbsp;</label>
      <input type="submit" value="Delete" name="DELETE" class="btn btn-default" />
      </div>
      </div>
      </td>
	  </tr>
	  </tfoot>
	<?php
	}
	?>
	</table>
	</form>
	<?php
}
?>

<?php
function sql_select(){
	global $conn;
	
	//$sql = "SELECT `UID`,`CustomerID`,`FName`,`MName`,`LName`,CONCAT(`FName`,' ',`LName`) AS `CustomerName`,`Gender`,`ProfilePhoto`,`RegDate`,`Email`,`DOB`,`Phone`,`Address1`,`Address2`,`City`,`State`,`PostCode`,`Country`,`disabledFlag` FROM `".DB_PREFIX."customers`";	
	$sql = "SELECT * FROM `".DB_PREFIX."customer`";	
	
        $res = db_query($sql,DB_NAME,$conn);
	return $res;
}

function sql_getrecordcount(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."customer`";	
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}

/*function sql_insert($FIELDS){
	global $conn;
	
	
	$sql = sprintf("INSERT INTO `".DB_PREFIX."customer` (`CustomerID`,`FName`,`MName`,`LName`,`Gender`,`RegDate`,`Email`,`DOB`,`Phone`,`Address1`,`Address2`,`City`,`State`,`PostCode`,`Country`) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $FIELDS['CustomerID'], $FIELDS['FName'], $FIELDS['MName'], $FIELDS['LName'], $FIELDS['Gender'], $FIELDS['RegDate'], $FIELDS['Email'], $FIELDS['dbDOB'], $FIELDS['Phone'], $FIELDS['Address1'], $FIELDS['Address2'], $FIELDS['City'], $FIELDS['State'], $FIELDS['PostCode'], $FIELDS['Country']);	
	db_query($sql,DB_NAME,$conn);
	
	
	if(db_affected_rows($conn)){
		//Add password to allow access to portal
		if(!empty($FIELDS['Password'])){
			sql_insert_password($FIELDS);
		}
		$_SESSION['MSG'] = ConfirmMessage("New customer has been added successfully");
	}else{
		$_SESSION['MSG'] = ErrorMessage("Failed to save successfully. Please try again later...");
	}
	redirect("staff.php?tab=5");
}
*/
//new custmer insert
function sql_insert2(){
	
}
function sql_update($FIELDS){
	global $conn;
	
	//Update customer
	$sql = sprintf("UPDATE `".DB_PREFIX."customer` SET `CustomerID` = '%s', `FName` = '%s',`MName` = '%s',`LName` = '%s',`Gender` = '%s', `Email` = '%s',`DOB` = '%s',`Phone` = '%s',`Address1` = '%s',`Address2` = '%s',`City` = '%s',`State` = '%s',`PostCode` = '%s',`Country` = '%s' WHERE " .primarykeycondition(). "", $FIELDS['CustomerID'], $FIELDS['FName'], $FIELDS['MName'], $FIELDS['LName'], $FIELDS['Gender'], $FIELDS['Email'], $FIELDS['dbDOB'], $FIELDS['Phone'], $FIELDS['Address1'], $FIELDS['Address2'], $FIELDS['City'], $FIELDS['State'], $FIELDS['PostCode'], $FIELDS['Country']);		
	db_query($sql,DB_NAME,$conn);		
	
	//Check if updated
	if(db_affected_rows($conn)){		
		$_SESSION['MSG'] = ConfirmMessage("Customer has been updated successfully.");
	}else{
		$_SESSION['MSG'] = WarnMessage("No changes made!");
	}
	
	//Add password to allow access to portal
	if(!empty($FIELDS['Password'])){
		if(!sql_update_password($FIELDS)){	
			sql_insert_password($FIELDS);			
			$_SESSION['MSG'] = ConfirmMessage("Customer password has been updated successfully.");
		}
	}
	
	redirect("staff.php?tab=5");
}

function sql_insert_password($FIELDS){
	global $conn;
	
	//Add new customer
	$sql = sprintf("INSERT INTO `".DB_PREFIX."portal` (`UserType`,`LoginID`,`Password`,`ApprovedFlag`) VALUES ('%s','%s','%s',%d)", 'Customer', $FIELDS['CustomerID'], $FIELDS['EncryptPass'], 1);
	db_query($sql,DB_NAME,$conn);
	
	//Check if updated
	if(db_affected_rows($conn)){
		return true;
	}else{
		return false;
	}
}

function sql_update_password($FIELDS){
	global $conn;
	
	//Add new customer
	$sql = sprintf("UPDATE `".DB_PREFIX."portal` SET `Password` = '%s', `Token` = '%s' WHERE `LoginID` = '%s'", $FIELDS['EncryptPass'], $FIELDS['Token'], $FIELDS['CustomerID']);
	db_query($sql,DB_NAME,$conn);
	
	//Check if updated
	if(db_affected_rows($conn)){
		return true;
	}else{
		return false;
	}
}

function sql_update_status($disabledFlag, $editID){
	global $conn;
	
	//Update customer
	$sql = sprintf("UPDATE `".DB_PREFIX."customer` SET `disabledFlag` = %d WHERE `UID` = %d LIMIT 1", $disabledFlag, $editID);
	db_query($sql,DB_NAME,$conn);
	
	//Check if updated
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Customer has been updated successfully.");
	}else{
		$_SESSION['MSG'] = WarnMessage("No changes made!");
	}
	redirect("staff.php?tab=5");
}

function sql_delete(){
	global $conn;
	
	$sql = "DELETE FROM `".DB_PREFIX."customer` WHERE " .primarykeycondition();
	db_query($sql,DB_NAME,$conn);
	
	//Check if saved
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Customer has been deleted successfully");
	}else{
		$_SESSION['MSG'] = ErrorMessage("Failed to delete selected customer. Please try again later...");
	}
	redirect("staff.php?tab=5");
}

function primarykeycondition(){
	
	$pk = "";
	$pk .= "(`UID`";
	if (@$_POST["eid"] == "") {
		$pk .= " IS NULL";
	}else{ 
		$pk .= " = " .intval(@$_POST["eid"]);
	};
	$pk .= ")";
	return $pk;
}
?>