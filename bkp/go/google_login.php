<?php
require('http.php');
require('oauth_client.php');
require('config.php');


$client = new oauth_client_class;

// set the offline access only if you need to call an API
// when the user is not present and the token may expire
$client->offline = FALSE;

$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = REDIRECT_URL;

$client->client_id = CLIENT_ID;
$application_line = __LINE__;
$client->client_secret = CLIENT_SECRET;

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to Google APIs console page ' .
          'http://code.google.com/apis/console in the API access tab, ' .
          'create a new client ID, and in the line ' . $application_line .
          ' set the client_id to Client ID and client_secret with Client Secret. ' .
          'The callback URL must be ' . $client->redirect_uri . ' but make sure ' .
          'the domain is valid and can be resolved by a public DNS.');

/* API permissions
 */
$client->scope = SCOPE;
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
              'https://www.googleapis.com/oauth2/v1/userinfo', 'GET', array(), array('FailOnAccessError' => true), $user);
    }
  }
  $success = $client->Finalize($success);
}
if ($client->exit)
  exit;
if ($success) {
	
	//new params
	$null='null';
 $null_int='0';
 $null_date='0000-00-00 00:00:00'; 
 $OrderID_Cart = 'dummy'; 
                      $Fname = $user->name; 
                        $Lname = $null; 
                        $Company= $null; 
                        $Country = $null; 
                        $Address1 =$null; 
                        $Address2= $null; 
                        $City= $null; 
                        $State= $null; 
                        $Zcode = $null; 
                        $Email = $user->email; 
                        $Phone = ''; 
                        $encryptedPassword = '';  
                        $regDate=date("Y-m-d h:i:s");
                        $my_kart= $_POST["my_kart"]; 
                        $my_total= $_POST["my_total"];
                        $oauth_uid=$user->id;
                        $oauth_provider='Google';
                        $active='activated';
  // Now check if user exist with same email ID
   	$check = $mysqli->query("SELECT * FROM lbs_customer WHERE  Email='$Email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
#if no records
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

 
    } else {
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
 /* $resultx = $mysqli->query("SELECT * FROM lbs_customer WHERE oauth_uid='$oauth_uid' LIMIT 1") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
 while ($row_logx = $resultx->fetch_assoc()) { 
     $_SESSION['user_id']= $row_logx['lbs_bill_shipping_id'];
       $UserID=$_SESSION['user_id'];
        $_SESSION['Fname'] = $Fname; 
         $_SESSION['Email'] = $Email;
            
            
        }*/
    }
  }/* catch (Exception $ex) {
    $_SESSION["e_msg"] = $ex->getMessage();
  }*/

  //$_SESSION["user_id"] = $user->id;
 else {
  $_SESSION["e_msg"] = $client->error;
}
/*if ($check->num_rows <1) {
header("location:../signup.php?ID=$lbs_bill_shipping_id");
}
else{
   header("location:../index.php"); 
}*/
exit;
?>