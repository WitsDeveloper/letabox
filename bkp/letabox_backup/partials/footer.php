<footer>
    <div class="container">

        <?php
        ?>

        <ul>
            <?php if ($header['page'] == 'home'): ?>

                <li class="social">
                    <nav>
                        <ul>
                            <?php
                            $html = '';
                            foreach ($social as $s):
                                $html .= '<li><a href="' . $s['href'] . '" ';
                                $html .= 'title="Find us on ' . $s['title'] . '">';
                                $html .= file_get_contents('images/icons/' . $s['icon']);
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

                <li class="menu hide_mob">
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
                            foreach ($social as $s):
                                $html .= '<li><a href="' . $s['href'] . '" ';
                                $html .= 'title="Find us on ' . $s['title'] . '">';
                                $html .= file_get_contents('images/icons/' . $s['icon']);
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
                                <?php //echo file_get_contents('images/icons/facebook.svg');  ?>
                               <!-- <span>Facebook</span>-->
                                <img src="../images/fb_reg.png" class="soc_imgs"/>
                            </a>
                        </li>
                        <li class="plus">
                            <a href="../go/google_login.php">
                                <!-- <?php //echo file_get_contents('images/icons/google-plus.svg');  ?>
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
                    <input type="hidden" name="kutoka" id="kutoka" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" >
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
                                <?php //echo file_get_contents('images/icons/facebook.svg');  ?>
                               <!-- <span>Facebook</span>-->
                                <img src="../images/fb_login.png" class="soc_imgs"/>
                            </a>
                        </li>
                        <li class="plus">
                            <a href="../go/google_login.php">
                                <!-- <?php //echo file_get_contents('images/icons/google-plus.svg');  ?>
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
        if (!isset($_SESSION["productsx"])) {
            ?>
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2>No Items in cart !!</h2>
            </div> 
        <?php
        } else {
            if (isset($_SESSION['user_id'])) {

                $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=" . $_SESSION['user_id'])or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);

                $obj_ona1 = $project_desc1->fetch_object();
            }
            ?>
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="loginform modalForm" id="signinModal">
                    <h3>Check Out</h3>

                    <!--  <form action="" method="post">-->
                    <?php if (!isset($_SESSION['user_id'])) { ?>
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
                        <?php if (!isset($_SESSION['user_id'])) { ?><p>
                                <label for="password">Password</label>
                                <input type="password" name="Password" id="password" value="<?php print $obj_ona1->Password ? $obj_ona1->Password : ''; ?>" required>
                            </p>
                        <?php } ?>
                        <input type="hidden" name="kutoka" id="kutoka" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" >

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
<!-- new mob modals -->
<!-- Modal -->
<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2">My cart</h4>
            </div>

            <div class="modal-body">
                <?php if (isset($_SESSION["productsx"]) && count($_SESSION["productsx"]) > 0) { ?>
                    <!--<h2>Your Cart</h2>-->
                    <table id="my_view_kart"  class="cart-products-loaded table table-bordered">
                        <tr>
                            <th>Image</th>
                            <th class="cart_tit hide_mob">Name</th>
                            <th>Units</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
    <?php
    $total = 0;
    foreach ($_SESSION["productsx"] as $product) {
        $product_code = $product["product_code"];
        $product_title = $product["title"];
        $product_price = $product["price"];
        $sellCost = $product["sellCost"];
        $product_qty = $product["quantity"];
        $thumbnail = $product["thumbnail"];
        $icon = '<img src="' . $thumbnail . '" class="icon_img"/>';
        $currency = 'Kes';
        ?>
                            <tr class="cart-item">
                                <td><a href="single.php?ID=<?php echo $product_code; ?>"><?php print $icon; ?></a></td>
                                <td class="hide_mob"><a href="single.php?ID=<?php echo $product_code; ?>"><?php echo $product_title; ?></a></td>
                                <td>                         <div class="nav_cart_qty">
                                        <div class="input-group">    
                                            <input type="text" name='quantity' data-code="<?php print $product_code; ?>" class="form-control input-number text-center quantity" value="<?php print $product_qty; ?>"/>
                                            <button type="button" id="add" data-code="<?php print $product_code; ?>" class="add btn cart_btn"><img src="images/icons/plus.png"></button>
                                            <button type="button" id="sub" value='-' field="quantity" data-code="<?php print $product_code; ?>" class="sub btn cart_btn"><img src="images/icons/minus.png"></button> 

                                        </div></div>

                                </td>
                                <td><?php print wits_money($product_qty * $sellCost); ?> </td>
                                <td><a href="#" class="remove-item3" data-code="<?php print $product_code; ?>">remove</a></td>
                            </tr>
        <?php
        $subtotal = ($sellCost * $product_qty);
        $total = ($total + $subtotal);
    }
    ?>
                        <tr>
                            <td colspan="2"><strong>Price is inclusive of taxes, shipping &amp; handling</strong></td>
                            <td>Subtotal</td>
                            <td colspan="2"><?php
    print wits_money($total);
    ?></td>
                        </tr>
                    </table>
                    <div class="buttons">
                        <p>
                            <a href="#" id="backLink" class="button boy-btn">Continue Shopping</a>
                            <a  href="checkout.php" class="button wob-btn">Checkout</a>
                        </p>
                    </div>
<?php
} else {
    print 'Cart is empty';
}
?>
            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<!-- Modal -->
<div class="modal left fade" id="myModalnan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!--<h4 class="modal-title" id="myModalLabel">Left Sidebar</h4>-->
            </div>

            <div class="modal-body">
                <ul class="mob_drop">
<?php //foreach ($menu as $item):  ?>

<?php //endforeach;  ?>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Guarantee</a></li>                                      
                    <li>
<?php if (isset($_SESSION["user_id"])) { ?>
                        <li><a href="my-account.php" class="hide_desk"> My account</a></li>
                        <li><a href="?account=logout" class="hide_desk"> Logout</a></li>
<?php } else { ?>
                        <li><a data-toggle="modal" href="#sUp" class="signupModal hide_desk">Sign up</a></li>
                        <li><a data-toggle="modal" href="#sIn"  class="signinModal hide_desk">Sign in</a></li>
<?php } ?>
                </ul>
            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- /.modal -->


<!--end new mob modals-->




 <!-- <script src="js/jquery.3.2.1.min.js"></script>  
      <script src="js/jquery1.min.js"></script>-->
<script src="js/jquery.js"></script>
<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->

<script src="js/jquery.bxslider.js"></script>
<script src="https://hammerjs.github.io/dist/hammer.js"></script>

<script src="vendors/tabslet/jquery.tabslet.min.js"></script>
<!-- <script src="vendors/featherlight/featherlight.min.js"></script>-->
<script src="vendors/featherlight/bootstrap.min.js"></script>
<script src="js/script.js"></script>   

<script type="text/javascript">
    var myElement = document.getElementById('myElement');   
    var mc = new Hammer(myElement);
    mc.on("panleft", function (ev) {
        var expanded = false;
        if (expanded = !expanded) {
            $("#wits_barx").animate({"margin-right": 0}, "fast");

        } 
    }); 
</script> 
<script type="text/javascript">
    
           var drawerhqandle = document.getElementById('wits_barx');
       //var drawerhqandle = document.getElementById('drawer-hqandle');
     var drawerhqandle = new Hammer(drawerhqandle);
     
     drawerhqandle.on("panright", function (ev) {        
            $("#wits_barx").animate({"margin-right": -263}, "fast");
              
    });
    </script>
<script type="text/javascript">
    var myElement2 = document.getElementById('myElement2');
    var mc2 = new Hammer(myElement2);
    mc2.on("panright", function (ev) {
        var expanded2 = false;
        if (expanded2 = !expanded2) {
            $("#wits_barx2").animate({"margin-left": 0}, "fast");

        } 
    });
    </script>
    <script type="text/javascript">
        
        
           var drawerhqandle2 = document.getElementById('wits_barx2');
       //var drawerhqandle2 = document.getElementById('drawer-hqandle2');
     var drawerhqandle2 = new Hammer(drawerhqandle2);
     
     drawerhqandle2.on("panleft", function (ev) {        
            $("#wits_barx2").animate({"margin-left": -263}, "fast");              
    });
    </script>
<script src="kart.js"></script> 


</body>
<?php
$cart = "cart.php";
$currentpage = $_SERVER['REQUEST_URI'];
?>
<script>

    /* $(document).ready(function(){
     $('.bxslider').bxSlider({
     mode: 'fade',
     captions: true,
     controls:false,
     minSlides: 2,
     maxSlides: 5,
     preloadImages: 'all'
     
     
     });
     });  */

    jQuery(document).ready(function ($) {

        /*  $('.bxslider').bxSlider({
         mode: 'fade',
         captions: true,
         controls:false,
         minSlides: 2,
         maxSlides: 5,
         preloadImages: 'all'
         
         
         });*/
        jQuery('.bxslider').show().bxSlider({
            mode: 'fade',
            captions: true,
            controls: false,
            pause: 5500,
            controls: false,
            autoHover: false
        });
    });
</script>


</html>
