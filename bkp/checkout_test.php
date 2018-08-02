<?php

//sendy test
//Variables
//$sendy_api_url = "https://api.sendyit.com/v1/";
$sendy_api_url = "https://api.sendyit.com/v1/";
//$sendy_api_url = "https://apitest.sendyit.com/v1/";
$google_maps_api_key = "AIzaSyBAgQ-vCy1106_l1iZFudZeYQGx2ghCS3g";

$billing_state = "Harry Thuku Rd, Nairobi, Kenya";

//end sendy test
require_once 'apiconn.php';
require_once 'partials/config.php';

$header = array(
    'page'=>'checkout',
    'title'=>'Checkout page'
);
require_once 'partials/header.php';
require_once("classes/auth/class.OAuth.php");

#universal
define("CALLBACK", "http://dev.letabox.co.ke/call.php");
define("MPESA_KEY", "w22mBbxtoZkuism8EFGAIG22I3j8G2CY");
define("MPESA_SECRET", "7M5n2mQI97je3c4N");

if(isset($_POST['pay']) && !empty($_POST['Phone'])){
//$phone = formatPhone($_POST['Phone']);
$phone = $_POST['Phone'];
$Amt = 10;
$paybill = 174379;
$invoice = 13244;
$transactionDesc = 'Test payment';
$transactionData = array($phone, $Amt, $invoice, $transactionDesc);
$URLresponse = RegisterHTTPUrl($paybill, $CALLBACK, $CALLBACK, getAccessToken(MPESA_KEY, MPESA_SECRET));
print_r($URLresponse);
$post_data = preparePostData($paybill, getPassword($paybill), CALLBACK, $transactionData);
$response = InitiatePayRequest($post_data, getAccessToken(MPESA_KEY, MPESA_SECRET));
echo '<pre>';
print_r($response);
echo '</pre>';
}
?>
  <form action=" " method="post"/>
    <div class="row">
      <div class="col-md-12 checkout_formp">  
        <p>
        <label for="name">Full Name</label>
        </p>
        <p>
        <label for="Phone">Phone</label>
        <input type="text" name="Phone" id="Phone" class="form-control" value="" >
        </p>
        <p><button type="submit" name="pay" class="btn btn-lg">Pay now</button>
      </div>
    </div>
  </form>