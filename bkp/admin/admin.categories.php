<script language="javascript" type="text/javascript">
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME?> | Categories";
</script>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Categories</h1>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-sitemap fa-fw"></i> Manage Categories </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <!--Begin Forms-->
		<?php
		$a = isset($_GET["task"])?$_GET["task"]:"";
		$recid = intval(! empty($_GET['recid']))?$_GET['recid']:0;
		
		switch ($a) {
		case "add":
		  addrec();
		  break;
		case "view":
		  viewrec($recid);
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
function select(){
	
	$res = sql_select();
	$count = sql_getrecordcount();	
	
	if(isset($_GET['enable']) && isset($_GET['eid'])){
		$disabledFlag = intval(! empty($_GET['enable']))?$_GET['enable']:0;
		$editID = intval(! empty($_GET['eid']))?$_GET['eid']:0;
		
		sql_update_status($disabledFlag, $editID);
	}
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li class="active">Categories</li></ol>

<div id="hideMsg"><?php if(isset($_SESSION['MSG'])) echo $_SESSION['MSG'];?></div>

<?php showpagenav($pagecount); ?>
<table width="100%" class="display table table-striped table-bordered table-hover">
<thead>
<tr>
<th class="rid">#</th>
<th>Category Name</th>
<th>Local Shipping</th>
<th>Tax Rate</th>
<th class="no-sort">Enable</th>
<th class="no-sort">Actions</th>
</tr>
</thead>
<tbody>
<?php
for ($i = 0; $i < $count; $i++){
	$row = db_fetch_array($res);
?>
<tr>
<td><?=$row["CatID"]?></td>
<td><?=$row["CatName"]?></td>
<td><?=$row["LocalShipping"]?></td>
<td><?=$row["TaxRate"]?></td>
<?php
if($row['disabledFlag'] == 0){
	echo "<td align=\"center\"><a href=\"admin.php?tab=2&enable=1&eid=".$row['CatID']."\" title=\"Click to disable ".$row['CatName']."\"><img border=\"0\" src=\"".IMAGE_FOLDER."/icons/yes.png\" height=\"12\" width=\"12\" alt=\"Disable ".$row['CatName']."\"></a></td>";
}else{
	echo "<td align=\"center\"><a href=\"admin.php?tab=2&enable=0&eid=".$row['CatID']."\" title=\"Click to enable ".$row['CatName']."\"><img border=\"0\" src=\"".IMAGE_FOLDER."/icons/no.png\" height=\"12\" width=\"12\" alt=\"Enable ".$row['CatName']."\"></a></td>";
}
?>
<td><a href="admin.php?tab=2&task=view&recid=<?=$i ?>">View</a> | <a href="admin.php?tab=2&task=edit&recid=<?=$i ?>">Edit</a> | <a href="admin.php?tab=2&task=del&recid=<?=$i ?>">Delete</a></td>
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
<table class="table table-bordered">
<tr>
<th width="30%">Category Name (ID)</th>
<td><?=$row["CatName"] ."(". $row["CatID"] .")"; ?></td>
</tr>
<tr>
<th>Local Shipping</th>
<td><?=$row["LocalShipping"]; ?></td>
</tr>
<tr>
<th>Tax Rate (%)</th>
<td><?=$row["TaxRate"]; ?></td>
</tr>
<tr>
<th colspan="2">Description</th>
</tr>
<tr>
<td colspan="2"><?=$row["Description"]; ?></td>
</tr>
</table>
</div>
<?php } ?>

<?php 
function showroweditor($row, $iseditmode, $ERRORS){
  global $a;  
?>
<p class="text-center lead"><strong><?=strtoupper($a)?> DEPARTMENT</strong></p>
<p class="text-center small"><span class="text-danger">FIELDS MARKED WITH ASTERISKS (*) ARE REQUIRED</span></p>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
    <label for="">Category Name: <span class="text-danger">*</span></label>
    <input type="text" value="<?=$row['CatName']; ?>" name="CatName" class="form-control required"><span class="text-danger"><?=$ERRORS['CatName'];?></span>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
    <label for="">Local Shipping: </label>
    <input type="text" value="<?=$row['LocalShipping']; ?>" name="LocalShipping" class="form-control">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
    <label for="">Tax Rate: </label>
    <input type="text" value="<?=$row['TaxRate']; ?>" name="TaxRate" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
    <label for="">Short Description</label>
    <textarea name="Description" rows="6" class="form-control"><?=$row['Description'];?></textarea><span class="text-danger"><?=$ERRORS['Description'];?></span>
    </div>
  </div>
</div>
<?php } ?>

<?php
function showpagenav() {
?>
<div class="quick-nav btn-group">
<a class="btn btn-primary" href="admin.php?tab=2&task=add">Add Category</a>
<a class="btn btn-default" href="admin.php?tab=2&task=reset">Reset Filters</a>
</div>
<?php } ?>

<?php function showrecnav($a, $recid, $count) { ?>
<div class="quick-nav btn-group">
<a class="btn btn-default" href="admin.php?tab=2"><i class="fa fa-undo fa-fw"></i> Back to Categories</a>
<?php if ($recid > 0) { ?>
<a class="btn btn-default" href="admin.php?tab=2&task=<?=$a ?>&recid=<?=$recid - 1 ?>"><i class="fa fa-arrow-left fa-fw"></i> Prior Record</a>
<?php } if ($recid < $count - 1) { ?>
<a class="btn btn-default" href="admin.php?tab=2&task=<?=$a ?>&recid=<?=$recid + 1 ?>"><i class="fa fa-arrow-right fa-fw"></i> Next Record</a>
<?php } ?>
</div>
<br />
<?php } ?>

<?php 
function viewrec($recid){
  
  $res = sql_select();
  $count = sql_getrecordcount();
  db_data_seek($res, $recid);
  $row = db_fetch_array($res);  
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=2">Categories</a></li><li class="active">View Category</li></ol>
<?php 
showrecnav("view", $recid, $count);
showrow($row, $recid);
?>
<div class="quick-nav btn-group">
<a class="btn btn-default" href="admin.php?tab=2&task=add"><i class="fa fa-file-o fa-fw"></i> Add Category</a>
<a class="btn btn-default" href="admin.php?tab=2&task=edit&recid=<?=$recid ?>"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Category</a>
<a class="btn btn-default" href="admin.php?tab=2&task=del&recid=<?=$recid ?>"><i class="fa fa-trash-o fa-fw"></i> Delete Category</a>
</div>
<?php
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
	
	// Commands
	if(isset($_POST["Add"])){
		// Category info
		$FIELDS['CatName'] = secure_string(ucwords($_POST['CatName']));
		$FIELDS['CatValue'] = friendlyName($FIELDS['CatName']);
		$FIELDS['LocalShipping'] = number_format($_POST['LocalShipping'],2);
		$FIELDS['TaxRate'] = number_format($_POST['TaxRate'],2);
		$FIELDS['Description'] = secure_string($_POST['Description']);
		
		// Validator data
		$check = new validator();
		// validate entry
		// validate "CatName" field
		if(!$check->is_String($FIELDS['CatName']))
		$ERRORS['CatName'] = "Valid category name is required";		
		//Check if this category is already registered	
		$checkDuplicateSql2 = sprintf("SELECT `CatName` FROM `".DB_PREFIX."categories` WHERE `CatName` = '%s'", $FIELDS['CatName']);
		//check if any results were returned
		if(checkDuplicateEntry($checkDuplicateSql2)){
			$ERRORS['CatName'] = "A category with similar name already exists!";
		}
		
		// check for errors
		if(sizeof($ERRORS) > 0){
			$ERRORS['MSG'] = ErrorMessage("ERRORS ENCOUNTERED!");
		}
		else{
			sql_insert($FIELDS);
		}
	}
	
	$row["CatName"] = !empty($FIELDS['CatName'])?$FIELDS['CatName']:"";
	$row["CatValue"] = !empty($FIELDS['CatValue'])?$FIELDS['CatValue']:"";
	$row["LocalShipping"] = !empty($FIELDS['LocalShipping'])?$FIELDS['LocalShipping']:0.00;
	$row["TaxRate"] = !empty($FIELDS['TaxRate'])?$FIELDS['TaxRate']:0.00;
	$row["Description"] = !empty($FIELDS['Description'])?$FIELDS['Description']:"";
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=2">Categories</a></li><li class="active">Add Category</li></ol>

<a class="btn btn-default" href="admin.php?tab=2"><i class="fa fa-undo fa-fw"></i> Back to Categories</a>

<p class="text-center"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></p>
<form id="validateform" enctype="multipart/form-data" action="admin.php?tab=2&task=add" method="post">
<input type="hidden" name="sql" value="insert">
<?php
showroweditor($row, false, $ERRORS);
?>

<p class="text-center">
<input class="btn btn-primary" type="submit" name="Add" value="Save">
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='admin.php?tab=2'">
</p>
</form>
<?php } ?>

<?php 
function editrec($recid){
  	global $class_dir;
	require_once("$class_dir/class.validator.php3");
	
	// Variables
	$ERRORS = array();
	$FIELDS = array();
	
	// Commands
	if(isset($_POST["Edit"])){
		// Category info
		$FIELDS['CatName'] = secure_string(ucwords($_POST['CatName']));
		$FIELDS['CatValue'] = friendlyName($FIELDS['CatName']);
		$FIELDS['LocalShipping'] = (float) number_format($_POST['LocalShipping'],2);
		$FIELDS['TaxRate'] = number_format($_POST['TaxRate'],2);
		$FIELDS['Description'] = secure_string($_POST['Description']);
		
		// Validator data
		$check = new validator();
		// validate entry
		// validate "CatName" field
		if(!$check->is_String($FIELDS['CatName']))
		$ERRORS['CatName'] = "Valid category name is required";
		
		// check for errors
		if(sizeof($ERRORS) > 0){
			$ERRORS['MSG'] = ErrorMessage("ERRORS ENCOUNTERED!");
		}
		else{
			sql_update($FIELDS);
		}
  	}
	
	$res = sql_select();
	$count = sql_getrecordcount();
	db_data_seek($res, $recid);
	$row = db_fetch_array($res); 
	
	$row["CatName"] = !empty($FIELDS['CatName'])?$FIELDS['CatName']:$row["CatName"];
	$row["CatValue"] = !empty($FIELDS['CatValue'])?$FIELDS['CatValue']:$row["CatValue"];
	$row["LocalShipping"] = !empty($FIELDS['LocalShipping'])?$FIELDS['LocalShipping']:$row["LocalShipping"];
	$row["TaxRate"] = !empty($FIELDS['TaxRate'])?$FIELDS['TaxRate']:$row["TaxRate"];
	$row["Description"] = !empty($FIELDS['Description'])?$FIELDS['Description']:$row["Description"];
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=2">Categories</a></li><li class="active">Edit Category</li></ol>
<?php showrecnav("edit", $recid, $count); ?>
<form id="validateform" enctype="multipart/form-data" action="admin.php?tab=2&task=edit&recid=<?=$recid?>" method="post">
<p class="text-center"><?php if(sizeof($ERRORS['MSG'])>0) echo $ERRORS['MSG'];?></p>
<input type="hidden" name="sql" value="update">
<input type="hidden" name="eid" value="<?=$row["CatID"] ?>">
<?php showroweditor($row, true, $ERRORS); ?>
<p class="text-center">
<input class="btn btn-primary" type="submit" name="Edit" value="Save">
<input class="btn btn-default" type="button" name="cancel" value="Cancel" onclick="javascript:location.href='admin.php?tab=2'">
</p>
</form>
<?php
db_free_result($res);
} 
?>

<?php 
function deleterec($recid){
	
	// Commands
	if(isset($_POST["Delete"])){
		sql_delete();
	}
  
	$res = sql_select();
	$count = sql_getrecordcount();
	db_data_seek($res, $recid);
	$row = db_fetch_array($res);  
?>
<ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=2">Categories</a></li><li>Delete Category</li></ol>
<?php showrecnav("del", $recid, $count); ?>
<form action="admin.php?tab=2&task=del&recid=<?=$recid?>" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="eid" value="<?=$row["CatID"] ?>">
<?php showrow($row, $recid) ?>
<strong>Are you sure you want to delete this record? </strong><div class="btn-group"><input class="btn btn-primary" type="submit" name="Delete" value="Yes"> <input class="btn btn-default" type="button" name="Ignore" value="No" onclick="javascript:history.go(-1)"></div>
</form>
<?php
db_free_result($res);
}
?>
<?php
function sql_select(){
	global $conn;
		
	$sql = "SELECT `CatID`,`CatName`,`LocalShipping`,`TaxRate`,`Description`,`disabledFlag` FROM `".DB_PREFIX."categories`";	
	$res = db_query($sql,DB_NAME,$conn);	
	return $res;
}

function sql_getrecordcount(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."categories`";	
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}

function sql_insert($FIELDS){
	global $conn;
	
	//Add new category
	$sql = sprintf("INSERT INTO `".DB_PREFIX."categories` (`CatName`,`CatValue`,`LocalShipping`,`TaxRate`,`Description`) VALUES ('%s', '%s', %d, %d, '%s')", $FIELDS['CatName'], $FIELDS['CatValue'], $FIELDS['LocalShipping'], $FIELDS['TaxRate'], $FIELDS['Description']);
	db_query($sql,DB_NAME,$conn);
	
	//Check if saved
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("New category has been added successfully");
	}else{
		$_SESSION['MSG'] = ErrorMessage("Failed to save successfully. Please try again later...");
	}
	redirect("admin.php?tab=2");
}

function sql_update($FIELDS){
	global $conn;
	
	//Update category
	$sql = sprintf("UPDATE `".DB_PREFIX."categories` SET `CatName` = '%s', `CatValue` = '%s', `LocalShipping` = %d, `TaxRate` = %d, `Description` = '%s' WHERE " .primarykeycondition(). "", $FIELDS['CatName'], $FIELDS['CatValue'], $FIELDS['LocalShipping'], $FIELDS['TaxRate'], $FIELDS['Description']);		
	db_query($sql,DB_NAME,$conn);
	
	//Check if updated
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Category has been updated successfully.");
	}else{
		$_SESSION['MSG'] = WarnMessage("No changes made!");
	}
	redirect("admin.php?tab=2");
}

