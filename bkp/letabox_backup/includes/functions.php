
<?php 
/*********************************************
Company:	Wits Technologies Ltd
Developer:	Sammy Mwaura Waweru
Mobile:		+254721428276
Email:		sammy@witstechnologies.co.ke
Website:	http://www.witstechnologies.co.ke/
*********************************************/

// FOR WINDOWS IIS
// Let's make sure the $_SERVER['DOCUMENT_ROOT'] variable is set
if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['SCRIPT_FILENAME'])){
$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));
}; };
if(!isset($_SERVER['DOCUMENT_ROOT'])){ if(isset($_SERVER['PATH_TRANSLATED'])){
$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])));
}; };

//
function add_title($sitename,$pagetitle){
	if( !empty( $sitename ) && !empty( $pagetitle ) ) {
		return $sitename.' - '.$pagetitle;
	}else{
		return $sitename;
	}
}
//
function add_header( $section = "" ){
	
	if( !empty( $section ) ){
		require_once THEME_DIR_BE.DIRECTORY_SEPARATOR.'header-'. $section .'.php';
	}else{
		require_once THEME_DIR_BE.DIRECTORY_SEPARATOR.'header.php';
	}

}
//
function add_footer( $section = "" ){
	
	if( !empty( $section ) ){
		require_once THEME_DIR_BE.DIRECTORY_SEPARATOR.'footer-'. $section .'.php';
	}else{
		require_once THEME_DIR_BE.DIRECTORY_SEPARATOR.'footer.php';
	}
}

/* Confirm/Success Message */
function ConfirmMessage($str){
	return "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><i class=\"fa fa-thumbs-up fa-fw\"></i> $str </div>";
}
/* Attention/Info Message */
function AttentionMessage($str){
	return "<div class=\"alert alert-info alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><i class=\"fa fa-exclamation-triangle fa-fw\"></i> $str </div>";
}
/* Warning Message */
function WarnMessage($str){
	return "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><i class=\"fa fa-exclamation-triangle fa-fw\"></i> $str </div>";
}
/* Error/Danger Message */
function ErrorMessage($str){
	return "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button><i class=\"fa fa-thumbs-down fa-fw\"></i> $str </div>";	
}

/* Reverse magic_quotes_gpc/magic_quotes_sybase effects on those vars if ON. */
if (get_magic_quotes_gpc()) {
	$_GET = array_map("strip_slashes_recursive", $_GET);
	$_POST = array_map("strip_slashes_recursive", $_POST);
	$_COOKIE = array_map("strip_slashes_recursive", $_COOKIE);
}
//
function add_slashes_recursive( $variable ){
    if(is_string($variable)){
        return addslashes($variable);
	}
    elseif(is_array($variable)){
        foreach($variable as $i => $value){
            $variable[$i] = add_slashes_recursive($value);
		}
	}
    return $variable;
}
//
function strip_slashes_recursive($variable){
    if(is_string($variable)){
        return stripslashes($variable);
	}
    elseif(is_array($variable)){
        foreach($variable as $i => $value){
            $variable[$i] = strip_slashes_recursive($value);
		}
    }
    return $variable; 
}
//DB Secure String
function secure_string($string){
	global $conn;	
	$trimmedStr = trim($string);
	
	if (get_magic_quotes_gpc()) {
		return strip_slashes_recursive($trimmedStr);
	} else {
		return mysqli_real_escape_string($conn,$trimmedStr);
	}
}
//
function encode($string){
	return htmlentities($string, ENT_QUOTES);
}
//
function decode($string){
	return html_entity_decode($string, ENT_QUOTES);
}
// Truncate a string to given length
function truncate($value,$length){
	if(strlen($value)>$length){
		$value=substr($value,0,$length);
		$n=0;
		while(substr($value,-1)!=chr(32)){
			$n++;
			$value=substr($value,0,$length-$n);
		}
		$value=$value." ...";
	}
	return clean_string($value);
	//return $value;
}

