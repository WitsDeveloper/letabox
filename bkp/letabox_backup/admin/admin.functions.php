<?php 
/*********************************************
Company:	Wits Technologies Ltd
Developer:	Sammy Mwaura Waweru
Mobile:		+254721428276
Email:		sammy@witstechnologies.co.ke
Website:	http://www.witstechnologies.co.ke/
*********************************************/

//Create user sessions and cookies
function createsessions($username,$password) {
	//Add additional member to Session array as per requirement
	$_SESSION['sysusername'] = $username;
	$_SESSION['syspassword'] = $password;
	$_SESSION['sysTimeout'] = time();
	
	if(isset($_POST['urem']) == 1){
        //Add additional member to cookie array as per requirement
        setcookie("sysusername", $_SESSION['sysusername'], time()+60*60*24*100, "/");
        setcookie("syspassword", $_SESSION['syspassword'], time()+60*60*24*100, "/");
        return;
    }
}
//Clear user sessions and cookies
function clearsessionscookies() {
	unset($_SESSION['sysusername']);
	unset($_SESSION['syspassword']);
	unset($_SESSION['sysUserID']);
	unset($_SESSION['sysUsername']);
	unset($_SESSION['sysEmail']);
	unset($_SESSION['sysFullName']);
	unset($_SESSION['sysTimeout']);
	unset($_SESSION["folder"]);
	
	//setcookie("sysusername", "",time()-60*60*24*100, "/");
    setcookie("syspassword", "",time()-60*60*24*100, "/");
}
//
function activeSession(){
	// Session killer after a given period of inactive login
	$inactive = 3600; // Set timeout period in seconds i.e.(1800 = 30min)

	if(isset($_SESSION['sysTimeout'])) {
		$session_life = time() - $_SESSION['sysTimeout'];
		if($session_life > $inactive) {
			//session_destroy();			
			markLoggedout();
		    return false;
		}
		else{
			$_SESSION['sysTimeout'] = time();// Reset time
			return true;
		}
	}	
	else{
		return false;
	}
}
//Confirm User Login
function confirmUser($username,$password){
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	// Prevent SQL Injection
	// Reverse magic_quotes_gpc/magic_quotes_sybase effects on those vars if ON.
	if(get_magic_quotes_gpc()) {
		$user = stripslashes($username);
	} else {
		$user = mysqli_real_escape_string($conn,$username);
	}
	//Make a safe query
	$query = sprintf("SELECT `ID`,`Username`,`Password`,`Email`,`FirstName`,`LastName` FROM `".DB_PREFIX."sys_users` WHERE `Username` = '%s' AND `disabledFlag` = %d AND `deletedFlag` = %d AND `loggedIn` = %d", $user, 0, 0, 0);
	//Execute the query
	$result = db_query($query,DB_NAME,$conn);
	
	//Check if any record returned
	if(db_num_rows($result)>0){
		//Fetch data
		$row = db_fetch_array($result);
		
		$_SESSION['sysUserID'] = $row['ID'];
		$_SESSION['sysUsername'] = $row['Username'];
		$_SESSION['sysEmail'] = $row['Email'];
		$_SESSION['sysFullName'] = $row['FirstName']." ".$row['LastName'];
		
		if(password_verify($password, $row['Password']))
			return true;		
		else 
			return false;
	}else{
		return false;
	}
	//Close the database connection	
	db_close($conn);
}
//Check if user is loggen in  
function checkLoggedin() {
	if(activeSession()){
		$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
		settype($userid, 'integer');
		//Open database connection
		global $incl_dir;
		require_once("$incl_dir/mysqli.functions.php");
		$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			
		$query = sprintf("SELECT `loggedIn` FROM `".DB_PREFIX."sys_users` WHERE `ID` = %d", $userid);
		$result = db_query($query,DB_NAME,$conn);
		//Check if any record returned
		if(db_num_rows($result)>0){	
			//Fetch data
			$row = db_fetch_array($result);
			$LogStatus = $row['loggedIn'];
		}
		//Close the database connection	
		db_close($conn);
		//End of check
		if(isset($_SESSION['sysusername']) && isset($_SESSION['syspassword']) && $LogStatus==1)
			return true;
		elseif(isset($_COOKIE['sysusername']) && isset($_COOKIE['syspassword'])){
			if(confirmUser($_COOKIE['sysusername'],$_COOKIE['syspassword'])){
				createsessions($_COOKIE['sysusername'],$_COOKIE['syspassword']); 
				markLoggedin($_COOKIE['sysusername']); 
				return true; 
			} 
			else{ 
				clearsessionscookies(); 
				return false; 
			}
		}
		else 
			return false;
	}
	else{
		return false;
	}
}
//Returns TRUE if reset was done
function resetLoginSession($username){
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	if(get_magic_quotes_gpc()) {
		$user = stripslashes($username);
	} else {
		$user = mysqli_real_escape_string($conn,$username);
	}
	//Make a safe query
	$query = sprintf("SELECT `ID`,`Username`,`Password` FROM `".DB_PREFIX."sys_users` WHERE `Username` = '%s' AND `loggedIn` = %d", $user, 1);
	//Execute the query
	$result = db_query($query,DB_NAME,$conn);
	//Check if any record returned
	if(db_num_rows($result)>0){	
		//Fetch data
		$resetRow = db_fetch_array($result);
		$dbusername = $resetRow['Username'];	
		//Confirm user
		if($username == "$dbusername"){
			//set the query
			$query = sprintf("UPDATE `".DB_PREFIX."sys_users` SET `loggedIn` = %d WHERE `Username` = '%s'", 0, $username);
			db_query($query,DB_NAME,$conn);
			
			if(db_affected_rows($conn))
				return true;			
			else
				return false;			
		}
		else{
			return false;		
		}
	}
	else{
		return false;
	}
	//Close the database connection	
	db_close($conn);
}
//Mark User as logged in
function markLoggedin($username){
	$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
	settype($userid, 'integer');
    $logindate = date("Y-m-d H:i:s",time());
	$source = getUserIP();
	
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	//run the query
	$query = sprintf("UPDATE `".DB_PREFIX."sys_users` SET `loggedIn` = %d, `loginDate` = '%s' WHERE `Username` = '%s'", 1, $logindate, $username);
	db_query($query,DB_NAME,$conn);
	//check if true and add this log
	if(db_affected_rows($conn)){
		$queryLog = sprintf("INSERT INTO `".DB_PREFIX."sys_users_logs` (`userID`, `loginDate`, `source`) VALUES (%d, '%s', '%s')", $userid, $logindate, $source);
		db_query($queryLog,DB_NAME,$conn);
	}
	//close the database connection
	db_close($conn);
}
//Mark User as loggedout
function markLoggedout(){
	$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("UPDATE `".DB_PREFIX."sys_users` SET `loggedIn` = %d WHERE `ID` = %d", 0, $userid);
	//run the query
	db_query($query,DB_NAME,$conn);
	//close the database connection
	db_close($conn);
}
//Check if this user has all rights
function isSuperAdmin(){
	$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("SELECT `UserType`,`UserLevel` FROM `".DB_PREFIX."sys_users` WHERE `ID` = %d AND `disabledFlag` = 0 AND `deletedFlag` = 0", $userid);
	$result = db_query($query,DB_NAME,$conn);
	$rowData = db_fetch_array($result);
	if($rowData['UserType']=='Admin' && $rowData['UserLevel']=='Super')
		return true;
	else
		return false;
	//close the database connection
	db_close($conn);
}
//Check if this user has admin rights
function isSystemAdmin(){
	$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("SELECT `UserType`,`UserLevel` FROM `".DB_PREFIX."sys_users` WHERE `ID` = %d AND `disabledFlag` = 0 AND `deletedFlag` = 0", $userid);
	$result = db_query($query,DB_NAME,$conn);
	$rowData = db_fetch_array($result);
	if($rowData['UserType']=='Admin' && $rowData['UserLevel']=='Admin')
		return true;
	else
		return false;
	//close the database connection
	db_close($conn);
}
//Check if this user has staff rights
function isStaffAdmin(){
	$userid = isset($_SESSION['sysUserID'])?$_SESSION['sysUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("SELECT `UserType`,`UserLevel` FROM `".DB_PREFIX."sys_users` WHERE `ID` = %d AND `disabledFlag` = 0 AND `deletedFlag` = 0", $userid);
	$result = db_query($query,DB_NAME,$conn);
	$rowData = db_fetch_array($result);
	if($rowData['UserType']=='Admin' && $rowData['UserLevel']=='Staff')
		return true;
	else
		return false;
	//close the database connection
	db_close($conn);
}
//
function checkAllowedSysUsers(){
	global $conn;
	
	settype($total, 'integer');
	
	//If limited users and
	//a limit has been set, restrict
	if(defined(LIMIT_USERS) && defined(LIMIT_ALLOWED)){
		$sqlCount = "SELECT COUNT(`ID`) AS `Total` FROM  `".DB_PREFIX."sys_users` WHERE `UserLevel` != 'Super' AND `deletedFlag` = 0";
		$result = db_query($sqlCount,DB_NAME,$conn);
		$rowData = db_fetch_array($result);
		
		$total = $rowData['Total'];
		
		if($total < LIMIT_ALLOWED)
			return true;
		else
			return false;
	}else{
		return true;
	}
}
//Get username given the system user ID
function getSysUsername($userID){
	global $conn;
	
	$sqlUsers = sprintf("SELECT `ID`,`Username` FROM `".DB_PREFIX."sys_users` WHERE `ID` = '%d' AND `deletedFlag` = 0", $userID);
	//Execute the query
	$resultUser = db_query($sqlUsers,DB_NAME,$conn);
	
	if(db_num_rows($resultUser)>0){
		$rowUser = db_fetch_array($resultUser);
		return $rowUser['Username'];
	}
	else{
		return "N/A";
	}
}
//Get username given the token ID
function getSysTokenUser($tokenID){
	global $conn;
	
	$sqlUsers = sprintf("SELECT `Username`,`token` FROM `".DB_PREFIX."sys_users` WHERE `token` = '%s' AND `deletedFlag` = 0", $tokenID);
	//Execute the query
	$resultUser = db_query($sqlUsers,DB_NAME,$conn);
	
	if(db_num_rows($resultUser)>0){
		$rowUser = db_fetch_array($resultUser);
		return $rowUser['Username'];
	}
	else{
		return false;
	}
}
// Get number of orders available in the database
function getAllOrders($Status="All"){
	/*
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."orders`";
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);	
	return current($row);
	*/
	
	$Count = 0;
	switch($Status){
		case "All":
		$Count = 2;
		break;
		case "Pending":
		$Count = 1;
		break;
		case "Completed":
		$Count = 1;
		break;
	}
	return $Count;
}
// Get number of customers available in the database
function getAllcustomers(){
	global $conn;
	
	$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."customers`";
	$res = db_query($sql,DB_NAME,$conn);
	$row = db_fetch_array($res);
	reset($row);
	return current($row);
}
// Get number of messages for the logged in user
function getUserMessages($UserEmail){
	global $conn;
	
	if( !empty($UserEmail) && isset($UserEmail) ){		
		$sql = "SELECT COUNT(*) FROM `".DB_PREFIX."messages` WHERE (`ToAdd` = '$UserEmail' OR `CcAdd` = '$UserEmail' OR `BccAdd` = '$UserEmail')";		
		$res = db_query($sql,DB_NAME,$conn);
		$row = db_fetch_array($res);
		reset($row);
		return current($row);
	}else{
		return 0;
	}
}
// Get number of messages for the logged in user
function list_message_snapshots($UserEmail){
	global $conn;	
	$msgHTML = "";
	
	if( !empty($UserEmail) && isset($UserEmail) ){		
		$sqlGet = "SELECT `FromAdd`,`DateSent`,`Subject`,`Message` FROM `".DB_PREFIX."messages` WHERE (`ToAdd` = '$UserEmail' OR `CcAdd` = '$UserEmail' OR `BccAdd` = '$UserEmail') ORDER BY `DateSent` DESC LIMIT 5";
		$res = db_query($sqlGet,DB_NAME,$conn);
		if(db_num_rows($res)>0){
			while($message = db_fetch_array($res)){
				$msgHTML .= '
				<li>
					<a href="?tab=7">
						<div>
							<strong>'. $message['FromAdd'] .'</strong>
							<span class="pull-right text-muted">
								<em>'. formatDateAgo($message['DateSent']) .'</em>
							</span>
						</div>
						<div>'. truncate(decode($message['Message']), 80) .'</div>
					</a>
				</li>
				<li class="divider"></li>';
			}
		}
	}
	return $msgHTML;
}
//List message/note attachments
function list_attachments($MsgID){
	global $conn;

	$sqlAttachmentShow = sprintf("SELECT `FileName`,`DownloadPath` FROM `".DB_PREFIX."attachments` WHERE `MessageID` = %d", $MsgID);
	//Run the query
	$result = db_query($sqlAttachmentShow,DB_NAME,$conn);
	
	$attachmentList = "";
	if(db_num_rows($result)>0){
		$attachmentList .= "Attachments: ";
		while($attachment = db_fetch_array($result)){
			$attachmentList .= "<a href=\"".$attachment['DownloadPath']."\" href=\"_blank\">".$attachment['FileName']."</a>&nbsp;";
		}
	}
	return $attachmentList;
}
//Array of user levels
function list_user_levels(){
	return array(
	"Staff" => "Staff",
	"Admin" => "System Admin",
	"Super" => "Super Administrator");
}
//Array of user types
function list_user_types(){
	return array(
	"Admin" => "Back-end User");
}
?>
