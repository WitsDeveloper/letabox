<?php
session_start(); 
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
require_once 'partials/config.php';


$header = array(
    'page'=>'account',
    'title'=>'Profile'
);
require_once 'partials/header.php';

?>
<link rel="stylesheet" type="text/css" href="partials/intlTelInput.css">

<section class="maincontent">

    <div class="profile">

        <div class="container">
            <div class="col-md-12 kulwa">
                <br>
                    <h2> My Profile</h2>
                    <br>
          
              </div>
            <div class="row">
     
                                       <?php
                                  
      $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
       $obj_ona1= $project_desc1->fetch_object();                             
                                        
                                        ?>
   <!--<form action="cart_process.php" method="post">-->
 <form class="billing_edit">
        
          <input type="hidden" name="billing_edit"/>
     
        <div class="col-md-6">
         <p>
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" id="name" class="form-control" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required>
                  
                </p>
                 <p>
                    <label for="name">Phone</label>
                    <input type="text" name="Phone" id="phonenumber" class="form-control" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" required>
                  
                </p>
                <p>
                    <label for="email">Email Address</label>
                    <input type="text" name="Email" id="email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" required>
                </p>
                     <p>
                    <label for="email">Country:</label>
                   <select class="form-control" id="sel1" name="Country">
      <option value="<?php print $obj_ona1->Country; ?>" selected="selected"><?php print $obj_ona1->Country; ?></option>
      
<?php

foreach($countries as $key => $value) {
?>
<option value="<?= $value ?>" title="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></option>
<?php
}
?>
</select>
                </p>   
        </div>
          <div class="col-md-6">
                              
                   
                 <p>
                    <label for="email">Street Address</label>
             <input type="text" name="Address1" class="form-control" value="<?php print $obj_ona1->Address1 ? $obj_ona1->Address1 : ''; ?>" placeholder="House number and street name" required/>
                </p>
                  <p>
                    <label for="email">Town / City:</label>
           <input type="text" name="City" class="form-control" value="<?php print $obj_ona1->City ? $obj_ona1->City : ''; ?>" required/>
                </p>
                
                   <p>
                    <label for="email">Postcode / Zip:</label>
       <input type="text" name="Zcode" class="form-control" value="<?php print $obj_ona1->Zcode ? $obj_ona1->Zcode : ''; ?>" required/>
                </p>
                 
                     <p class="submit">
                    <input type="submit" name="billing_edit" id="pro_edit" value="Save details">
                            
                </p>
            
              
                    
     </form>
                    </div>
           <div id="billing_response" class="col-md-12"></div>
        
            </div>
            <div class="row">
                <a href="my-account.php">Back to My Account</a>
            </div>
        
            </div>
            
        </div>
      
    </div>

</section>
<?php require_once 'partials/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    validateOnBlur : false, // disable validation when input looses focus
    errorMessagePosition : 'top' // Instead of 'inline' which is default
    scrollToTopOnError : false // Set this property to true on longer forms
  });
</script>
<script>
  $.validate({
    modules : 'html5'
  });
</script>
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
        
        //added
       /* $("#umya").click(function(){
var bla = $('#phonenumber').val();
alert(bla); 
});*/
});




</script>
