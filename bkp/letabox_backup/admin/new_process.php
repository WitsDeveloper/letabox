 <?php

$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

$leta_head=' <div style="background:#f5e005;text-align:center; width: 100%; float: left;"><a href="#" target="_blank" style="display:block;text-align: center;border-bottom:2px solid #0000;"><img src="http://dev.letabox.co.ke/images/logo-mid.png" style="margin:0 auto;max-width:160px;" alt="Letabox" /></a>
</div>';
$leta_futa='<div style="background:#f5e005;color:#fff;border-top:2px solid #0000;padding:18px;width: 100%; float: left;"><span style="color:black;">&copy; Letabox  </span><div style="width:49%;text-align:right;float:right">Powered by <a href="https://agencyafrica.com" title="Wits Technologies" target="_blank"><img width="90" style="vertical-align:-12px;    margin-right: 7% !important;font-size:13px;color:#39B54A;" alt="Wits Technologies" src="http://www.witshosting.net/cms/wp-content/themes/witstechnologies/img/wits-logo-large.png" /></a></div>';



//mailer
//mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require '../includes/mailer/vendor/autoload.php';
$mailFrom='info@letabox.co.ke';
 
        if(isset($_POST['add_customerr'])){
//print '<script type="text/javascript">'.'alert("error.");'.'</script>';
   // global $mysqli;
	 $null='null';
   $null_int='0';
   $null_date='0000-00-00 00:00:00'; 

                          //shipping & billing details        
                     $OrderID_Cart = $_POST["OrderID"]; 
                        $Fname = $_POST["Fname"]; 
                        $Lname = $null; 
                        $Company= $null; 
                        $Country = $null; 
                        $Address1 = $_POST["Address1"]; 
                        $Address2= $null; 
                        $City= $_POST["City"]; 
                        $State= $null; 
                        $Zcode = $_POST["Zcode"]; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"]; 
                        $encryptedPassword = md5(@$_POST["Password"]);  
                        $regDate=date("Y-m-d h:i:s");
                        $my_kart= $_POST["my_kart"]; 
                        $my_total= $_POST["my_total"];                        
                                                    
$query = "INSERT INTO lbs_customer (OrderID_Cart,Fname,Lname,Company,Country,Address1,Address2,City,State,Zcode,Phone,Email,Password,regDate,oauth_provider,"
        . "oauth_uid,date_modified) VALUES(?, ? ,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);

$statement->bind_param('issssssssssssssis', $OrderID_Cart,$Fname,$Lname,$Company,$Country,$Address1,$Address2,$City,$State,$Zcode,$Phone,$Email,$encryptedPassword,$regDate,$null,$null_date,$null);

if(!$statement->execute()){
        print '<script type="text/javascript">'.'alert("error.");'.'</script>';
    //die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    
}
else{
//$_SESSION['MSG'] = ConfirmMessage("New customer has been added successfully");   
     print '<script type="text/javascript">'.'alert("Order Placed.");'.'</script>';
     redirect("admin.php?tab=5");
}
            

	

    
}

