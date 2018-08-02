    <footer>
        <div class="container">

            <?php
                $social = array(
                    array(
                        'icon'=>'facebook.svg',
                        'href'=>'https://facebook.com/',
                        'title'=>'Facebook'
                    ),
                    array(
                        'icon'=>'twitter.svg',
                        'href'=>'https://twitter.com/',
                        'title'=>'Twitter'
                    ),
                    array(
                        'icon'=>'google-plus.svg',
                        'href'=>'https://plus.google.com/',
                        'title'=>'Google Plus'
                    ),
                    array(
                        'icon'=>'linkedin.svg',
                        'href'=>'https://linkedin.com/',
                        'title'=>'LinkedIn'
                    ),
                    array(
                        'icon'=>'youtube.svg',
                        'href'=>'https://youtube.com/',
                        'title'=>'Youtube'
                    )
                );
            ?>

            <ul>
            <?php if($header['page'] == 'home'): ?>

                <li class="social">
                    <nav>
                        <ul>
                        <?php
                            $html = '';
                            foreach($social as $s):
                                $html .= '<li><a href="'.$s['href'].'" ';
                                $html .= 'title="Find us on '.$s['title'].'">';
                                $html .= file_get_contents('images/icons/'.$s['icon']);
                                $html .= '</a></li>';
                            endforeach;
                            echo $html;
                        ?>
                        </ul>
                    </nav>
                </li>
                <li class="copy">
                    <p>&copy; <?php echo date('Y'); ?> LetaBox. All rights reserved. Please read our <a href="">Terms Of Use</a> and <a href="">Privacy Policy</a>.</p>
                </li>

            <?php else: ?>

                <li class="menu">
                    <nav>
                        <ul>
                        <?php foreach ($menu as $item): ?>
                            <li><a href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </nav>
                </li>
                <li class="copy">
                    <p>&copy; <?php echo date('Y'); ?> LetaBox. All rights reserved. Please read our <a href="">Terms Of Use</a> and <a href="">Privacy Policy</a>.</p>
                </li>
                <li class="social">
                    <nav>
                        <ul>
                        <?php
                            $html = '';
                            foreach($social as $s):
                                $html .= '<li><a href="'.$s['href'].'" ';
                                $html .= 'title="Find us on '.$s['title'].'">';
                                $html .= file_get_contents('images/icons/'.$s['icon']);
                                $html .= '</a></li>';
                            endforeach;
                            echo $html;
                        ?>
                        </ul>
                    </nav>
                </li>

            <?php endif; ?>
            </ul>

        </div>
    </footer>

    <section class="modalBlocks">

        <!--<div class="loginform modalForm" id="signinModal">
            <h3>Sign in</h3>
            <form action="" method="post">
                <p>
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" placeholder="Your email address">
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your password">
                </p>
                <p class="submit">
                    <input type="submit" name="signin" id="signin" value="Sign in">
                </p>
                <p class="link">
                    <a href="">Forgot Password?</a>
                </p>
            </form>
            <div class="socialModal">
                <p>Or sign in with</p>
                <ul>
                    <li class="facebook">
                        <a href="">
                            <?php echo file_get_contents('images/icons/facebook.svg'); ?>
                            <span>Facebook</span>
                        </a>
                    </li>
                    <li class="plus">
                        <a href="">
                            <?php echo file_get_contents('images/icons/google-plus.svg'); ?>
                            <span>Google</span>
                        </a>
                    </li>
                </ul>
                <p class="link">Don't have an account? <a  href="#" class="signupModal">Sign up</a></p>
            </div>
        </div>-->

       
    </div>

   
       
      

    </section>
  <div class="modal fade" id="qView" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
              <div class="fetched-data row"></div>
  
      </div>
      
    </div>
        </div>

