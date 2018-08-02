<?php
session_start(); 
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

//get IP ADDRESS
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
   $null='null';
   $null_int='0';
   $null_date='0000-00-00 00:00:00'; 
require_once 'partials/config.php';

//mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require 'includes/mailer/vendor/autoload.php';
$mailFrom='info@letabox.co.ke';
      
    
if(isset($_POST["product_code"]))
{
   $product_code=$_POST["product_code"];
	foreach($_POST as $key => $value){
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING); 
	}
          $new_product["title"] = $_POST['title'];
          $new_product["price"] = $_POST['price'];
          $new_product["sellCost"] = $_POST['sellCost'];
         $new_product["weight"] = $_POST['weight'];
          $new_product["quantity"] = $_POST['quantity'];     
          $new_product["thumbnail"] = $_POST['thumbnail'];   
          $new_product["product_url"] = $_POST['product_url']; 
          
          //new for order_margins
                    $new_product["totalCost_Usd"] = $_POST['totalCost_Usd'];
                      $new_product["totalCost_Ksh"] = $_POST['totalCost_Ksh'];
                        $new_product["convertedSellingcost_Ksh"] = $_POST['convertedSellingcost_Ksh'];
                          $new_product["convertedSellingcost_Usd"] = $_POST['convertedSellingcost_Usd'];
                            $new_product["profitKes"] = $_POST['profitKes'];
                              $new_product["profitUsd"] = $_POST['profitUsd'];
                              $new_product["margin"] = $_POST['margin'];
                              
             //end new for order_margins
          
          
          
          
		if(isset($_SESSION["productsx"])){  //if session var already exist
			if(isset($_SESSION["productsx"][$new_product['product_code']])) //check item exist in products array
			{
				//unset($_SESSION["productsx"][$new_product['product_code']]); //unset old item
        $_SESSION["productsx"][$new_product['product_code']]["quantity"] = $_SESSION["productsx"][$new_product['product_code']]["quantity"] + $_POST["quantity"];
			}
                        else {
				$_SESSION["productsx"][$new_product['product_code']] = $new_product;
			}
		}
                
                //update products with new item array
                else{
		
		$_SESSION["productsx"][$new_product['product_code']] = $new_product;	
                }
	
	
 	$total_items = count($_SESSION["productsx"]); 
	die(json_encode(array('items'=>$total_items,'product_code'=>$product_code))); 

}

if(isset($_POST["load_cartx"]) && $_POST["load_cart"]==1)
{
	if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ 
		$cart_box = '<table class="cart-products-loaded table table-bordered">';
                $cart_box .=  "<tr> <th>Product</th><th>Quantity </th><th>Price: </th></tr>";

		$total = 0;
		foreach($_SESSION["productsx"] as $product){ 
                    
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                        $product_price = $product["price"]; 
                        $sellCost = $product["sellCost"]; 
                          $weight = $product["weight"];
                    
                        $product_qty = $product["quantity"]; 
                        $thumbnail=$product["thumbnail"]; 
                        
                        $qty_input='<input type="number" data-code="'.$product_code.'" class="form-control text-center quantity_2" value="'.$product_qty.'">';
                        
                         $currency='Kes';  
$cart_box .=  "<tr class='cart-item'> <td>".$product_title."</td><td>". $qty_input ."</td><td>"."$sellCost"." <a href=\"#\" class=\"remove-item2\" data-code=\"$product_code\">X</a></td></tr>";
			
                         $subtotal = ($sellCost * $product_qty);
			$total = ($total + $subtotal);
   	}
		$cart_box .= "</table>";
		$cart_box .= '<table style"width:40% !important; float:right !important;" class=" table table-bordered" >'
          . '<tr><td>Subtotal</td><td><div id="wits_cart_tot" class="cart-products-total">Total : '.$currency.sprintf("%01.2f",$total).' </div></td><tr>'
           . '<tr><td>TOTAL</td><td><div id="wits_cart_tot2" class="cart-products-total">Total : '.$currency.sprintf("%01.2f",$total).' </div></td><tr><table>'
                        . '<a onclick="goBack()" class="btn btn-success btn-lg" style="margin-right:6px;">Continue shopping</a>'
                        . '<a href="checkout.php" class="btn btn-warning btn-lg">proceed to check out</a>';
                //$cart_box .= '<div id="savve_cart"><a href="cart_process.php?act=save_kkart" id="save_kkart" class="save-kart" data-code="'.$product_code.'">Save</a></div>';
		
                die($cart_box); 
          
	}else{
		die("Your Cart is empty"); 
	}
}

//start clone
if(isset($_POST["load_cart-S"]) && $_POST["load_cartS"]==2||isset($_POST["loadS_cart"]) && $_POST["loadS_cart"]==33)
{

	if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ //if we have session variable
		$cart_box2 = '<ul class="cart-products-loaded2">';
		//$total = 0;
		foreach($_SESSION["productsx"] as $product){ 
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                         $product_price = $product["price"]; 
                         $product_qty=1;
                         $currency='Kes';
                        
                      $cart_box2 .='<li class="cart-item alert alert-dismissable"> <a data-code="'.$product_code.'" class="close remove-item" >&times;</a> <img class="img-responsive" src="http://via.placeholder.com/70x50" alt=""> </li>';
     
                        //$subtotal = ($product_price * $product_qty);
			//$total = ($total + $subtotal);
		}
		$cart_box2 .= "</ul>";
		//$cart_box .= '<div class="cart-products-total">Total : '.$currency.sprintf("%01.2f",$total).' <u><a href="view_cart.php" title="Review Cart and Check-Out">Check-out</a></u></div>';
		die($cart_box2); //exit and output content
	}else{
		die("Your Cart is empty"); //we have empty cart
	}
}

//end clone
        
    
        if(isset($_GET["remove_code"]) && isset($_SESSION["productsx"]))
{
	$product_code   = filter_var($_GET["remove_code"], FILTER_SANITIZE_STRING); 

	if(isset($_SESSION["productsx"][$product_code]))
	{
		unset($_SESSION["productsx"][$product_code]);
	}
	
 	$total_items = count($_SESSION["productsx"]);
	die(json_encode(array('items'=>$total_items)));
}