function clean_string($string){
	//$string = preg_replace('/\s*$^\s*/m', "\n", $string);
	//return preg_replace('/[ \t]+/', ' ', $string);
	return preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $string));
}
// Performs explode() on a string with the given delimiter and trims all whitespace for the elements
function explode_trim($str, $delimiter = ',') { 
    if ( is_string($delimiter) ) { 
        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str)); 
        return explode($delimiter, $str); 
    } 
    return $str; 
} 
// Performs a whitespace cleanup
function whitespace_trim($str){
	$string = preg_replace('/\s+/', '', $str);
	return $string;
}
//format date("d-m-Y")
function fixdate($date){
	if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
		return "N/A";
	}
	else{
		return date("d-m-Y", strtotime($date));
	}
}
//DOB short date format dS, M
function fixdateshortdob($date){
	if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
		return "N/A";
	}
	else{
		return date("d\<\s\u\p\>S\<\/\s\u\p\>, M", strtotime($date));
	}
}
//format date("d/m/Y")
function fixdateshort($date){
	if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
		return "N/A";
	}
	else{
		return date("d/m/Y", strtotime($date));
	}
}
//format date("M j, Y")
function fixdatelong($date){
	if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
		return "N/A";
	}
	else{
		return date("M j, Y", strtotime($date));
	}
}
//format datetime date("d-m-Y H:i:s")
function fixdatetime($datetime){
	if($datetime == "0000-00-00 00:00:00" || $datetime == "0000-00-00"){
		return "N/A";
	}
	else{
		return date("d-m-Y H:i:s", strtotime($datetime));
	}
}
//format datetime date("M j, Y H:i:s");
function fixdatetimelong($datetime){
	if($datetime == "0000-00-00 00:00:00" || $datetime == "0000-00-00"){
		return "N/A";
	}
	else{
		return date("M j, Y H:i:s", strtotime($datetime));
	}
}
//format date("d/m/Y")
function fixdatepicker($date){
	if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
		return "0000-00-00";
	}
	else{
		return date("d/m/Y", strtotime($date));
	}
}
//format date("Y-m-d")
function db_fixdate($date){
	if(empty($date)){
		return NULL;
	}
	else{
		return date("Y-m-d", strtotime($date));
	}
}
//format datetime date("Y-m-d H:i:s")
function db_fixdatetime($datetime){
	if(empty($datetime)){
		return NULL;
	}
	else{
		return date("Y-m-d H:i:s", strtotime($datetime));
	}
}
//show how long ago, given datetime format date("Y-m-d H:i:s")
function formatDateAgo($value){
    $time = strtotime($value);
    $d = new \DateTime($value);

    $weekDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $months = array('January', 'February', 'March', 'April',' May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

    if ($time > strtotime('-2 minutes')){
        return 'A few seconds ago';
    }
    elseif ($time > strtotime('-30 minutes')){
        return floor((strtotime('now') - $time)/60) . ' mins ago';
    }
    elseif ($time > strtotime('today')){
        return $d->format('G:i');
    }
    elseif ($time > strtotime('yesterday')){
        return 'Yesterday, ' . $d->format('G:i');
    }
    elseif ($time > strtotime('this week')){
        return $weekDays[$d->format('N') - 1] . ', ' . $d->format('G:i');
    }
    else{
        return $d->format('j') . ' ' . $months[$d->format('n') - 1] . ', ' . $d->format('G:i');
    }
}
//Generate password
function hashedPassword($str_pass) {
	return password_hash($str_pass, PASSWORD_DEFAULT);
}
//Redirect function
function redirect($to) {
    if (!headers_sent())
        header('Location: '.$to);
    else {
        return '<script type="text/javascript">
        window.location.href="'.$to.'";
        </script>
        <noscript>
        <meta http-equiv="refresh" content="0;url='.$to.'">
        </noscript>';
    }
	exit();
}
//This function separates the extension from the rest of the file name and returns it
//For Instance, jpg, gif or png
function findexts($filename) { 
	$filename = strtolower($filename); 
	$exts = end(explode('.', $filename));
	return $exts;
}
//Remove apostrophes on names
function removeApostrophe($str){
	$stripped = strip_slashes_recursive($str);
	return str_replace("'", "", $stripped);
}
//Return current page URL
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
// Get user IP
function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
//Saves error logs to a folder within the website (logs). System admin can view these logs at the back-end
function saveSysErrLogs($err_log){
	global $logs_dir;
	
	$filename = "$logs_dir/system_logs.txt";
	
	// Let's make sure the file exists and is writable first.
	if (is_writable($filename)) {	
		// Write the contents to the file, 
		// using the FILE_APPEND flag to append the content to the end of the file
		// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
		if(file_put_contents($filename, $err_log, FILE_APPEND | LOCK_EX) === FALSE){
			return false;
		}
		return true;
	}else{
		return false;
	}
}
//Capture error and send
function Error_alertAdmin($error_type, $error_msg, $page, $reply_to){
	//Variables
	global $class_dir;
	include "config.php";
	require_once("$class_dir/phpmailer/class.phpmailer.php");
	
	$Subject = SYSTEM_SHORT_NAME." Error Report Generated ".date('d_m_Y');
	$Log_date = date('d-m-Y H:i:s');
	$Source = getUserIP();
	$MySQL_Version = db_version();
	$PHP_Version = phpversion();

	//SAVE ERROR LOG TO FILE//
	$ErrorLog = "<p><strong>Log Date:</strong> $Log_date<br>
	<strong>Error Type:</strong> $error_type<br>
	<strong>Page:</strong> $page<br>
	<strong>Error Captured:</strong> $error_msg</p>";
	
	saveSysErrLogs($ErrorLog);
	
	//SEND ERROR ALERTS//
	// Mail function
	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	//safe error capture
	$Message = "<html><head>
	<title>$Subject</title>
	</head><body><p>Dear Administrator, <br><br>The following error was reported on ".SYSTEM_SHORT_NAME." website. <br>Error Type: $error_type<br>Page: $page<br>Log Date: $Log_date<br>MySQL Version: $MySQL_Version<br>PHP Version: $PHP_Version<br>Error Captured: <br><strong>$error_msg</strong><br><br>".strtoupper(SYSTEM_SHORT_NAME)." ERROR NOTIFICATIONS<br>Website: ".PARENT_HOME_URL."</p></body>
	</html>";
	
	$body = preg_replace('/\\\\/','', $Message); //Strip backslashes
	
	switch(MAILER){
		case 'smtp':
		$mail->isSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = SMTP_AUTH; // enable SMTP authentication
		$mail->SMTPSecure = SMTP_SECU; // sets the prefix to the servier
		$mail->Host = SMTP_HOST; // SMTP server
		$mail->Port = SMTP_PORT; // set the SMTP port for the HOST server
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
		break;
		case 'sendmail':
		$mail->isSendmail(); // telling the class to use SendMail transport
		break;
		case 'mail':
		$mail->isMail(); // telling the class to use mail function
		break;
	}
	
	$mail->SetFrom(INFO_EMAIL, INFO_NAME);	
	$mail->Subject = $Subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test		
	$mail->MsgHTML($body);
	$mail->IsHTML(true); // send as HTML
	//$mail->AddAddress(SUPPORT_EMAIL, SUPPORT_NAME); //Notify Support Team
	$mail->AddAddress(DEVELOPER_EMAIL, DEVELOPER_NAME); //Notify Webmaster
	
	if(isset($reply_to)) { $mail->AddReplyTo($reply_to); } //Add REPLY-TO if provided
	
	// Send email to the website administrator
	if($mail->Send()){
		return true;
	}else{
		return false;
	}
	
}
//Allowed documents for upload
function allowed_doc_mime_types(){
	return array(
	'text/richtext',
	'application/pdf',
	'application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'application/vnd.ms-excel',
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'application/vnd.ms-powerpoint',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation');
}
//Generate a friendly name
function friendlyName($name){//post slug
	$name= mb_strtolower(replace_accents($name), 'UTF-8');
	return preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('','-',''),$name);
}
//Help generate friendly name
function replace_accents($var){ //replace for accents catalan spanish and more
    $a = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', '�', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', '�', '�', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', '�', '�', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', '�', 'Z', 'z', 'Z', 'z', '�', '�', '?', '�', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $var= str_replace($a, $b,$var);
    return $var;
}
//Check for duplicate entry
function checkDuplicateEntry($sqlCheck){
	global $conn;
	//Set the result and run the query
	$resultCheck = db_query($sqlCheck,DB_NAME,$conn);
	//check if any results were returned
	if(db_num_rows($resultCheck)>0){
		return true;
	}else{
		return false;
	}
}
//generates a select tag with the values specified on the sql, 2nd parameter name for the combo, , 3rd value selected if there's
function sqlOption($query,$name,$option,$empty="",$error="",$classes=""){
	global $conn;
	
	$result = db_query($query,DB_NAME,$conn);//$query: 1 value needs to be the ID, second the Name, if there's more doens't work	
	$sqloption = "<select ".$error." name=\"".$name."\" id=\"".$name."\" class=\"".$classes."\">";
	$sqloption .= '<option value="'.$empty.'">'.$empty.'</option>';
	if(db_num_rows($result)>0) {
	  while($row = db_fetch_array($result,$mode=true)){
		  if ($option==$row[0]) { $sel="selected=selected";}
		  $sqloption .=  "<option ".$sel." value='".$row[0]."'>" .$row[1]. "</option>";
		  $sel="";
	  }
	}
	$sqloption .= "</select>";
	return $sqloption;
}
//generates a select with multi select options
function sqlOptionMulti($query,$name,$options,$error="",$classes=""){
	global $conn;
	
	$result = db_query($query,DB_NAME,$conn);//$query: 1 value needs to be the ID, second the Name, if there's more doens't work
	$sqloption = "<select ".$error." name=\"".$name."[]\" class=\"".$classes."\" multiple=\"multiple\" rows=\"20\">";
	while($row = db_fetch_array($result,$mode=true)){		
		$values = explode(",", $options);
		if(in_array($row[0], $values)){
			$sel='selected="selected"';
		}else{
			$sel="";
		}
		$sqloption .=  "<option ".$sel." value='".$row[0]."'>" .$row[1]. "</option>";
		$sel="";
	}
	$sqloption .= "</select>";
	return $sqloption;
}
//generates a select tag with the values specified on the sql, 2nd parameter name for the combo, , 3rd value selected if there's
function sqlOptionGroup($query,$name,$option,$empty="",$error="",$classes=""){
	global $conn;
	
	$result = db_query($query,DB_NAME,$conn);//$query: 1 value needs to be the ID, second the Name, 3rd is the group
	//echo $sql;
	$sqloption = "<select ".$error." name=\"".$name."\" id=\"".$name."\" class=\"".$classes."\">
    <option value=\"\">".$empty."</option>";
	$lastLabel = "";
	if(db_num_rows($result)>0) {
	  while($row = db_fetch_array($result,$mode=true)){
  
		  if($lastLabel != $row[2]){
			  if($lastLabel != ""){
				  $sqloption .= "</optgroup>";
			  }
			  $sqloption .= "<optgroup label='$row[2]'>";
			  $lastLabel = $row[2];
		  }
  
		  if ($option==$row[0]) { $sel="selected=selected";}
		  $sqloption .=  "<option ".$sel." value='".$row[0]."'>" .$row[1]. "</option>";
		  $sel="";
	  }
	  $sqloption .= "</optgroup>";
	}
	$sqloption .= "</select>";
	return $sqloption;
}
//
function get_yesno_status($status){
	foreach(list_yesno_status() as $k => $v){
		if($k == $status){
			return $v;
		}
	}
}
//Array of yes/no status
function list_yesno_status(){
	return array(
	"1" => "Yes",
	"0" => "No");
}
//Array of enable/disable status
function list_enable_status(){
	return array(
	"0" => "Yes",
	"1" => "No");
}
//Array of title status
function list_gender_status(){
	return array(	
	"Male" => "Male",
	"Female" => "Female");
}
//Array of title status
function list_title_status(){
	return array(	
	"Dr." => "Dr.",
	"Prof." => "Prof.",
	"Fr." => "Fr.",	
	"Mr." => "Mr.",
	"Mrs." => "Mrs.",
	"Miss." => "Miss.",
	"Rev." => "Rev.",
	"Pr." => "Pr.");
}
//Array of navigation list
function list_display_limiter(){
	return array(
	"10" => "10",
	"30" => "30",
	"50" => "50",
	"100" => "100",
	"150" => "150",
	"200" => "200");
}
//currency rate
function currencyRate($CurrencyCode, $SwitchCurrencyCode){
	$CurrencyCode = "USD";
	$SwitchCurrencyCode = "KES";
	$ch = curl_init("http://download.finance.yahoo.com/d/quotes.csv?s=$CurrencyCode$SwitchCurrencyCode=X&f=l1&e=.csv");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_NOBODY, false);
	$RateUSDKES = curl_exec($ch);
	curl_close($ch);
	
	return $RateUSDKES;
}
//
function currencyConverter($TotalAmount, $RateUSDKES){
	if( !empty($RateUSDKES) ){
		$totalamt = ($TotalAmount * $RateUSDKES);
	}
	return $totalamt;
}
function formattedPrice($ConvertedPrice, $CurrencyCode){
	if( !empty($ConvertedPrice) && !empty($CurrencyCode) ){
		
		// English notation, with 2 decimal points
		$formattedPrice = number_format($ConvertedPrice,2);
		
		switch ($CurrencyCode){
			case "USD";
				$Code = "$";
			break;
			case "EUR";
				$Code = "�";
			break;
			case "GBP":
				$Code = "�";
			break;
			case "KES":
				$Code = "Ksh";
			break;
			case "TZS":
				$Code = "Tsh";
			break;
			case "UGX":
				$Code = "Sh";
			break;
		}
		return $Code.$formattedPrice;
	}
}
//Get country name given the country shortcode
function get_country($shortcode){
	foreach(list_countries() as $k => $v){
		if($k == $shortcode){
			return $v;
		}
	}
}
//Array of countries in the world
function list_countries(){
	return array(
            
	"AF" => "Afghanistan",
	"AL" => "Albania",
	"DZ" => "Algeria",
	"AS" => "American Samoa",
	"AD" => "Andorra",
	"AO" => "Angola",
	"AI" => "Anguilla",
	"AQ" => "Antarctica",
	"AG" => "Antigua And Barbuda",
	"AR" => "Argentina",
	"AM" => "Armenia",
	"AW" => "Aruba",
	"AU" => "Australia",
	"AT" => "Austria",
	"AZ" => "Azerbaijan",
	"BS" => "Bahamas",
	"BH" => "Bahrain",
	"BD" => "Bangladesh",
	"BB" => "Barbados",
	"BY" => "Belarus",
	"BE" => "Belgium",
	"BZ" => "Belize",
	"BJ" => "Benin",
	"BM" => "Bermuda",
	"BT" => "Bhutan",
	"BO" => "Bolivia",
	"BA" => "Bosnia And Herzegowina",
	"BW" => "Botswana",
	"BV" => "Bouvet Island",
	"BR" => "Brazil",
	"IO" => "British Indian Ocean Territory",
	"BN" => "Brunei Darussalam",
	"BG" => "Bulgaria",
	"BF" => "Burkina Faso",
	"BI" => "Burundi",
	"KH" => "Cambodia",
	"CM" => "Cameroon",
	"CA" => "Canada",
	"CV" => "Cape Verde",
	"KY" => "Cayman Islands",
	"CF" => "Central African Republic",
	"TD" => "Chad",
	"CL" => "Chile",
	"CN" => "China",
	"CX" => "Christmas Island",
	"CC" => "Cocos (Keeling) Islands",
	"CO" => "Colombia",
	"KM" => "Comoros",
	"CG" => "Congo",
	"CD" => "Congo, The Democratic Republic Of The",
	"CK" => "Cook Islands",
	"CR" => "Costa Rica",
	"CI" => "Cote D'Ivoire",
	"HR" => "Croatia (Local Name: Hrvatska)",
	"CU" => "Cuba",
	"CY" => "Cyprus",
	"CZ" => "Czech Republic",
	"DK" => "Denmark",
	"DJ" => "Djibouti",
	"DM" => "Dominica",
	"DO" => "Dominican Republic",
	"TP" => "East Timor",
	"EC" => "Ecuador",
	"EG" => "Egypt",
	"SV" => "El Salvador",
	"GQ" => "Equatorial Guinea",
	"ER" => "Eritrea",
	"EE" => "Estonia",
	"ET" => "Ethiopia",
	"FK" => "Falkland Islands (Malvinas)",
	"FO" => "Faroe Islands",
	"FJ" => "Fiji",
	"FI" => "Finland",
	"FR" => "France",
	"FX" => "France, Metropolitan",
	"GF" => "French Guiana",
	"PF" => "French Polynesia",
	"TF" => "French Southern Territories",
	"GA" => "Gabon",
	"GM" => "Gambia",
	"GE" => "Georgia",
	"DE" => "Germany",
	"GH" => "Ghana",
	"GI" => "Gibraltar",
	"GR" => "Greece",
	"GL" => "Greenland",
	"GD" => "Grenada",
	"GP" => "Guadeloupe",
	"GU" => "Guam",
	"GT" => "Guatemala",
	"GN" => "Guinea",
	"GW" => "Guinea-Bissau",
	"GY" => "Guyana",
	"HT" => "Haiti",
	"HM" => "Heard And Mc Donald Islands",
	"VA" => "Holy See (Vatican City State)",
	"HN" => "Honduras",
	"HK" => "Hong Kong",
	"HU" => "Hungary",
	"IS" => "Iceland",
	"IN" => "India",
	"ID" => "Indonesia",
	"IR" => "Iran (Islamic Republic Of)",
	"IQ" => "Iraq",
	"IE" => "Ireland",
	"IL" => "Israel",
	"IT" => "Italy",
	"JM" => "Jamaica",
	"JP" => "Japan",
	"JO" => "Jordan",
	"KZ" => "Kazakhstan",
	"KE" => "Kenya",
	"KI" => "Kiribati",
	"KP" => "Korea, Democratic People's Republic Of",
	"KR" => "Korea, Republic Of",
	"KW" => "Kuwait",
	"KG" => "Kyrgyzstan",
	"LA" => "Lao People's Democratic Republic",
	"LV" => "Latvia",
	"LB" => "Lebanon",
	"LS" => "Lesotho",
	"LR" => "Liberia",
	"LY" => "Libyan Arab Jamahiriya",
	"LI" => "Liechtenstein",
	"LT" => "Lithuania",
	"LU" => "Luxembourg",
	"MO" => "Macau",
	"MK" => "Macedonia, Former Yugoslav Republic Of",
	"MG" => "Madagascar",
	"MW" => "Malawi",
	"MY" => "Malaysia",
	"MV" => "Maldives",
	"ML" => "Mali",
	"MT" => "Malta",
	"MH" => "Marshall Islands",
	"MQ" => "Martinique",
	"MR" => "Mauritania",
	"MU" => "Mauritius",
	"YT" => "Mayotte",
	"MX" => "Mexico",
	"FM" => "Micronesia, Federated States Of",
	"MD" => "Moldova, Republic Of",
	"MC" => "Monaco",
	"MN" => "Mongolia",
	"MS" => "Montserrat",
	"MA" => "Morocco",
	"MZ" => "Mozambique",
	"MM" => "Myanmar",
	"NA" => "Namibia",
	"NR" => "Nauru",
	"NP" => "Nepal",
	"NL" => "Netherlands",
	"AN" => "Netherlands Antilles",
	"NC" => "New Caledonia",
	"NZ" => "New Zealand",
	"NI" => "Nicaragua",
	"NE" => "Niger",
	"NG" => "Nigeria",
	"NU" => "Niue",
	"NF" => "Norfolk Island",
	"MP" => "Northern Mariana Islands",
	"NO" => "Norway",
	"OM" => "Oman",
	"PK" => "Pakistan",
	"PW" => "Palau",
	"PA" => "Panama",
	"PG" => "Papua New Guinea",
	"PY" => "Paraguay",
	"PE" => "Peru",
	"PH" => "Philippines",
	"PN" => "Pitcairn",
	"PL" => "Poland",
	"PT" => "Portugal",
	"PR" => "Puerto Rico",
	"QA" => "Qatar",
	"RE" => "Reunion",
	"RO" => "Romania",
	"RU" => "Russian Federation",
	"RW" => "Rwanda",
	"KN" => "Saint Kitts And Nevis",
	"LC" => "Saint Lucia",
	"VC" => "Saint Vincent And The Grenadines",
	"WS" => "Samoa",
	"SM" => "San Marino",
	"ST" => "Sao Tome And Principe",
	"SA" => "Saudi Arabia",
	"SN" => "Senegal",
	"SC" => "Seychelles",
	"SL" => "Sierra Leone",
	"SG" => "Singapore",
	"SK" => "Slovakia (Slovak Republic)",
	"SI" => "Slovenia",
	"SB" => "Solomon Islands",
	"SO" => "Somalia",
	"ZA" => "South Africa",
	"GS" => "South Georgia, South Sandwich Islands",
	"ES" => "Spain",
	"LK" => "Sri Lanka",
	"SH" => "St. Helena",
	"PM" => "St. Pierre And Miquelon",
	"SD" => "Sudan",
	"SR" => "Suriname",
	"SJ" => "Svalbard And Jan Mayen Islands",
	"SZ" => "Swaziland",
	"SE" => "Sweden",
	"CH" => "Switzerland",
	"SY" => "Syrian Arab Republic",
	"TW" => "Taiwan",
	"TJ" => "Tajikistan",
	"TZ" => "Tanzania, United Republic Of",
	"TH" => "Thailand",
	"TG" => "Togo",
	"TK" => "Tokelau",
	"TO" => "Tonga",
	"TT" => "Trinidad And Tobago",
	"TN" => "Tunisia",
	"TR" => "Turkey",
	"TM" => "Turkmenistan",
	"TC" => "Turks And Caicos Islands",
	"TV" => "Tuvalu",
	"UG" => "Uganda",
	"UA" => "Ukraine",
	"AE" => "United Arab Emirates",
	"GB" => "United Kingdom",
	"US" => "United States",
	"UM" => "United States Minor Outlying Islands",
	"UY" => "Uruguay",
	"UZ" => "Uzbekistan",
	"VU" => "Vanuatu",
	"VE" => "Venezuela",
	"VN" => "Viet Nam",
	"VG" => "Virgin Islands (British)",
	"VI" => "Virgin Islands (U.S.)",
	"WF" => "Wallis And Futuna Islands",
	"EH" => "Western Sahara",
	"YE" => "Yemen",
	"YU" => "Yugoslavia",
	"ZM" => "Zambia",
	"ZW" => "Zimbabwe");
}