<!--for signup-->
  <div class="modal fade" id="sUp" role="dialog">
    <div class="modal-dialog sUp">
    
      <!-- Modal content-->
      <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           <div class="registerform modalForm" id="signupModal">
            <h3>Sign up</h3>
            <!--<form data-toggle="validator" role="form" class="leta_signup" >-->
           <form class="leta_signup">
              <!--<form method="post" action="cart_process.php">-->
                <p>
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" id="name" placeholder="Your full name" required>
                  
                </p>
                <p>
                    <label for="email">Email Address</label>
                  <input type="text" name="Email" value="" placeholder="Your email address" required />
                 
                </p>    <p>
                    <label for="name">Phone</label>
                    <input type="text" name="Phone" id="name" placeholder="Your Phone Number" required>
                  
                </p>
                <p>
                    <label for="password">Password</label>
                    <input id="inputPassword" type="Password" name="Password" placeholder="Your password"  required />
           
                </p>
                <p>
                    <label for="confirm">Confirm Password</label>
                   <input type="Password" name="Confirm" placeholder="Confirm password"  required />
         
                   <input type="hidden" name="hidden_signup"/>  
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
                <p class="link">Existing user? <a data-toggle="modal" href="#sIn"  class="signinModal">Sign in</a></p>
            </div>
        </div>
         
  
      </div>
      
    </div>
        </div>
<!--start siggin-->
<div class="modal fade" id="sIn" role="dialog">
    <div class="modal-dialog sUp">
    
      <!-- Modal content-->
      <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                <input type="hidden" name="kutoka" id="kutoka" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" >
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
                <p class="link">Don't have an account? <a data-toggle="modal" href="#sUp"  class="signupModal">Sign up</a></p>
            </div>
        </div>
         
  
      </div>
      
    </div>
        </div>
<!-- checkout modal-->
<div class="modal fade" id="cH" role="dialog">
    <div class="modal-dialog sUp">
        <?php //if(!isset($_SESSION['user_id']))
          if(!isset($_SESSION["productsx"])){?>
        <div class="modal-content">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2>No Items in cart !!</h2>
        </div> 
            <?php }
             else{
    if(isset($_SESSION['user_id'])){
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      $obj_ona1= $project_desc1->fetch_object();      
       
 }     ?>
      <!-- Modal content-->
      <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           <div class="loginform modalForm" id="signinModal">
            <h3>Check Out</h3>
      
          <!--  <form action="" method="post">-->
           <?php if(!isset($_SESSION['user_id'])){?>
                 <p class="link">A returning customer?
         <a id="checkout_acc" data-toggle="modal" data-target="#sIn" data-dismiss="modal" class="signinModal my_cta">Click here</a></p>
           <?php } ?>
        <!-- <form class="leta_modal_checkout" >-->
           <form class="leta_modal_checkoutx" method="post" action="cart_process.php" >
                         <input type="hidden" name="OrderID"/> 
                         <p>
                    <label for="name">Full Name</label>
                    <input type="text" name="Fname" id="name" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required>
                  
                </p>
                   <p>
                    <label for="name">Phone</label>
                    <input type="text" name="Phone" id="name" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" required>
                  
                </p>
                <p>
                    <label for="email">Email Address</label>
                    <input type="text" name="Email" id="email" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" required>
                </p>
                      <?php if(!isset($_SESSION['user_id'])){?><p>
                    <label for="password">Password</label>
                    <input type="password" name="Password" id="password" value="<?php print $obj_ona1->Password ? $obj_ona1->Password : ''; ?>" required>
                </p>
                      <?php } ?>
                <input type="hidden" name="kutoka" id="kutoka" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>" >
         
                <p class="submit">
                    <input type="submit" name="mod" id="signin" value="Place Order">
                </p>
                <p class="link">
                    <a href="my-account.php?account=forgot">Forgot Password?</a>
                </p>
            </form>
      
            <?php } ?>
                      <div id="checkout_resp" style="width: 100%;">  
     
                </div>
         
            
        </div>
         
  
      </div>
      
    </div>
        </div>

<!-- end checkout modal-->





    <!--<script src="js/jquery.3.2.1.min.js"></script>
      <script src="js/jquery1.min.js"></script>-->
<script src="js/jquery.js"></script>
    
    <script src="vendors/tabslet/jquery.tabslet.min.js"></script>
   <!-- <script src="vendors/featherlight/featherlight.min.js"></script>-->
      <script src="vendors/featherlight/bootstrap.min.js"></script>
    <script src="js/script.js"></script>     
    <script src="kart.js"></script>
   <!-- <script>
        //view an order
        $(document).ready(function() {
        $('#orderView').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
     $.ajax({
            type : 'post',
            url : 'cart_process.php', 
            data :  'rowid='+ rowid, 
            success : function(data){
            $('.fetched-data2').html(data);//Show fetched data from database
            }
        });
     });
     });
        
        </script>-->

</body>
</html>