/*if(@($_GET["act"]==='save_kkart') && isset($_SESSION["productsx"]))*/
    if(isset($_POST["cart_code"])&& isset($_SESSION["productsx"]))
{

foreach($_SESSION["productsx"] as $product){ 
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                         $product_price = $product["price"]; 

$query = "INSERT INTO sample_orders (sample_orders_pdt_id, sample_orders_pdt_name,sample_orders_pdt_price) VALUES(?, ? ,?)";
$statement = $mysqli->prepare($query);

$statement->bind_param('sss', $product_code, $product_title,$product_price);

if($statement->execute()){
    unset($_SESSION['productsx']);    
   // echo '<script language="javascript">'. 'alert("saved")'.'</script>';
    echo 'cart saved';

}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}
//$statement->close();
                
}

}

# Update cart product quantity
if(isset($_GET["update_quantity"]) && isset($_SESSION["productsx"])) {	
	if(isset($_GET["quantityx"]) && $_GET["quantityx"]>0) {		
		$_SESSION["productsx"][$_GET["update_quantity"]]["quantity"] = $_GET["quantityx"];	
	}
	$total_product = count($_SESSION["productsx"]);
	die(json_encode(array('products'=>$total_product)));
}


//save checkout
//if(isset($_POST["post_checkout"]))


//sign up