//myn
$countries = array("AF" => "Afghanistan",
"AX" => "Åland Islands",
"AL" => "Albania",
"DZ" => "Algeria",
"AS" => "American Samoa",
"AD" => "Andorra",
"AO" => "Angola",
"AI" => "Anguilla",
"AQ" => "Antarctica",
"AG" => "Antigua and Barbuda",
"AR" => "Argentina",
"AM" => "Armenia",
"AW" => "Aruba",
"AU" => "Australia",
"AT" => "Austria",
"AZ" => "Azerbaijan",
"BS" => "Bahamas",
"BH" => "Bahrain",
"BD" => "Bangladesh",
"BB" => "Barbados",
"BY" => "Belarus",
"BE" => "Belgium",
"BZ" => "Belize",
"BJ" => "Benin",
"BM" => "Bermuda",
"BT" => "Bhutan",
"BO" => "Bolivia",
"BA" => "Bosnia and Herzegovina",
"BW" => "Botswana",
"BV" => "Bouvet Island",
"BR" => "Brazil",
"IO" => "British Indian Ocean Territory",
"BN" => "Brunei Darussalam",
"BG" => "Bulgaria",
"BF" => "Burkina Faso",
"BI" => "Burundi",
"KH" => "Cambodia",
"CM" => "Cameroon",
"CA" => "Canada",
"CV" => "Cape Verde",
"KY" => "Cayman Islands",
"CF" => "Central African Republic",
"TD" => "Chad",
"CL" => "Chile",
"CN" => "China",
"CX" => "Christmas Island",
"CC" => "Cocos (Keeling) Islands",
"CO" => "Colombia",
"KM" => "Comoros",
"CG" => "Congo",
"CD" => "Congo, The Democratic Republic of The",
"CK" => "Cook Islands",
"CR" => "Costa Rica",
"CI" => "Cote D'ivoire",
"HR" => "Croatia",
"CU" => "Cuba",
"CY" => "Cyprus",
"CZ" => "Czech Republic",
"DK" => "Denmark",
"DJ" => "Djibouti",
"DM" => "Dominica",
"DO" => "Dominican Republic",
"EC" => "Ecuador",
"EG" => "Egypt",
"SV" => "El Salvador",
"GQ" => "Equatorial Guinea",
"ER" => "Eritrea",
"EE" => "Estonia",
"ET" => "Ethiopia",
"FK" => "Falkland Islands (Malvinas)",
"FO" => "Faroe Islands",
"FJ" => "Fiji",
"FI" => "Finland",
"FR" => "France",
"GF" => "French Guiana",
"PF" => "French Polynesia",
"TF" => "French Southern Territories",
"GA" => "Gabon",
"GM" => "Gambia",
"GE" => "Georgia",
"DE" => "Germany",
"GH" => "Ghana",
"GI" => "Gibraltar",
"GR" => "Greece",
"GL" => "Greenland",
"GD" => "Grenada",
"GP" => "Guadeloupe",
"GU" => "Guam",
"GT" => "Guatemala",
"GG" => "Guernsey",
"GN" => "Guinea",
"GW" => "Guinea-bissau",
"GY" => "Guyana",
"HT" => "Haiti",
"HM" => "Heard Island and Mcdonald Islands",
"VA" => "Holy See (Vatican City State)",
"HN" => "Honduras",
"HK" => "Hong Kong",
"HU" => "Hungary",
"IS" => "Iceland",
"IN" => "India",
"ID" => "Indonesia",
"IR" => "Iran, Islamic Republic of",
"IQ" => "Iraq",
"IE" => "Ireland",
"IM" => "Isle of Man",
"IL" => "Israel",
"IT" => "Italy",
"JM" => "Jamaica",
"JP" => "Japan",
"JE" => "Jersey",
"JO" => "Jordan",
"KZ" => "Kazakhstan",
"KE" => "Kenya",
"KI" => "Kiribati",
"KP" => "Korea, Democratic People's Republic of",
"KR" => "Korea, Republic of",
"KW" => "Kuwait",
"KG" => "Kyrgyzstan",
"LA" => "Lao People's Democratic Republic",
"LV" => "Latvia",
"LB" => "Lebanon",
"LS" => "Lesotho",
"LR" => "Liberia",
"LY" => "Libyan Arab Jamahiriya",
"LI" => "Liechtenstein",
"LT" => "Lithuania",
"LU" => "Luxembourg",
"MO" => "Macao",
"MK" => "Macedonia, The Former Yugoslav Republic of",
"MG" => "Madagascar",
"MW" => "Malawi",
"MY" => "Malaysia",
"MV" => "Maldives",
"ML" => "Mali",
"MT" => "Malta",
"MH" => "Marshall Islands",
"MQ" => "Martinique",
"MR" => "Mauritania",
"MU" => "Mauritius",
"YT" => "Mayotte",
"MX" => "Mexico",
"FM" => "Micronesia, Federated States of",
"MD" => "Moldova, Republic of",
"MC" => "Monaco",
"MN" => "Mongolia",
"ME" => "Montenegro",
"MS" => "Montserrat",
"MA" => "Morocco",
"MZ" => "Mozambique",
"MM" => "Myanmar",
"NA" => "Namibia",
"NR" => "Nauru",
"NP" => "Nepal",
"NL" => "Netherlands",
"AN" => "Netherlands Antilles",
"NC" => "New Caledonia",
"NZ" => "New Zealand",
"NI" => "Nicaragua",
"NE" => "Niger",
"NG" => "Nigeria",
"NU" => "Niue",
"NF" => "Norfolk Island",
"MP" => "Northern Mariana Islands",
"NO" => "Norway",
"OM" => "Oman",
"PK" => "Pakistan",
"PW" => "Palau",
"PS" => "Palestinian Territory, Occupied",
"PA" => "Panama",
"PG" => "Papua New Guinea",
"PY" => "Paraguay",
"PE" => "Peru",
"PH" => "Philippines",
"PN" => "Pitcairn",
"PL" => "Poland",
"PT" => "Portugal",
"PR" => "Puerto Rico",
"QA" => "Qatar",
"RE" => "Reunion",
"RO" => "Romania",
"RU" => "Russian Federation",
"RW" => "Rwanda",
"SH" => "Saint Helena",
"KN" => "Saint Kitts and Nevis",
"LC" => "Saint Lucia",
"PM" => "Saint Pierre and Miquelon",
"VC" => "Saint Vincent and The Grenadines",
"WS" => "Samoa",
"SM" => "San Marino",
"ST" => "Sao Tome and Principe",
"SA" => "Saudi Arabia",
"SN" => "Senegal",
"RS" => "Serbia",
"SC" => "Seychelles",
"SL" => "Sierra Leone",
"SG" => "Singapore",
"SK" => "Slovakia",
"SI" => "Slovenia",
"SB" => "Solomon Islands",
"SO" => "Somalia",
"ZA" => "South Africa",
"GS" => "South Georgia and The South Sandwich Islands",
"ES" => "Spain",
"LK" => "Sri Lanka",
"SD" => "Sudan",
"SR" => "Suriname",
"SJ" => "Svalbard and Jan Mayen",
"SZ" => "Swaziland",
"SE" => "Sweden",
"CH" => "Switzerland",
"SY" => "Syrian Arab Republic",
"TW" => "Taiwan, Province of China",
"TJ" => "Tajikistan",
"TZ" => "Tanzania, United Republic of",
"TH" => "Thailand",
"TL" => "Timor-leste",
"TG" => "Togo",
"TK" => "Tokelau",
"TO" => "Tonga",
"TT" => "Trinidad and Tobago",
"TN" => "Tunisia",
"TR" => "Turkey",
"TM" => "Turkmenistan",
"TC" => "Turks and Caicos Islands",
"TV" => "Tuvalu",
"UG" => "Uganda",
"UA" => "Ukraine",
"AE" => "United Arab Emirates",
"GB" => "United Kingdom",
"US" => "United States",
"UM" => "United States Minor Outlying Islands",
"UY" => "Uruguay",
"UZ" => "Uzbekistan",
"VU" => "Vanuatu",
"VE" => "Venezuela",
"VN" => "Viet Nam",
"VG" => "Virgin Islands, British",
"VI" => "Virgin Islands, U.S.",
"WF" => "Wallis and Futuna",
"EH" => "Western Sahara",
"YE" => "Yemen",
"ZM" => "Zambia",
"ZW" => "Zimbabwe");

