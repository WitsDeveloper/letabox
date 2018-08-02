<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
   require 'dbconfig.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '2131719597111934','84e8b0cecb5a397f06a3250bbba57b65' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://dev.letabox.co.ke/f_b/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=id,name,email' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	   /* $_SESSION['FBID'] = $fbid;           
            $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
            $_SESSION['user_id'] = $fbid;
               $_SESSION['user_id'] = $row_log['lbs_bill_shipping_id'];
               $UserID=$_SESSION['user_id'];
                $_SESSION['Fname'] = $row_log['Fname']; 
                $_SESSION['Email'] = $row_log['Email']; */
           //checkuser($fuid,$ffname,$femail);
         //live code
 $null='null';
 $null_int='0';
 $null_date='0000-00-00 00:00:00'; 
 $OrderID_Cart = 'dummy'; 
                      $Fname = $fbfullname; 
                        $Lname = $null; 
                        $Company= $null; 
                        $Country = $null; 
                        $Address1 =$null; 
                        $Address2= $null; 
                        $City= $null; 
                        $State= $null; 
                        $Zcode = $null; 
                        $Email = $femail; 
                        $Phone = ''; 
                        $encryptedPassword = '';  
                        $regDate=date("Y-m-d h:i:s");
                        $my_kart= $_POST["my_kart"]; 
                        $my_total= $_POST["my_total"];
                        $oauth_uid=$fbid;
                        $oauth_provider='facebook';
                        $active='activated';

$check = $mysqli->query("SELECT * FROM lbs_customer WHERE  Email='$femail'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);

//if no record
if ($check->num_rows <1) {
  
   $query = "INSERT INTO lbs_customer (OrderID_Cart,Fname,Lname,Company,Country,Address1,Address2,City,State,Zcode,Phone,Email,Password,regDate,oauth_provider,"
        . "oauth_uid,date_modified,activate,comcode) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);

$statement->bind_param('issssssssssssssisss', $OrderID_Cart,$Fname,$Lname,$Company,$Country,$Address1,$Address2,$City,$State,$Zcode,$Phone,$Email,$encryptedPassword,$regDate,$oauth_provider,$oauth_uid,$null,$null,$active);
//;
if(!$statement->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
$lbs_bill_shipping_id=$mysqli->insert_id;
$lbs_bill_shipping_id=base64_encode($lbs_bill_shipping_id);
print "<script language=\"javascript\"> 
var myurl='../signup.php?ID=$lbs_bill_shipping_id'
window.location.assign(myurl)
</script>";
   // print 'To insert';
}
	 else {   	
     $row = $check->fetch_object();
    $found_oauth_uid=$row->oauth_uid;
     if($found_oauth_uid!=0){
    $_SESSION['user_id'] = $row->lbs_bill_shipping_id;
   $UserID = $_SESSION['user_id'];
   $_SESSION['Fname'] = $row->Fname;
  $_SESSION['Email'] = $row->Email;  
  print "<script language=\"javascript\"> 
var myurl='../index.php'
window.location.assign(myurl)
</script>";
         
     }   
        
           if($found_oauth_uid==0){   
$lbs_bill_shipping_id=$row->lbs_bill_shipping_id;
$sql = $mysqli->query("UPDATE lbs_customer SET oauth_uid='$oauth_uid',oauth_provider='$oauth_provider' WHERE lbs_bill_shipping_id = '$lbs_bill_shipping_id'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
  $_SESSION['user_id'] = $row->lbs_bill_shipping_id;
  $UserID = $_SESSION['user_id'];
  $_SESSION['Fname'] = $row->Fname;
  $_SESSION['Email'] = $row->Email; 

print "<script language=\"javascript\"> 
var myurl='../index.php'
window.location.assign(myurl)
</script>";
                    
                }
        
         }

        
    /* ---- header location after session ----*/
//header("Location: http://dev.letabox.co.ke/signup.php?ID=$lbs_bill_shipping_id");
  //header("Location: index.php");
} else {
  $loginUrl = $helper->getLoginUrl();
   // $loginUrl = $helper->getLoginUrl( array('scope' => 'email,read_stream'));
 header("Location: ".$loginUrl);
}

//likya users
//require_once 'functions.php';
?>