//if(isset($_POST["leta_signup"] ))   
if(isset($_POST["hidden_signup"] )) 
    {
$errors= array();  	// array to hold validation errors
$data= array();
                        $Fname = $_POST["Fname"]; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"];
                        $userID= $_POST["social_media"];
                        
                    
                        if(isset($_POST["Address1"])){
                            $Address1 = @$_POST["Address1"];    
                        }
                        else{
                           $Address1 = 'N/A';      
                        }
                        $Confirm = $_POST["Confirm"]; 
                        $com_code = md5(uniqid(rand()));
                        
                        $null='';
                        $nullint=0;
                        $OrderID_Cart = 'dummy';
                     
                        //$encryptedPassword = md5($_POST["Password"]);  
                        $encryptedPassword = hashedPassword($_POST["Password"]); 
                        
                        $regDate=date("Y-m-d h:i:s");
          if($_POST["Password"]!=$Confirm){
            $errors['confirm'] = 'Paswords dont match.';        
            }
            //check if we have the email
        
   $result = $mysqli->query("SELECT * FROM lbs_customer WHERE  Email='$Email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
if ($result->num_rows > 0) {
 $errors['tukonamail'] = 'Email in use.';  
}
  $result = $mysqli->query("SELECT * FROM lbs_customer WHERE  Phone='$Phone'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
if ($result->num_rows > 0) {
 $errors['tukonasimu'] = 'Phone Number in use.';  
}
		
            if ( ! empty($errors)) {	
		$data['success'] = false;
		$data['errors']  = $errors;
	}
         else {
             //update
             if(!empty($userID)){
         $customerid=$userID; 
           $statement = $mysqli->query("UPDATE lbs_customer SET Fname='$Fname',Password='$encryptedPassword',"
         . "Lname='$null',Company='$null',Country='$null',Zcode='$null',Address1='$null',Address2='$null',City='$null',State='$null',Phone='$Phone',Email='$Email'"
         . " WHERE lbs_bill_shipping_id='$customerid'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
           
           $lbs_bill_shipping_id=$customerid;
             } else{
           
$query = "INSERT INTO lbs_customer (OrderID_Cart,Fname,Lname,Company,Country,Address1,Address2,City,State,Zcode,Phone,Email,Password,regDate,oauth_provider,oauth_uid,date_modified,activate,comcode) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('issssssssssssssisss', $null,$Fname,$null,$null,$null,$Address1,$null,$null,$null,$null,$Phone,$Email,$encryptedPassword,$regDate,$null,$null,$null,$nullint,$com_code);
//$statement->bind_param('issssssssssssssisss', $OrderID_Cart,$Fname,$Lname,$Company,$Country,$Address1,$Address2,$City,$State,$Zcode,$Phone,$Email,$encryptedPassword,$regDate,$oauth_provider,$oauth_uid,$null,$null,$active);


//$statement->execute();
if(!$statement->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
$lbs_bill_shipping_id=$mysqli->insert_id;
}
//send mail

$com_msg .= "http://dev.letabox.co.ke/confirm.php?passkey=$com_code";
//$body = "Hi.Your new password is:<br>".$password ;
$body="Success in registration. Your Password is:</br> ".$_POST["Password"]."<br/>Click This Link to confirm Your Registration: ".$com_msg;
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
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
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($Email, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'New user registration';
    $mail->Body=$body;
    $mail->send();    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo; 
    die();
}

//end sednd mail

		$data['success'] = true;
		$data['message'] = 'Success!';
	

echo json_encode($data);
         }
}
//if(isset($_POST["leta_signin"] ))
  if(isset($_POST["hidden_signin"] ))    
    {  
    
    $Email=$_POST["Email"];
if(!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)){
      $mgs='invalid_email';
     echo json_encode($mgs);
     die();
}
//$encryptedPassword = md5($_POST["Password"]); 
//$encryptedPassword = hashedPassword($_POST["Password"]); 
$encryptedPassword = $_POST["Password"]; 

$result = $mysqli->query("SELECT * FROM lbs_customer WHERE Email='$Email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error); 
//$result = $mysqli->query("SELECT * FROM lbs_customer WHERE Password='$encryptedPassword' AND Email='$Email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
 while ($row_log = $result->fetch_assoc()) {  

if(password_verify($encryptedPassword, $row_log['Password'])){
    //if ($result->num_rows > 0) {
       
            $pass = $row_log['Password'];
            //if ($pass === $encryptedPassword) {
            if( $row_log['comcode']!='activated'){
       $msg="notactive";
       echo json_encode($msg);
       die();
                
            } else{
                $user_ip=getUserIpAddr();
                $regDate=date("Y-m-d h:i:s");
               $_SESSION['user_id'] = $row_log['lbs_bill_shipping_id'];
               $UserID=$_SESSION['user_id'];
                $_SESSION['Fname'] = $row_log['Fname']; 
                $_SESSION['Email'] = $row_log['Email']; 
                //insert into log table
                $query = "INSERT INTO lbs_customers_logs (UserID,LoginDate,Source) VALUES(?,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('iss', $UserID,$regDate,$user_ip) or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
$statement->execute();
              $msg="success";
       echo json_encode($msg);
            }
          //} 
        }
         else {
         $msg="wrong";
       echo json_encode($msg);
            }
     
    }
   
		
       
}

//my account
//if(isset($_POST["modify_account"]))
  if(isset($_POST["user_id_edit_acc"])){      
   $customer_id = $_POST["user_id_edit_acc"]; 
                        $Fname = @$_POST["Fname"]; 
                        $Lname = @$_POST["Lname"]; 
                        $Confirm = @$_POST["PasswordCon"]; 
                        $encryptedPasswordNew = md5(@$_POST["PasswordNew"]); 
                        $Email = @$_POST["Email"];                                         
                        $regDate=date("Y-m-d h:i:s");   
                  $encryptedPassword = md5(@$_POST["Password"]);  
 
 $result = $mysqli->query("SELECT * FROM lbs_customer WHERE Password='$encryptedPassword'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
    if ($result->num_rows > 0) {
              $statement = $mysqli->query("UPDATE lbs_customer SET Fname='$Fname',"
         . "Lname='$Lname',Phone='$Phone',Email='$Email',Password='$encryptedPasswordNew',date_modified='$regDate'"
         . " WHERE lbs_bill_shipping_id='$customer_id'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
     $success='saved';
     print  json_encode($success);
         
          }
              /*  elseif($_POST["PasswordNew"]!=$Confirm){
            $passcon= 'passconfirmnot.'; 
             print json_encode($passcon);
                            
            }*/
                
          else{
           $wrongpass='passwrong';
           print  json_encode($wrongpass);
              die();
               
          }

}

//if(isset($_POST["billing_edit"])){  
if(isset($_POST["billing_edit"])){      
    
    //$customer_id= $_POST["lbs_bill_shipping_id"]; 
    $customer_id= @$_SESSION['user_id']; 
                        $Fname = $_POST["Fname"]; 
                        //$Lname = $_POST["Lname"]; 
                        //$Company= $_POST["Company"]; 
                        $Country = $_POST["Country"]; 
                        $Address1 = $_POST["Address1"]; 
                        //$Address2= $_POST["Address2"]; 
                        $City= $_POST["City"]; 
                        //$State= $_POST["State"]; 
                        $Zcode = $_POST["Zcode"]; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"]; 
                        $regDate=date("Y-m-d h:i:s");                        
                        //update
    $statement = $mysqli->query("UPDATE lbs_customer SET Fname='$Fname',Country='$Country',"
            . "Address1='$Address1',City='$City',"
            . "Zcode='$Zcode',Email='$Email',Phone='$Phone',date_modified='$regDate'"
         . " WHERE lbs_bill_shipping_id='$customer_id'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
    
   $msg='edited';
   echo json_encode($msg);                        
    
}
//forgot password

if (isset($_POST['forgot_pass'])){
$email = $_POST['Email'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $mgs='invalid_email';
     echo json_encode($mgs);
     die();
}
$check = $mysqli->query("SELECT Email FROM lbs_customer WHERE email = '$email'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
$check2 =$check->num_rows;
if ($check2 == 0) {
  $mgs='no_record';
  echo json_encode($mgs);
  die();
}

$result = $mysqli->query("SELECT * FROM lbs_customer WHERE  Email='$email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
//create a new random password
$password = substr(md5(uniqid(rand(),1)),3,10);
//$str = 'Zb1cdef#6Uag!$*?<';
//$password = str_shuffle($str);
//$password = 'Zb1cdef#6Uag!$*?<';
//$pass = md5($password); //encrypted version for database entry
$pass = hashedPassword($password);
//$pass=password_hash($password, PASSWORD_DEFAULT);


$body = "Hi.Your new password is:<br>".$password ;
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {  
    //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'mwakah89@gmail.com';                 // SMTP username
    $mail->Password = '2813gmaduqu!#';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($email, 'Customer');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($email, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Password Change';
    $mail->Body=$body;
    $mail->send();    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo; 
    die();
}

//update database
$sql = $mysqli->query("UPDATE lbs_customer SET Password='$pass' WHERE Email = '$email'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
if($sql){
    $m='success';
    echo json_encode($m);
}


}



   if(@$_REQUEST['rowid']) {
   $con_id = $_REQUEST['rowid'];
   $pieces = explode("6!#@6", $con_id);
   $TotalCost=$pieces[6];
   $ConvertedTotalCost=$pieces[7];
   $ConvertedSellingCost=$pieces[8];
   $ConvertedTotalCost_Usd=$pieces[9];
   $profitKes=$pieces[10];
   $profitUsd=$pieces[11];
   $marginPercentage=$pieces[12];
   $DetailPageURL=$pieces[13];
   
   //get des

//$source = isset( $_GET['source'] )?$_GET['source']:"";
$productID =$pieces[2]; 
if(!empty($productID) ) {

  $ItemAttributes = array();
  
  $response = $client->lookup($productID);    
  $response  = json_encode( $client->lookup($productID) );  
  $response = json_decode($response, true); 
  if( $response["Items"]["Request"]["IsValid"] ) {    
      if( is_array( $response["Items"]["Item"] ) ) {
          $ASIN = $response["Items"]["Item"]["ASIN"];
 
		
                  
      }
      
  }
  
}
   
   //end des
  ?>



<!--new modal-->
     <div class="quickview" id="quickViewModal">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
            <img src="<?php 
            
          
              if( !empty($pieces[0]) ){
            print $pieces[0];
              } else{
                print $dummyImagy='http://via.placeholder.com/350x400';    
              }
?>" alt="">
            <div>
                <h2><a href=""><?php print $pieces[5];?></a></h2>
                <p class="subtitle">From Amazon</p>
                <?php
                $pricee=round($pieces[3],2);
                ?>
                <h3><?php print wits_money($pricee);?></h3>
              <!-- <p class="rating">Rating <span>4.5</span> out of 250 reviews</p>-->
                <article>
                    <p><?php      echo truncate($EditorialReviewContent2,200);?></p>
                </article>
                <p class="readmore">
                    <!-- <a href="single.php?ID=<?php print $pieces[2];?>" class="button yob-btn">More Details</a>-->
                   <!-- <a href="" class="button boy-btn">Add to Cart</a>-->
                      <form  class="modal_to_cart">
                     
                                             <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                             <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                              <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                                <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                              <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                                <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                                <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                            <!--end new params-->
                                         <input name="price" type="hidden" value="<?php print $pieces[1];?>">
                                           <input name="weight" type="hidden" value="<?php print $pieces[2];?>">
                                         
                                            <input name="sellCost" type="hidden" value="<?php echo print $pieces[3]; ?>">
                                       <input name="title" type="hidden" value="<?php print $pieces[5];?>">
                                       <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                 <input name="product_code" type="hidden" value="<?php print $pieces[4];?>">
                 <input name="thumbnail" type="hidden" value="<?php       if( !empty($pieces[0]) ){
            print $pieces[0];
              } else{
                print $dummyImagy='http://via.placeholder.com/350x400';    
              }?>">
                 <input name="product_url" type="hidden" value="<?php print $DetailPageURL;?>">
                 <!--new params-->
                                            
                                             
                
              
             
                 <a id="vingua_single" href="single.php?ID=<?php print $pieces[4];?>"  class="button small-btn yob-btn yob-btn2" >More Details</a>
                
                  <button type="submit" class="button small-btn boy-btn yob-btn2" >Add to Cart</button>
                  
                 

    </form>
                </div>
            
            <!-- loop for similar pdts-->
            <div class="list similar rex_scroller">
        <div class="container from_quick">
            <br>

            <h3>People who bought this also bought</h3>

            <?php
                //$listItems = 17;
               // include_once 'partials/list.inc.php';
            ?>
            <div class="mob_flex">
            <ul class="slide quick_ul">
            <?php    //Variables
            $productID=$pieces[4];
            if(!empty($productID) ) {
  $ItemAttributes = array();
  
  $response = $client->lookup($productID);
    
  $response  = json_encode( $client->lookup($productID) );
  
  $response = json_decode($response, true);
  //echo $response->Items->Request->IsValid;
  if( $response["Items"]["Request"]["IsValid"] ) {
    
      if( is_array( $response["Items"]["Item"] ) ) {			
              
        $ASIN = $response["Items"]["Item"]["ASIN"];
		  $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
		  $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                  $MediumImageURL = $response["Items"]["Item"]["MediumImage"]["URL"];
		  $ItemAttributes["Binding"] = $response["Items"]["Item"]["ItemAttributes"]["Binding"];
		  $ItemAttributes["Brand"] = $response["Items"]["Item"]["ItemAttributes"]["Brand"];
		  $ItemAttributes["Color"] = $response["Items"]["Item"]["ItemAttributes"]["Color"];
          $ItemAttributes["Manufacturer"] = $response["Items"]["Item"]["ItemAttributes"]["Manufacturer"];
		  $ItemAttributes["Model"] = $response["Items"]["Item"]["ItemAttributes"]["Model"];
		  $ItemAttributes["Size"] = $response["Items"]["Item"]["ItemAttributes"]["Size"];
		  $Title = $response["Items"]["Item"]["ItemAttributes"]["Title"];
          $ListPrice = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]:"";
		  $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
		  $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]:"";
		  $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
		  $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
		  $ConvertedWeight = !empty($Weight)?$Weight/100:0;
		  
		  $Amount = $Amount/100;
		  $BuyingCost = ($Amount+SHIPPING_RATE)*(1+TAX_RATE);
		  $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
		  $TotalCost = $BuyingCost+($ConvertedWeight/2.2*10);
		  $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
		  $ConvertedSellingCost = $ConvertedTotalCost*(1+0.16);
		  $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);                 
                   $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"]["1"]["URL"];
  ?>
               
<?php 
 if(!empty($response["Items"]["Item"]["SimilarProducts"]["SimilarProduct"])){
foreach(array_slice($response["Items"]["Item"]["SimilarProducts"]["SimilarProduct"],0,4) as $value ){ ?>
                <li class="quick_list">
        <?php
                                // $id=$pieces[4];
       //$id=$pieces[4];
        $id=$value["ASIN"];
   $ItemAttributes = array();  
  $response = $client->lookup($id);    
  $response  = json_encode( $client->lookup($id) );  
  $response = json_decode($response, true);
        ?>
        <div class="new_div">
            <?php
              if( $response["Items"]["Request"]["IsValid"] ) {
                if( is_array( $response["Items"]["Item"] ) ) {			
              
    $ASIN = $response["Items"]["Item"]["ASIN"];
    $MediumImageURL2=$response["Items"]["Item"]["MediumImage"]["URL"];
     $Title2 = $response["Items"]["Item"]["ItemAttributes"]["Title"];
      $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
      
      //additional
       $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
		  $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]:"";
	  //determine weight
                      $CatWeight=DEFAULT_WEIGHT;
                        
                       if($response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }
                 
                       else{
                        
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }

                        //newest
                        $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + MARGIN);
                        //new
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/USDKES_RATE;
                        $ConvertedTotalCost_Usd=$ConvertedSellingCost/USDKES_RATE;
                        //end new
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                        #$FormattedPrice = substr_replace($FormattedPrice, '99', -2);
                        
                        //new params
                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/USDKES_RATE;
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=($profitKes/$ConvertedTotalCost)*100;
                        
                        //newest
                  
?>
            <section class="image xx">
                <img src="<?php echo $MediumImageURL2; ?>" alt="">
               <!-- <span>
                    <a href="#" class="button small-btn yob-btn quickViewModal">Quick View</a><br />
                   <!-- <a href="" class="button small-btn boy-btn">Add to Cart</a>
                </span>-->
                 <span>
              <form  class="modal_to_cart">		
                                         <input name="price" type="hidden" value="<?php echo $Amount;?>">
                                          <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost, 2); ?>">    
                                       <input name="title" type="hidden" value="<?php print $Title2;?>">
        <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                 <input name="product_code" type="hidden" value="<?php print $ASIN;?>">
                    <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL2;?>">                 
                                   <input name="product_code" type="hidden" value="<?php print $ASIN;?>">  
                                   <input name="product_url" type="hidden" value="<?php print $DetailPageURL;?>">  
                                   <!--new params-->
                                            
                                               <!--<input name="pdtCat" type="text" value="<?php //print $pdtCat; ?>">-->
                                             <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                             <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                              <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                                <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                              <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                                <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                                <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                            <!--end new params-->
                                   
                                     
                                    
                                   <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>                                        
                                      
                              
    
                                        <button type="submit" class="button small-btn boy-btn" >Add to Cart</button>
                                        <p>
                                            <?php //print $EditorialReviewContent2; ?>
                                        </p>

<!--
                                                                                                             <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>

    <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL.'!#@'.round($ConvertedSellingCost, 2).'!#@'.$ASIN.'!#@'.$Title.'!#@'.$DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->
                               
                                 
                                          </form>
                </span>
            </section>
            <section class="name">
                <h3><a href="single.php?ID=<?php print $id;?>" class="h3_in"><?php if( !empty($Title2) ){
					echo truncate($Title2,40);
				}?></a></h3>
            </section>
            <section class="price">
                <article>
                    <p>From <?php echo 'Amazon'; ?></p>
                    <h4><?php echo wits_money($ConvertedSellingCost); ?></h4>
                </article>
                <p class="right">
                    <span><?php echo $product['likes']; ?></span>
                   <!-- <a href="#" class="wishlist outline"><?php //echo file_get_contents('images/icons/heart.svg'); ?></a>--0-->
                   <!--<form class="wish-form">
                      
                                 
                                   <input name="product_code22" type="hidden" value="<?php print $ASIN;?>"> 
								      <input name="add_to_wish" type="hidden" > 
                                                               
                                                                      <button type="submit" class="wish_btn" name="test_wish" > <img class="wish_img" src="images/icons/heart.png"/></button>
                                                                      </form>-->
                </p>
                <span class="clearfix"></span>
            </section>
            
            <?php
  }
      ?>
            
        </div>
    </li>
 <?php      } }}  
 
 else{
     print 'NO RELATED PRODUCTS!!';
 }
 
                }
    


  } }?>
</ul>
            </div>
            
          
            <span class="clearfix"></span>

        </div>
    </div>
            </div>
            <span class="clearfix"></span>
        </div>
<div id="modal_addcart_response" class="col-md-12">
    
</div>
  
<!--end new modal-->
  <script>
$(document).ready(function(){
      // e.preventDefault();
    	$(".modal_to_cart").submit(function(e){
			var form_data = $(this).serialize();                       
			
		
			$.ajax({	
                            url: "cart_process.php",
				type: "POST",
				dataType:"json", 
				data: form_data
			}).success(function(data){
                                console.log(data);
				$("#cart-info").html(data.items); 
                                $("#zeus_total").html(data.items);
				//button_content.html('Add to Cart');
$("#modal_addcart_response").html('<div class="alert alert-success"><strong>Added to cart..</strong></div>'); 
  $("#modal_addcart_response").fadeOut(4000, function(){ 
    });
					$(".cart-box").trigger( "click" ); 
                                        $(".my_list").trigger( "click" );
                          $("#top-cart-collapse2").load(" #top-cart-collapse2");
                          $("#header_cart").load(" #header_cart");
                            
                          
            
 $("#shopping-cart-results2" ).load( "cart_process.php", {"load_cart":"2"}); 
  //fade out in 5 seconds if not closed
   // $("modal_addcart_response").delay(5000).fadeOut("slow");
 
			})
                        .fail(function(data) {

				console.log(data);
			});
			e.preventDefault();
		});
                
                //open single page
  
                
                
});
     </script>

         
<?php

  
  
  }
  //custom
  if(isset($_POST["customer_quote_id"] )) 
    {                   $Email= $_POST["Email"]; 
     $Phone= $_POST["Phone"]; 
    $yname= $_POST["yname"]; 
                        $url= $_POST["url"]; 
                        $features = $_POST["features"];                         
                        $null=''; 
                        $regDate=date("Y-m-d h:i:s"); 
       
                        
          

$query = "INSERT INTO lbs_custom_orders (lbs_custom_orders_yname,lbs_custom_orders_Email,lbs_custom_orders_Phone,lbs_custom_orders_url,lbs_custom_orders_features,lbs_custom_orders_date) VALUES(?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('ssssss', $yname,$Phone,$yname,$url,$features,$regDate);

//send sms
$recipients = $Phone;
$message    = "You placed a custom Order on Letabox. ";
//tumaSms($recipients, $message);
//end send sms
if($statement->execute()){
    $msg='success'; 
     echo json_encode($msg);
}else{
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

		
}

//WISHLIST
if(isset($_POST["add_to_wish"]))
    {	
          $product_code22 = $_POST['product_code22'];         
          $user_id= @$_SESSION['user_id'];   
          $regDate=date("Y-m-d h:i:s");
            
          
      $result = $mysqli->query("SELECT * FROM lbs_wish WHERE  lbs_wish_productcode='$product_code22' AND lbs_bill_shipping_id='$user_id'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
if ($result->num_rows > 0) {
               $msg= 'wish_iko'; 
               echo json_encode($msg);
		}    
                else{                 
 $query = "INSERT INTO lbs_wish (lbs_wish_productcode,lbs_bill_shipping_id,lbs_wish_date) VALUES(?,?,?)";
$statement = $mysqli->prepare($query);
$statement->bind_param('sis', $product_code22,$user_id,$regDate) or die('Error : ('. $mysqli->errno .') '. $mysqli->error);
if($statement->execute()){
     $msg='success'; 
     echo json_encode($msg);
}
                }
	 

}
    

//new place order
//if(isset($_POST["OrderID"])){
// if(isset($_POST["post_checkout"]))

   if(isset($_POST["checkout_submit"])){  
       
  $null='';
   $null_int='0';
   $null_date='0000-00-00 00:00:00'; 
                          //shipping & billing details        
                     $OrderID_Cart = 'dummy'; 
                          $Fname = $_POST["Fname"]; 
                        $Lname = $null; 
                        $Company= $null; 
                        $Country = $null; 
                        $Address1 = @$_POST["Address1"]; 
                        $Address2= $null; 
                        $City= $null; 
                        $State= $null; 
                        $Zcode = $null; 
                        $Email = $_POST["Email"]; 
                        $Phone = $_POST["Phone"]; 
                        //$encryptedPassword = md5(@$_POST["Password"]);
                        $encryptedPassword = hashedPassword(@$_POST["Password"]); 
                        $regDate=date("Y-m-d h:i:s");
                        $my_kart= $_POST["my_kart"]; 
                        $my_total= $_POST["my_total"];
                        
                        //if from checkout 
                        $comcode='activated';
                     
                       //end if from chckout
                        //print 'this email=>'.$Email;
            
                        //$Order_comments= $_POST["Order_comments"];  
                        //
                        //if there is an account created in the past
                        if(isset($_SESSION['user_id'])){  
                            $customerid=$_SESSION['user_id'];       
          //new
           $statement = $mysqli->query("UPDATE lbs_customer SET Fname='$Fname',"
         . "Lname='$Lname',Company='$Company',Country='$Country',Zcode='$Zcode',Address1='$Address1',Address2='$Address2',City='$City',State='$State',Phone='$Phone',Email='$Email'"
         . " WHERE lbs_bill_shipping_id='$customerid'") or die('Error : ('. $mysqli->errno .') '. $mysqli->error); 
        
      
     $lbs_bill_shipping_id=$customerid;

                        }
                        
                        //end update section
                        else{
                            
                                     //check if we have the email
   $result = $mysqli->query("SELECT * FROM lbs_customer WHERE  Email='$Email'") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
if ($result->num_rows > 0) {
   print '<script type="text/javascript">'.'alert("Email In Use.");'.'</script>';
       print "<script language=\"javascript\"> 
      var myurl='checkout.php'
       window.location.assign(myurl)
       </script>"; 
   die();
           
    
}
  
                            
$query = "INSERT INTO lbs_customer (OrderID_Cart,Fname,Lname,Company,Country,Address1,Address2,City,State,Zcode,Phone,Email,Password,regDate,oauth_provider,"
        . "oauth_uid,date_modified,activate,comcode) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$statement = $mysqli->prepare($query);

$statement->bind_param('issssssssssssssisss', $OrderID_Cart,$Fname,$Lname,$Company,$Country,$Address1,$Address2,$City,$State,$Zcode,$Phone,$Email,$encryptedPassword,$regDate,$null,$null_date,$null,$null,$comcode);
//;
if(!$statement->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
$lbs_bill_shipping_id=$mysqli->insert_id;
                        }

//inser orders
                        
                            //new for sendy
                       // $shipMethod= $_POST["method"];
    $shipMethod = $_POST["method"];   
    if($shipMethod==='sendy'){
      $shipAmount=@$_POST["sendy_cost"];    
    }
    else{
    $shipAmount=0.00;    
    }
  
    $shipcost=@$_POST["chechout_net_total"];
   
       ////end new for sendy
                        if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ 
		$total = 0;
		foreach($_SESSION["productsx"] as $product){ 
                    //new order margins
                    
                    //end new order margins
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                        $product_price = $product["price"]; 
                        $sellCost= $product["sellCost"]; 
                        $weight= $product["weight"]; 
                        $product_qty = $product["quantity"]; 
                        $thumbnail = $product["thumbnail"];
                        $icon='<img src="'.$thumbnail.'" class="icon_img"/>';                                         
                         $currency='Kes'; 
                         $subtotal = ($product_price * $product_qty);
                         $sellCostTotal = ($sellCost * $product_qty);
			$total = ($total + $subtotal);
   	}
                        }
$CustomerID = 666; 
//$shipcost=0.00;
if($shipMethod==='sendy'){
  $sellCostTotal=$sellCostTotal+$shipAmount;  
}
     $ProductName = $_POST["ProductName"];     
    @$ProductLink = 'ssss';
    $CostUSD = $_POST["CostUSD"];
    $SellingCost = $_POST["SellingCost"];
    $Qty = 12;
    $OrderTotal = $total;
    //$Status= $_POST["Status"]; 
    $Status = 0;
    if (isset($_POST["Order_comments"])) {
        $Order_comments = $_POST["Order_comments"];
    } else {
        $Order_comments = 'No comments';
    }
                                              
$query2 = "INSERT INTO  `lbs_order` (lbs_bill_shipping_id,shipping_cost,Status,OrderTotal,weight,sellCostTotal,orderRemarks,OrderDate,processedBy,processeDate,Payment_state,TransactionID)"
        . " VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
$statement2 = $mysqli->prepare($query2);
$statement2->bind_param('isssssssssss', $lbs_bill_shipping_id,$shipAmount,$Status,$OrderTotal,$weight,$sellCostTotal,$Order_comments,$regDate,$null_int,$null_date,$null,$null);
//$statement2->execute();
if(!$statement2->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
$orderId=$mysqli->insert_id;

//for shipping

$query23 = "INSERT INTO  `lbs_shipping` (OrderId,lbs_shipping_method,lbs_shipping_amount,lbs_shipping_date) VALUES(?,?,?,?)";
$statement23 = $mysqli->prepare($query23);
$statement23->bind_param('ssss', $orderId,$shipMethod,$shipAmount,$regDate);
//$statement2->execute();
if(!$statement23->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}


//end for shipping

//start order margins
              if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ 
		/*$total = 0;
$totalCost_Usd = '';
$totalCost_Ksh = '';
$convertedSellingcost_Ksh =  '';
$convertedSellingcost_Usd =  '';
$profitKes =  '';
$profitUsd =  '';
$margin =  '';*/
		foreach($_SESSION["productsx"] as $product){                   
	
                        
                        //new
                     //initialize

//end initialize
$totalCost_Usd = $product['totalCost_Usd'];
$totalCost_Ksh = $product['totalCost_Ksh'];
$convertedSellingcost_Ksh = $product['convertedSellingcost_Ksh'];
$convertedSellingcost_Usd = $product['convertedSellingcost_Usd'];
$profitKes = $product['profitKes'];
$profitUsd = $product['profitUsd'];
$margin = $product['margin'];
$costUsd = $product["price"]; 

  $querymargins = "INSERT INTO  `lbs_order_margins` (OrderId,costUsd,totalCost_Usd,totalCost_Ksh,convertedSellingcost_Ksh,convertedSellingcost_Usd,profitKes,profitUsd,margin,lbs_order_margins_date)"
        . " VALUES(?,?,?,?,?,?,?,?,?,?)";
$statement2mar = $mysqli->prepare($querymargins);
$statement2mar->bind_param('isssssssss', $orderId,$costUsd,$totalCost_Usd,$totalCost_Ksh,$convertedSellingcost_Ksh,$convertedSellingcost_Usd,$profitKes,$profitUsd,$margin,$regDate);
//$statement2->execute();
if(!$statement2mar->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
   	}
                        }


//end order margins

//start llop items
foreach($_SESSION["productsx"] as $product){ 
                        $product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                         $weight = $product["weight"]; 
                       // $weight = 67; 
                        $product_price = $product["price"]; 
                         $sellCost= round($product["sellCost"],2); 
                        $product_qty = $product["quantity"];
                        $thumbnail=$product["thumbnail"];
                        
                        $pdtlink=$product["product_url"];  
                        $pdtSource='amazon';   
                        //insert order items
$query3 = "INSERT INTO  lbs_orderitems (OrderId,ProductId,ProductName,ProductLink,thumbnail,ProductCost,weight,sellCost,ProductSource,ProductQty) VALUES(?,?,?,?,?,?,?,?,?,?)";
$statement3 = $mysqli->prepare($query3);

$statement3->bind_param('isssssssss', $orderId,$product_code,$product_title,$pdtlink,$thumbnail,$product_price,$weight,$sellCost,$pdtSource,$product_qty);

       
   

if(!$statement3->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}
}

$th='<table style="width:100%;" border="0"> '
        . '<tr><td colspan="6" bgcolor="yellow" align="center">'.$leta_logo.'</td></tr>'
        . '<tr><td>Image</td><td>Order ID</td><td>Name</td><td>Status</td><td>Price</td><td>Quantity</td></tr>';
$tf='</table>';
//$counter = 0;
$leta_logo='<img style="height: 60px;" src="http://dev.letabox.co.ke/images/logo-mid.png" />';
//$html =$leta_head;
//$html.='';  
$total = 0;
foreach($_SESSION["productsx"] as $product){ 
    $counter++;
    $bgcolor = ($counter % 2 === 0) ? 'white' : 'gray';
                        $product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                        $product_price = $product["price"]; 
                        $sellCost= round($product["sellCost"],2); 
                        $product_qty = $product["quantity"];  
                        $weight = $product["weight"]; 
                        $status='Pending';
                        $thumbnail=$product["thumbnail"]; 
                        $thumbnailimg='<img style="height: 57px;" src="'.$thumbnail.'" />';
                        $pdtlink='ddffdfd';
                        $pdtSource='amazon';   
 $html.= '<tr style="background='.$bgcolor.'"><td>'.$thumbnailimg.'</td><td> '.$product_code.'</td><td>'.$product_title.'</td><td>'.$status.'</td><td> Kes.'.$sellCost.'</td><td>'.$product_qty.'</td></tr>';   
    $subtotal = ($sellCost * $product_qty);
    $total = ($total + $subtotal);
}

$html.='<tr><td colspan="6" align="right"><strong>Total:'. wits_money($total+$shipAmount).'</strong></td></tr>';
//$html.= $leta_futa;
$mail = new PHPMailer(true);                       
try {  
   
    $mail->isSMTP();                                     
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'mwakah89@gmail.com';               
    $mail->Password = '2813gmaduqu!#';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;  
    
// TCP port to connect to
    //Recipients
    $mail->setFrom($mailFrom, $Fname);
    $mail->addAddress($Email, 'Customer');     // Add a recipient
    $mail->addAddress('joseph@witstechnologies.co.ke');               // Name is optional
    $mail->addReplyTo($mailFrom, 'Letabox');
    $mail->addCC('jmwaka89@gmail.com');
 //Content
    $mail->isHTML(true);    
    $mail->Subject = 'Order #'.$orderId.' Placed';
    $mail->Body=$leta_head.$html;
    $mail->send();
    
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;    
   die();
}

//send sms
$recipients = $Phone;
$message    = "You placed Order #: ".$orderId." We shall update you on the process";
tumaSms($recipients, $message);
       
       
//params for mpesa
////FOR MPESA
require_once("classes/auth/class.OAuth.php");
#universal
define("CALLBACK", "http://dev.letabox.co.ke/call.php");
define("MPESA_KEY", "w22mBbxtoZkuism8EFGAIG22I3j8G2CY");
define("MPESA_SECRET", "7M5n2mQI97je3c4N");
$MPESA_PHONE=properMSISDN($_POST['MPESA_NUMBER']);
$Amt = 10;
$paybill = 174379;
$invoice = 13244;
$transactionDesc = 'Test payment';
$transactionData = array($MPESA_PHONE, $Amt, $invoice, $transactionDesc);
$URLresponse = RegisterHTTPUrl($paybill, $CALLBACK, $CALLBACK, getAccessToken(MPESA_KEY, MPESA_SECRET));
//print_r($URLresponse);
$post_data = preparePostData($paybill, getPassword($paybill), CALLBACK, $transactionData);
$response = InitiatePayRequest($post_data, getAccessToken(MPESA_KEY, MPESA_SECRET));
//echo '<pre>';
//print_r($response);

//print $CheckoutRequestID=$response["Body"]["stkCallback"]["CheckoutRequestID"];
//echo '</pre>';
//print_r($response);
$CheckoutRequestID=$response->CheckoutRequestID;
$ResponseDescription=$response->ResponseDescription;
$ResponseCode=$response->ResponseCode;
$MerchantRequestID=$response->MerchantRequestID;
$PaymentMethod="LIPA NA MPESA";
$payStatus="777777";

//register MPESA details
$mpesaSQL = "INSERT INTO  `lbs_payments` (TransactionID,MerchantID,Invoice,Amount,PaymentMethod,Status,orderId) VALUES(?,?,?,?,?,?,?)";
$statementMpesa = $mysqli->prepare($mpesaSQL);
$statementMpesa->bind_param('sssssii', $CheckoutRequestID,$MerchantRequestID,$invoice,$Amt,$PaymentMethod,$payStatus,$orderId);
//$statement2->execute();
if(!$statementMpesa->execute()){die('Error : ('. $mysqli->errno .') '. $mysqli->error);}

      
unset($_SESSION['productsx']);    
$success='saved';
echo json_encode($success);
/* print '<script type="text/javascript">';
        print 'alert("Order Placed !!");';     
        print '</script>';
        print "<script language=\"javascript\"> 
var myurl='index.php'
window.location.assign(myurl)
</script>";*/
     
   } 

 
  ?>
 
 
     <?php


$sendy_api_url = "https://api.sendyit.com/v1/";

$google_maps_api_key = "AIzaSyBAgQ-vCy1106_l1iZFudZeYQGx2ghCS3g";
//$google_maps_api_key = "AIzaSyAZEtFnYRLAuSAbYe5KKBLhSyAlfRLaixU";

function sendy_wc_curl_exec( $url, $command, $data, $request_token_id ) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	
	curl_setopt($ch, CURLOPT_POST, TRUE);
	# Setup request to send json via POST.
	$payload = json_encode(array('command' => $command, 'data' => $data, 'request_token_id' => $request_token_id));
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	
	return $result;
}

function google_maps_api_curl_exec( $url ) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	
	return $result;
}

//if( isset($_POST['Submit']) )
    if(@$_REQUEST['billing_address_1']) 
    {
	//$fullAddress = $billing_address_1.",".$billing_city.",".$billing_state;
    $billing_address_1=$_POST['billing_address_1'];
      $chechout_before_total=$_POST['chechout_before_total'];
    
     // $chechout_net_total=$_POST['chechout_net_total'];
    
    $billing_country='ke';
	$fullAddress = $billing_address_1;
	$prepAddr = str_replace(" ", "+", $fullAddress);
	$prepURL = "https://maps.google.com/maps/api/geocode/json?address=$prepAddr&components=country:$billing_country&key=$google_maps_api_key";
	
	// Convert an address to geocode Latitude/Longitude positioning with Google Maps.
	// Example http://maps.google.com/maps/api/geocode/json?address=Kindaruma+Rd+Nairobi+Kenya&sensor=false
	//$geocode = file_get_contents($prepURL);
	$geocode = google_maps_api_curl_exec( $prepURL );
	$georesults = json_decode($geocode, true);
	
	//echo "<pre>";
	//echo "<h1>GOOGLE MAP API RESPONSE</h1>";
	//echo "URL:".$prepURL."<br/>";
	//print_r($georesults);	
	
	$geo_lat = $georesults["results"][0]["geometry"]["location"]["lat"];
	$geo_long = $georesults["results"][0]["geometry"]["location"]["lng"];
	$geo_addr = $georesults["results"][0]["formatted_address"];
	
	if( !empty($sendy_api_url) && !empty($geo_lat) && !empty($geo_long) ){
		$command = 'request';//Command of the request e.g. request
		$request_token_id = md5(time());//Optional: Token ID of the request
		//data		
		$api_key = "cZGFbGShHTHYnYJTN7FC";
		$api_username = "witstechnologiesltd";		
		$vendor_type = 1;//1 for bike, 2 for Pick up and 3 for Van
		//data: from
		$from_name = "Test Shop";//Name of the pick up location e.g. Shop
		$from_lat = -1.3370364;//Lat of the pick up location
		$from_long = 36.7081472;//Long of the pick up location
		$from_description = "To be picked from ($from_lat,$from_long)";//Desc of the pick up location e.g. office
		//data: to
		$to_name = 'Customer';//Name of the destination e.g. Lavington
		$to_lat = floatval($geo_lat);//Lat of the destination
		$to_long = floatval($geo_long);//Long of the destination
		$to_description = "To be delivered to $geo_addr ($to_lat,$to_long).";//Desc of the destination e.g. home
		//data: recepient
		$recepient_name = "Test User";//Name of the recepient
		$recepient_phone = "0711222333";//Phone of the recepient
		$recepient_email = "test@domain.com";//Email of the recepient
		//data: delivery_details
		$pick_up_date = date('Y-m-d', strtotime("+1 week"));
		//data: delivery_details: collect_payment
		$status = false;
		$pay_method = 0;//Payment method of collecting the cash. Default to 0.
		$amount = 0;//Amount of cash being collected
		//data: delivery_details
		$return = false; //If order is one way; false. If order is two way; true. 
		$note = ""; //If there is a note you need the rider to receive
		$note_status = false; //True if you need the note sent and false if not.
		$request_type = "quote";//Request type of the delivery. Default is 'quote', this gives you a price estimate.
		$order_type = "batch_later_order";//ondemand_order for immediately or batch_later_order for later
		$ecommerce_order = "";//Optional: ecommerce order of the delivery. 
		$skew = 1;//(int) skew of the package of the delivery.
		//data: delivery_details: package_size
		$weight = 0;
		$height = 0;
		$width = 0;
		$item_name = "Test Product";		
						
		$data = array(
			"api_key" => "".$api_key."",
			"api_username" => "".$api_username."",
			"vendor_type" => $vendor_type,
			"from" => array(
				'from_name' => "".$from_name."",
				'from_lat' => $from_lat,
				'from_long' => $from_long,
				'from_description' => "".$from_description."",
			),
			"to" => array(
				'to_name' => "".$to_name."",
				'to_lat' => $to_lat,
				'to_long' => $to_long,
				'to_description' => "".$to_description."",
			),
			"recepient" => array(
				'recepient_name' => "".$recepient_name."",
				'recepient_phone' => "".$recepient_phone."",
				'recepient_email' => "".$recepient_email."",
			),
			"delivery_details" => array(
				"pick_up_date" => "".$pick_up_date."",
				"collect_payment" => array(
					"status" => $status,
					"pay_method" => $pay_method,
					"amount" => $amount,
				),
				"return" => $return,
				"note" => "".$note."",
				"note_status" => $note_status,
				"request_type" => "".$request_type."",
				"order_type" => "".$order_type."",
				"ecommerce_order" => "".$ecommerce_order."",
				"skew" => $skew,
				"package_size" => array(
					"weight" => $weight,
					"height" => $height,
					"width" => $width,
					"item_name" => "".$item_name."",
				)
			),
		);		
		
			
		# Execute the curl command
		$result = sendy_wc_curl_exec( $sendy_api_url, $command, $data, $request_token_id );
		
		# Print response
		$result = json_decode($result, true);
		
		//echo "<br/><h1>DATA RECEIVED FROM SENDY API</h1>";
		//print_r($result);
               $sendyAmount=$result["data"]["amount"];
               $chechout_net_total=$sendyAmount+$chechout_before_total;
                //print json_encode($sendyAmount);
                print json_encode(array('sendyAmount'=>$sendyAmount,'chechout_net_total'=>$chechout_net_total)); 
          
	
	}else{
		echo "<h1>ERROR</h1>";
		echo "Check your API keys and ensure all mandatory fields are not empty before submission";
	}
	//echo "</pre>";
}
?>

     
 