//price convertor
function wits_money($number) { 
    $number=number_format((float)(ceil($number / 10) * 10), 2, '.', '');
   if ($number < 0) { 
     $print_number = "(Ksh " . str_replace('-', '', number_format (round($number), 2, ".", ",")) . ")"; 
    } else { 
     $number=number_format((float)(ceil($number / 10) * 10), 2, '.', '');
     $print_number = "Ksh " .  number_format (round($number), 2, ".", ",") ; 
   } 
   return $print_number; 
} 

//for the dollar
function wits_money_dollar($number) { 
   if ($number < 0) { 
     $print_number = "Ksh " . ceil(str_replace('-', '', number_format (round($number), 2, ".", ",")) / 10)* 10 . ")"; 
    } else { 
     $print_number = "Ksh " .  ceil(number_format (round($number), 2, ".", ","))/ 10 * 10; 
   } 
   return $print_number; 
}

  $dummyImagy='http://via.placeholder.com/350x400';  
  
  //sending sms
  function tumaSms($recipients,$message){ 
    // Be sure to include the file you've just downloaded
require_once('AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "sandbox";
//live
#$apikey = "76029b664392bcea225dcab171f29551f4907bfd1263806cbf360568893ed07d";
//sand
$apikey = "d488921e7927bcd242138a73c6dae1f00d397684cf8ea094dd51ad9b82613779";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
//$recipients = "+254726294074";
// And of course we want our recipients to know what we really do
//$message    = "I'm a lumberjack and its ok, I sleep all night and I work all day";
// Create a new instance of our awesome gateway class
//$gateway    = new AfricasTalkingGateway($username, $apikey);
$gateway  = new AfricasTalkingGateway($username, $apikey, "sandbox");
/*************************************************************************************
  NOTE: If connecting to the sandbox:
  1. Use "sandbox" as the username
  2. Use the apiKey generated from your sandbox application
     https://account.africastalking.com/apps/sandbox/settings/key
  3. Add the "sandbox" flag to the constructor
  $gateway  = new AfricasTalkingGateway($username, $apiKey, "sandbox");
**************************************************************************************/
// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
 /* foreach($results as $result) {   
    echo " Number: " .$result->number;
    echo " Status: " .$result->status;
    echo " MessageId: " .$result->messageId;
    echo " Cost: "   .$result->cost."\n";
  }*/
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}
    
} 

