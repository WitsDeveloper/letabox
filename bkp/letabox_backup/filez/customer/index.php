<?php
/*********************************************
Company:	Wits Technologies Ltd
Developer:	Sammy Mwaura Waweru
Mobile:		+254721428276
Email:		sammy@witstechnologies.co.ke
Website:	http://www.witstechnologies.co.ke/
*********************************************/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

$incl_dir = "../includes";
$class_dir = "../classes";
$logs_dir = "../logs";

include "$incl_dir/config.php";
require_once("$incl_dir/functions.php");
require_once("customer.functions.php");
require_once("$class_dir/class.validator.php3");
require_once("$class_dir/phpmailer/class.phpmailer.php");

add_header();

//check if we have a return URL
$url = isset($_GET["url"])?$_GET["url"]:"customer.php"; 
$returnurl = urldecode($url);
//$username = isset($_GET["username"])?$_GET["username"]:"";
$username = isset($_COOKIE["custusername"])?$_COOKIE["custusername"]:"";
//$password = isset($_COOKIE["custpassword"])?$_COOKIE["custpassword"]:"";

$do = isset($_GET["do"])?$_GET["do"]:""; 
$do = strtolower($do); 
switch($do) {
case "":
	if(checkLoggedin()){
		if(!empty($returnurl)){
			redirect($returnurl);
		}else{
			if(isValidCustomer()){
				$returnurl = "customer.php";
				redirect($returnurl);
			}else{
				$_SESSION['message'] = ErrorMessage("Access denied: Your account is not activated to access this area.");
				markLoggedout();
				clearsessionscookies();
			}
		}
    }else{
		require_once('customer.login.php');
	}
break;
case "activate":
	require_once('customer.activate.php');
break;
case "reset":
	require_once('customer.reset.php');
break;
case "login": 
    $username = isset($_POST["uname"])?strtolower(trim($_POST["uname"])):""; 
    $password = isset($_POST["upass"])?trim($_POST["upass"]):"";
	//Check if username or password fields have been set
    if ($username == "" || $password == ""){
		$_SESSION['message'] = ErrorMessage("Username or password is blank"); 
        redirect("?error=invalid_login"); 
    }else{ 
        if(confirmUser($username,$password)){ 
            createsessions($username,$password);
			markLoggedin($username);
            redirect("?url=".$returnurl);
        }else{
			//If can't login, attempt these procedures...else...chase the user OUT!
			if(!resetLoginSession($username)){
				$_SESSION['message'] = ErrorMessage("Invalid username and/or password");
				clearsessionscookies(); 
				redirect("?url=".$returnurl); 
			}else{
				if(confirmUser($username,$password)){
					createsessions($username,$password);
					markLoggedin($username);
					redirect("?url=".$returnurl);
				}
			}
        } 
    } 
break;
case "logout":
	markLoggedout();
	clearsessionscookies();
    redirect("./"); 
break; 
}
unset($_SESSION['message']);

add_footer();

ob_flush();
?>