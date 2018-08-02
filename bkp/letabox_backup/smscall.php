 <?php
 
 require_once('includes/AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "sandbox";
$apikey     = "d488921e7927bcd242138a73c6dae1f00d397684cf8ea094dd51ad9b82613779";
 $status = $_POST['status']; //This contains the status as described above
 $messageId = $_POST['id']; //This is the messageId received when the message was sent
 //This parameter is passed when status is Rejected or Failed.
 if($status == "Failed" || $status == "Rejected"){
  print  $failureReason = $_POST['failureReason']; 
 }
 else{
 
 print "sent"; }
 
 
 ?>