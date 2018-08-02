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
	$_SESSION['custusername'] = $username;
	$_SESSION['custpassword'] = $password;
	$_SESSION['custTimeout'] = time();
	
	if(isset($_POST['urem']) == 1){
        //Add additional member to cookie array as per requirement
        setcookie("custusername", $_SESSION['custusername'], time()+60*60*24*100, "/");
        setcookie("custpassword", $_SESSION['custpassword'], time()+60*60*24*100, "/");
        return;
    }
}
//Clear user sessions and cookies
function clearsessionscookies() {
	unset($_SESSION['custusername']);
	unset($_SESSION['custpassword']);
	unset($_SESSION['custUserID']);
	unset($_SESSION['custUsername']);
	unset($_SESSION['custEmail']);
	unset($_SESSION['custFullName']);
	unset($_SESSION['custTimeout']);
	unset($_SESSION["folder"]);
	
	//setcookie("custusername", "",time()-60*60*24*100, "/");
    setcookie("custpassword", "",time()-60*60*24*100, "/");
}
//
function activeSession(){
	// Session killer after a given period of inactive login
	$inactive = 3600; // Set timeout period in seconds i.e.(1800 = 30min)

	if(isset($_SESSION['custTimeout'])) {
		$session_life = time() - $_SESSION['custTimeout'];
		if($session_life > $inactive) {
			//session_destroy();			
			markLoggedout();
		    return false;
		}
		else{
			$_SESSION['custTimeout'] = time();// Reset time
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
	$query = sprintf("SELECT `ID`,`Username`,`Password`,`Email`,`FirstName`,`LastName` FROM `".DB_PREFIX."customers` WHERE `Username` = '%s' AND `disabledFlag` = %d AND `deletedFlag` = %d AND `LoggedIn` = %d", $user, 0, 0, 0);
	//Execute the query
	$result = db_query($query,DB_NAME,$conn);
	
	//Check if any record returned
	if(db_num_rows($result)>0){
		//Fetch data
		$row = db_fetch_array($result);
		
		$_SESSION['custUserID'] = $row['ID'];
		$_SESSION['custUsername'] = $row['Username'];
		$_SESSION['custEmail'] = $row['Email'];
		$_SESSION['custFullName'] = $row['FirstName']." ".$row['LastName'];
		
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
		$userid = isset($_SESSION['custUserID'])?$_SESSION['custUserID']:NULL;
		settype($userid, 'integer');
		//Open database connection
		global $incl_dir;
		require_once("$incl_dir/mysqli.functions.php");
		$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			
		$query = sprintf("SELECT `LoggedIn` FROM `".DB_PREFIX."customers` WHERE `ID` = %d", $userid);
		$result = db_query($query,DB_NAME,$conn);
		//Check if any record returned
		if(db_num_rows($result)>0){	
			//Fetch data
			$row = db_fetch_array($result);
			$LogStatus = $row['LoggedIn'];
		}
		//Close the database connection	
		db_close($conn);
		//End of check
		if(isset($_SESSION['custusername']) && isset($_SESSION['custpassword']) && $LogStatus==1)
			return true;
		elseif(isset($_COOKIE['custusername']) && isset($_COOKIE['custpassword'])){
			if(confirmUser($_COOKIE['custusername'],$_COOKIE['custpassword'])){
				createsessions($_COOKIE['custusername'],$_COOKIE['custpassword']); 
				markLoggedin($_COOKIE['custusername']); 
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
	$query = sprintf("SELECT `ID`,`Username`,`Password` FROM `".DB_PREFIX."customers` WHERE `Username` = '%s' AND `LoggedIn` = %d", $user, 1);
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
			$query = sprintf("UPDATE `".DB_PREFIX."customers` SET `LoggedIn` = %d WHERE `Username` = '%s'", 0, $username);
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
	$userid = isset($_SESSION['custUserID'])?$_SESSION['custUserID']:NULL;
	settype($userid, 'integer');
    $logindate = date("Y-m-d H:i:s",time());
	$source = getUserIP();
	
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	//run the query
	$query = sprintf("UPDATE `".DB_PREFIX."customers` SET `LoggedIn` = %d, `loginDate` = '%s' WHERE `Username` = '%s'", 1, $logindate, $username);
	db_query($query,DB_NAME,$conn);
	//check if true and add this log
	if(db_affected_rows($conn)){
		$queryLog = sprintf("INSERT INTO `".DB_PREFIX."customers_logs` (`userID`, `loginDate`, `source`) VALUES (%d, '%s', '%s')", $userid, $logindate, $source);
		db_query($queryLog,DB_NAME,$conn);
	}
	//close the database connection
	db_close($conn);
}
//Mark User as loggedout
function markLoggedout(){
	$userid = isset($_SESSION['custUserID'])?$_SESSION['custUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("UPDATE `".DB_PREFIX."customers` SET `LoggedIn` = %d WHERE `ID` = %d", 0, $userid);
	//run the query
	db_query($query,DB_NAME,$conn);
	//close the database connection
	db_close($conn);
}
//Check if this user has all rights
function isValidCustomer(){
	$userid = isset($_SESSION['custUserID'])?$_SESSION['custUserID']:NULL;
	settype($userid, 'integer');
	global $incl_dir;
  	require_once("$incl_dir/mysqli.functions.php");
  	//Open database connection
  	$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$query = sprintf("SELECT `UserType` FROM `".DB_PREFIX."customers` WHERE `ID` = %d AND `disabledFlag` = 0 AND `deletedFlag` = 0", $userid);
	$result = db_query($query,DB_NAME,$conn);
	$rowData = db_fetch_array($result);
	if($rowData['UserType']=='Customer')
		return true;
	else
		return false;
	//close the database connection
	db_close($conn);
}
//Get username given the customer user ID
function getSysUsername($userID){
	global $conn;
	
	$sqlUsers = sprintf("SELECT `ID`,`Username` FROM `".DB_PREFIX."customers` WHERE `ID` = '%d' AND `deletedFlag` = 0", $userID);
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
	
	$sqlUsers = sprintf("SELECT `Username`,`Token` FROM `".DB_PREFIX."customers` WHERE `Token` = '%s' AND `deletedFlag` = 0", $tokenID);
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

?>