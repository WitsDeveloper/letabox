<?php 
////GETTING THE FILE INPUT
session_start();
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
//mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require 'includes/mailer/vendor/autoload.php';
$mailFrom='info@letabox.co.ke';
//end mailer
$postData = file_get_contents('php://input');
//$postData = '{"Body":{"stkCallback":{"MerchantRequestID":"6339-331731-1","CheckoutRequestID":"ws_CO_08052018140656765","ResultCode":0,"ResultDesc":"The service request is processed successfully.","CallbackMetadata":{"Item":[{"Name":"Amount","Value":10.00},{"Name":"MpesaReceiptNumber","Value":"ME80ALYZR8"},{"Name":"Balance"},{"Name":"TransactionDate","Value":20180508140751},{"Name":"PhoneNumber","Value":254705007984}]}}}}';
   

   $payResponse = json_decode($postData, TRUE); 
   
      $CheckoutRequestID=$payResponse["Body"]["stkCallback"]["CheckoutRequestID"];
      $ResultCode=$payResponse["Body"]["stkCallback"]["ResultCode"];
      $ResultDesc=$payResponse["Body"]["stkCallback"]["ResultDesc"];
        
        
        $Date=date("Y-m-d h:i:s"); 
   
$query = "INSERT INTO lbs_mpesa_calls (TransactionID,ResultCode,Descr,Date) VALUES(?,?,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('ssss', $CheckoutRequestID,$ResultCode,$ResultDesc,$Date) or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
if($statement->execute()){
    
    //update payments table
$statement_query = $mysqli->query("UPDATE lbs_payments SET Status='$ResultCode' WHERE TransactionID='$CheckoutRequestID'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
    
//mail
//get order ID
$project_desc1 = $mysqli->query("SELECT * from lbs_payments WHERE TransactionID='$CheckoutRequestID'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona1= $project_desc1->fetch_object();
$orderId=$obj_ona1->orderId;

//$project_desc1y = $mysqli->query("SELECT * FROM lbs_order a LEFT JOIN set_user_supervisor b ON a.EMP_ID = b.SUP_NAME WHERE b.SUP_NAME IS NULL")or die('Error : ('. $mysqli->errno .') '. $mysqli->error); 
//get user ID
$project_desc133 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$orderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona133= $project_desc133->fetch_object();
$lbs_bill_shipping_id=$obj_ona133->lbs_bill_shipping_id;
//update orders table
$orderUpt = $mysqli->query("UPDATE lbs_order SET Payment_state='$ResultCode',TransactionID='$CheckoutRequestID' WHERE OrderId='$orderId'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
 

//get user email
//get user ID
$project_desc133s = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$lbs_bill_shipping_id'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona133s= $project_desc133s->fetch_object();
$Email=$obj_ona133s->Email;
if($ResultCode==0){
 $body="Your Payment has been received.</br> Order ID #".$orderId."<br/>We Shall inform you on the processing ";
}
else{
    $body="Your Payment has failed.</br> Order ID #".$orderId."<br/>Reason:<b>".$ResultDesc."</b>"; 
}
 $mail = new PHPMailer(true);                            
try {                              
    $mail->isSMTP();                                   
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                             
    $mail->Username = 'mwakah89@gmail.com';                
    $mail->Password = '2813gmaduqu!#';                    
    $mail->SMTPSecure = 'tls';                          
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom,'Letabox' );
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($mailFrom, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Order #'.$OrderId.' Payment';
    $mail->Body=$body;
    $mail->send();
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;    
}  
    
  
    
    
}





    ?>
