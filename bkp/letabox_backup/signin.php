<?php
session_start(); 
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
require_once 'partials/config.php';


$header = array(
    'page'=>'Sign in',
    'title'=>'Sign in'
);
require_once 'partials/header.php';

?>



<section class="maincontent">

   
        
        <div class="container">
         
          <div class="loginform modalForm" id="signinModal">
            <h3>Sign in</h3>
          <!--  <form action="" method="post">-->
                 <form class="leta_signin" >
                         <input type="hidden" name="hidden_signin"/> 
                <p>
                    <label for="email">Email Address</label>
                    <input type="text" name="Email" id="email" placeholder="Your email address" required>
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name="Password" id="password" placeholder="Your password" required>
                </p>
                    <input type="hidden" id="url_from" name="url_from" id="url_from" >
                <!--<input type="hidden" name="kutoka" id="kutoka" value="<?php //echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" >-->
                <p class="submit">
                    <input type="submit" name="leta_signin" id="signin" value="Sign in">
                </p>
                <p class="link">
                    <a href="my-account.php?account=forgot">Forgot Password?</a>
                </p>
            </form>
           <div id="signup_response2" style="width: 100%;">  
     
                </div>
            <div class="socialModal">
                <p>Or sign in with</p>
                <ul>
                    <li class="facebook">
                        <a href="../f_b/fbconfig.php">
                            <?php //echo file_get_contents('images/icons/facebook.svg'); ?>
                           <!-- <span>Facebook</span>-->
                            <img src="../images/fb_login.png" class="soc_imgs"/>
                        </a>
                    </li>
                    <li class="plus">
                        <a href="../go/google_login.php">
                           <!-- <?php //echo file_get_contents('images/icons/google-plus.svg'); ?>
                            <span>Google</span>-->
                                   <img src="../images/go_login.png" class="soc_imgs"/>
                        </a>
                    </li>
                </ul>
                <p class="link">Don't have an account? <a  href="signup.php"  class="signupModal">Sign up</a></p>
            </div>
        </div>  
        </div>
       
   

</section>
<?php require_once 'partials/footer.php'; ?>

<script>
    $(document).ready(function(){
      var url_from=document.referrer;
          $("#url_from").val(url_from);
              });
    </script>