//mpesa                    
function isAssoc(array $arr){
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function getAccessToken($consumer_key, $consumer_secret){
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';//access toekn request url
   $keys_separater=":";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    $credentials = base64_encode($consumer_key.$keys_separater.$consumer_secret);// a base64 
    //encoding of consumer secret and consumer key separated by :
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Basic '.$credentials)); //setting a custom header
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);					
    $curl_response = curl_exec($curl);
    $data = json_decode($curl_response, true);
    $accessToken= $data['access_token'];
    return $accessToken;
}

function getPassword($Shortcode, $Passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'){
    //be found here : https://developer.safaricom.co.ke/test_credentials
    if(empty($Shortcode)){
        return "System_detected_empty_parameter";
        exit();  
    }else{
    $Timestamp = date('Ymdhis');//timestamp 
    $Password = base64_encode($Shortcode.$Passkey.$Timestamp);
    return $Password;
    }
}
function preparePostData($Shortcode, $Password, $callback, array $transactionData){
   if(!is_array($transactionData)){
       return "Bad_transaction_data_format_array_expected";
       exit();
   }elseif(count($transactionData) > 4){
        return "Transaction_data_too_long_for_the_system";
        exit();
   }elseif(isAssoc($transactionData)==true){
        return "Transaction_data_is_associative_sequential_expected";
        exit();
   }elseif(count($transactionData) < 4){
        return "Transaction_data_too_short_for_the_system";
        exit();
   }elseif(empty($Shortcode) || empty($Password) || empty($callback) || empty($transactionData)){
        return "System_detected_empty_parameter";
        exit();
   }else{
        $customerPhone=$transactionData[0];
        $payAmt=$transactionData[1];
        $acRef=$transactionData[2];
        $transDesc=$transactionData[3];
        $Timestamp = date('Ymdhis');   //timestamp
    $curl_post_data = array(
        "BusinessShortCode" => $Shortcode,//business receiving payment, paybill number
        "Password" => $Password,    //a base 64 encode of shortcode, passkey and timestamp
        "Timestamp" => $Timestamp,     //time in Ymdhis formart
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $payAmt,    //amount charged
        "PartyA" => $customerPhone,   //customer
        "PartyB" => $Shortcode,   //business receiving payment
        "PhoneNumber" => $customerPhone,    //customer
        "CallBackURL" => $callback,      //use https://developer.safaricom.co.ke for test
        "AccountReference" => $acRef,     //transaction ref.. can be invoice number
        "TransactionDesc" => $transDesc
    );

    return $curl_post_data;
 }
}
function InitiatePayRequest($curl_post_data, $accessToken){
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';//test url
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$accessToken)); //access token from previous request
    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    $res = json_decode($curl_response);
    return $res;
}
function RegisterHTTPUrl($shortCode, $confirmURL, $validateURL, $accessToken){  
    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$accessToken)); //setting custom header
    $curl_post_data = array(
      'ShortCode' => $shortCode,
      'ResponseType' => 'JSON',
      'ConfirmationURL' => $confirmURL,
      'ValidationURL' => $validateURL
    );
    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    $resp = json_decode($curl_response);
    return $resp;
}