function sql_update_status($disabledFlag, $editID){
	global $conn;
	
	//Update category
	$sql = sprintf("UPDATE `".DB_PREFIX."categories` SET `disabledFlag` = %d WHERE `CatID` = %d LIMIT 1", $disabledFlag, $editID);
	db_query($sql,DB_NAME,$conn);
	
	//Check if updated
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Category has been updated successfully.");
	}else{
		$_SESSION['MSG'] = WarnMessage("No changes made!");
	}
	redirect("admin.php?tab=2");
}

function sql_delete(){
	global $conn;
	
	$sql = "DELETE FROM `".DB_PREFIX."categories` WHERE " .primarykeycondition();
	db_query($sql,DB_NAME,$conn);
	
	//Check if saved
	if(db_affected_rows($conn)){
		$_SESSION['MSG'] = ConfirmMessage("Category has been deleted successfully");
	}else{
		$_SESSION['MSG'] = ErrorMessage("Failed to delete selected category. Please try again later...");
	}
	redirect("admin.php?tab=2");
}

function primarykeycondition(){
	
	$pk = "";
	$pk .= "(`CatID`";
	if (@$_POST["eid"] == "") {
		$pk .= " IS NULL";
	}else{
		$pk .= " = " .intval(@$_POST["eid"]);
	};
	$pk .= ")";
	return $pk;
}
?>