//place order

        if(isset($_POST["add_order"])){
            global $mysqli;
		// Customer info		
		$OrderDate= $_POST['OrderDate'];
                $date = DateTime::createFromFormat('d/m/Y',$OrderDate);
                $regDate=$date->format("Y-m-d");                
		$Status = $_POST['Status'];
		$lbs_customer= $_POST['lbs_customer'];
                $shipping_cost = 0;
		$OrderTotal=$_POST['OrderTotal'];
                $Order_comments= $_POST['orderRemarks'];
                $query2 = "INSERT INTO  lbs_order (lbs_bill_shipping_id,shipping_cost,Status,OrderTotal,orderRemarks,OrderDate) VALUES(?,?,?,?,?,?)";
$statement2 = $mysqli->prepare($query2);
$statement2->bind_param('ssssss', $lbs_customer,$shipping_cost,$Status,$OrderTotal,$Order_comments,$regDate);
//$statement2->execute();
if(!$statement2->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}

//$_SESSION['MSG'] = ConfirmMessage("Announcement added successfully");
 print '<script type="text/javascript">'.'alert("Order Placed.");'.'</script>';
     
                          print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3'
       window.location.assign(myurl)
       </script>"; 


                
        }
        
            if(isset($_POST["process_order"])){
            global $mysqli;
            
		// Customer info
            $OrderId=$_POST['orderId'];
                $processeDate=date("Y-m-d h:i:s");
                $pocessedBy=$_POST['processedBy'];    
                $from=@$_POST['from'];
		$Status = $_POST['Status'];                 
 $statement = $mysqli->query("UPDATE lbs_order SET processedBy='$pocessedBy',processeDate='$processeDate',"
            . "Status='$Status'"        
         . " WHERE OrderId='$OrderId'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
    
  //update status hist              
     updateOrder($OrderId,$pocessedBy,$Status,$processeDate, $mysqli);
//mail
$project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona1= $project_desc1->fetch_object();
$userId=$obj_ona1->lbs_bill_shipping_id;

$project_desc133 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$userId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona133= $project_desc133->fetch_object();
$Email=$obj_ona133->Email;
 $body="<hr>Your Order has been successfully proccessed.</br> Order ID #".$OrderId."<br/>We Shall inform you once its ready for pick Up ";
 $mail = new PHPMailer(true);                            
try {  
    //$mail->SMTPDebug = 1;                              
    $mail->isSMTP();                                   
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                             
    $mail->Username = 'mwakah89@gmail.com';                
    $mail->Password = '2813gmaduqu!#';                    
    $mail->SMTPSecure = 'tls';                          
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($mailFrom, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Order #'.$OrderId.' Processed';
    $mail->Body=$leta_head.$body.$leta_futa;
    $mail->send();
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;    
}
 print '<script type="text/javascript">'.'alert("Order Processed.");'.'</script>';
     
                      if($from==='admin')  {  print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3&task=process&OrderId=$OrderId'
       window.location.assign(myurl)
       </script>"; 
                      } 
                      
                      else{
                          print "<script language=\"javascript\"> 
      var myurl='staff.php?tab=2&task=process&OrderId=$OrderId'
       window.location.assign(myurl)
       </script>";
                          
                      }


                
        }
        
        //ready to pick
             if(isset($_POST["to_pick"])){
            global $mysqli;
            
		// Customer info
            $OrderId=$_POST['OrderId'];
                $processeDate=date("Y-m-d h:i:s");               
                $from=@$_POST['from'];
                           $pocessedBy=$_POST['processedBy']; 
		$Status = $_POST['Status'];                 
 $statement = $mysqli->query("UPDATE lbs_order SET Status='$Status' WHERE OrderId='$OrderId'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
    
   //update status hist              
     updateOrder($OrderId,$pocessedBy,$Status,$processeDate, $mysqli);
 
//mailer
 $project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona1= $project_desc1->fetch_object();
$userId=$obj_ona1->lbs_bill_shipping_id;

$project_desc133 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$userId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona133= $project_desc133->fetch_object();
$Email=$obj_ona133->Email;
 $body="Your Order has is ready to pick.</br> Order ID #".$OrderId."<br/> ";
 $mail = new PHPMailer(true);                            
try {  
    //$mail->SMTPDebug = 1;                              
    $mail->isSMTP();                                   
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                             
    $mail->Username = 'mwakah89@gmail.com';                
    $mail->Password = '2813gmaduqu!#';                    
    $mail->SMTPSecure = 'tls';                          
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($mailFrom, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Order #'.$OrderId.' Ready for pickup';
    $mail->Body=$leta_head.$body.$leta_futa;
    $mail->send();
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;    
}
 print '<script type="text/javascript">'.'alert("Order Processed.");'.'</script>';
     
                      if($from==='admin')  {  print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3'
       window.location.assign(myurl)
       </script>"; 
                      } 
                      
                      else{
                          print "<script language=\"javascript\"> 
      var myurl='staff.php?tab=2'
       window.location.assign(myurl)
       </script>";
                          
                      }


                
        }
        
        //for picked orders
         //ready to pick
             if(isset($_POST["picked"])){
            global $mysqli;
            
		// Customer info
            $OrderId=$_POST['OrderId'];
                $processeDate=date("Y-m-d h:i:s");               
                $from=@$_POST['from'];
		$Status = $_POST['Status']; 
           $pocessedBy=$_POST['processedBy'];                 
 $statement = $mysqli->query("UPDATE lbs_order SET Status='$Status' WHERE OrderId='$OrderId'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   //update status hist              
     updateOrder($OrderId,$pocessedBy,$Status,$processeDate, $mysqli);

   //mailer
$project_desc1 = $mysqli->query("SELECT * from lbs_order WHERE OrderId='$OrderId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona1= $project_desc1->fetch_object();
$userId=$obj_ona1->lbs_bill_shipping_id;

$project_desc133 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$userId'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);     
$obj_ona133= $project_desc133->fetch_object();
$Email=$obj_ona133->Email;
 $body="<hr>Your Order has been successfully Picked/released.</br> Order ID #".$OrderId."<br/>Incase of any issue call us on 0789898989 ";
 $mail = new PHPMailer(true);                            
try {  
    //$mail->SMTPDebug = 1;                              
    $mail->isSMTP();                                   
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                             
    $mail->Username = 'mwakah89@gmail.com';                
    $mail->Password = '2813gmaduqu!#';                    
    $mail->SMTPSecure = 'tls';                          
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($mailFrom, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Order #'.$OrderId.' Picked';
    $mail->Body=$leta_head.$body.$leta_futa;
    $mail->send();
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;    
} 
 

 print '<script type="text/javascript">'.'alert("Order has been Picked/released to the customer.");'.'</script>';
     
                      if($from==='admin')  {  print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=3'
       window.location.assign(myurl)
       </script>"; 
                      } 
                      
                      else{
                          print "<script language=\"javascript\"> 
      var myurl='staff.php?tab=2'
       window.location.assign(myurl)
       </script>";
                          
                      }


                
        }
        //admin settings
        if(isset($_POST["SAVE_CONF"])){
            global $mysqli;      
$SHIPPING_RATE=$_POST['SHIPPING_RATE'];
$TAX_RATE=$_POST("TAX_RATE");    
$MARGIN=$_POST("MARGIN"); 
$userId=$_SESSION['sysUserID'];
$regDate=date("Y-m-d h:i:s");

$query = "INSERT  INTO lbs_settings(TAXATION,MARGIN,SHIPPING_RATE,userID,lbs_settings_date) VALUES(?, ? ,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('sssss', $TAX_RATE,$MARGIN,$SHIPPING_RATE,$userId,$regDate) or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
if($statement->execute()){

 print '<script type="text/javascript">'.'alert("Settings saved.");'.'</script>';     
                 
        print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=7'
       window.location.assign(myurl)
       </script>";       
                


}
}

        
        //order status
      function updateOrder($OrderId, $pocessedBy, $Status,$processeDate,$mysqli) {
    $update = $mysqli->query("INSERT INTO lbs_order_history VALUES('','$OrderId','$pocessedBy','$Status','$processeDate')")  or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
      }
        
        ?>
