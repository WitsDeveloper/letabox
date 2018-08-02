<?php
session_start(); 
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
require_once 'partials/config.php';


$header = array(
    'page'=>'sign up',
    'title'=>'User sign up'
);
require_once 'partials/header.php';

?>
<link rel="stylesheet" type="text/css" href="partials/intlTelInput.css">



<section class="maincontent">

       <?php if(isset($_GET['ID'])){
          
           $userID=base64_decode($_GET['ID']);
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id='$userID'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      $obj_ona1= $project_desc1->fetch_object();  ?>
    <div class="container " style="text-align: center;">
        <h3 >Kindly Finish your registration</h3>
    </div>    
       
 <?php }     ?>
        
        <div class="container">
         <div class="registerform modalForm" id="signupModal">
            <h3>Sign up</h3>
            <!--<form data-toggle="validator" role="form" class="leta_signup" >-->
           <form class="leta_signup">
              <!--<form method="post" action="cart_process.php">-->
                <p>
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" id="Fname" placeholder="Your full name" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required>
                    
                    <input type="hidden" id="url_from" name="url_from" id="url_from" >
                  
                </p>
                <p>
                    <label for="email">Email Address</label>
                  <input type="text" name="Email" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" placeholder="Your email address" required />
                 
                </p>    <p>
                    <label for="name">Phone</label>
                    <input type="text" name="Phone" id="phonenumber" placeholder="Your Phone Number" maxlength="13" required>
                  
                </p>
                <p>
                    <label for="password">Password</label>
                    <input id="inputPassword" type="Password" name="Password" placeholder="Your password"  required />
           
                </p>
                <p>
                    <label for="confirm">Confirm Password</label>
                   <input type="Password" name="Confirm" placeholder="Confirm password"  required />
         
                   <input type="hidden" name="hidden_signup"/>  
                   
                   <input type="hidden" name="social_media" value="<?php print $userID; ?>"/>  
                </p>
                <p class="submit">
                    <input type="submit" name="leta_signup" id="signup" value="Sign up">
                </p>
             
            </form>
            <div id="signup_response" style="width: 100%;">  
     
                </div>
              
            <div class="socialModal">
                <p>Or sign up with</p>
                <ul>
                  <li class="facebook">
                        <a href="../f_b/fbconfig.php">
                            <?php //echo file_get_contents('images/icons/facebook.svg'); ?>
                           <!-- <span>Facebook</span>-->
                            <img src="../images/fb_reg.png" class="soc_imgs"/>
                        </a>
                    </li>
                    <li class="plus">
                        <a href="../go/google_login.php">
                           <!-- <?php //echo file_get_contents('images/icons/google-plus.svg'); ?>
                            <span>Google</span>-->
                                   <img src="../images/go_reg.png" class="soc_imgs"/>
                        </a>
                    </li>
                </ul>
                <p class="link">Existing user? <a  href="signin.php"  class="signinModal">Sign in</a></p>
            </div>
        </div>
            
        </div>
       
   

</section>
<?php require_once 'partials/footer.php'; ?>
<script type="text/javascript" src="partials/intlTelInput.min.js"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function() {
	var telInput = $("#phonenumber");
	var validateMsg = $("#validate-msg");
	
	// initialise plugin
	telInput.intlTelInput({
		autoPlaceholder: false,
		formatOnDisplay: true,
		geoIpLookup: function(callback) {
			jQuery.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			var countryCode = (resp && resp.country) ? resp.country : "";
			callback(countryCode);
			});
		},
		initialCountry: "auto",
		nationalMode: false,
		preferredCountries: ['ke', 'ug', 'tz'],
		utilsScript: "js/utils.js"
	});
	
	var reset = function() {
		telInput.removeClass("error");
		validateMsg.addClass("hide");
	};
	
	// on blur: validate
	telInput.blur(function() {
		reset();
		if ($.trim(telInput.val())) {
			if (telInput.intlTelInput("isValidNumber")) {
				validateMsg.addClass("hide");		
			} else {				
				validateMsg.removeClass("hide");
				validateMsg.html( '<em id="phonenumber-error" class="error">Valid number is required.</em>' );
			}
		}
	});
	
	// on keyup / change flag: reset
	telInput.on("keyup change", reset);
        var url_from=document.referrer;
          $("#url_from").val(url_from); 

        //added
       /* $("#umya").click(function(){
var bla = $('#phonenumber').val();
alert(bla); 
});*/
        
        
});




</script>