//validate
function properMSISDN($MSISDN){                                                         
                                                                //Remove any parentheses and the numbers they contain:
                                                                $n = preg_replace("/\([0-9]+?\)/", "", $MSISDN);
                                                                //Strip spaces and non-numeric characters:
                                                                $n = preg_replace("/[^0-9]/", "", $n);
                                                                //Strip KE country code
                                                                $n = substr($n, 3);                                                            
                                                                //Strip out leading zeros:
                                                                $n = ltrim($n, '0');
                                                                //Add KE country code without plus sign
                                                                $n = "254".$n;
                                                                
        return $n;
    }
    
   $leta_head=' <div style="background:#f5e005;text-align:center; width: 100%; float: left;"><a href="#" target="_blank" style="display:block;text-align: center;border-bottom:2px solid #0000;"><img src="http://dev.letabox.co.ke/images/logo-mid.png" style="margin:0 auto;max-width:160px;" alt="Letabox" /></a>
</div>';
$leta_futa='<div style="background:#f5e005;color:#fff;border-top:2px solid #0000;padding:18px;width: 100%; float: left;"><span style="color:black;">&copy; Letabox  </span><div style="width:49%;text-align:right;float:right">Powered by <a href="https://agencyafrica.com" title="Wits Technologies" target="_blank"><img width="90" style="vertical-align:-12px;    margin-right: 7% !important;font-size:13px;color:#39B54A;" alt="Wits Technologies" src="http://www.witshosting.net/cms/wp-content/themes/witstechnologies/img/wits-logo-large.png" /></a></div>';



