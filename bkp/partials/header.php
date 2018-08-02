<?php

$htmlClass = '';
if($header['page'] != 'home') {
    $htmlClass = ' class="innerpage"';
}

// top and bottom menu
$menu = array(
    array('label'=>'About','href'=>'about'),
   	array('label'=>'Contact','href'=>'contact'),
    array('label'=>'FAQ\'s','href'=>'faq'),
    array('label'=>'Guarantee','href'=>'guarantee'),
      array('label'=>'Get a Quote','href'=>'no-results.php')

);
//new social
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
<!DOCTYPE html>
<html lang="en"<?php echo $htmlClass; ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo BASE_HREF; ?>">
<title><?php echo $header['title'] == '' ? 'LetaBox' : $header['title'].' - LetaBox'; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link href="css/jquery.bxslider.css" rel="stylesheet" />

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style.responsive.css">
<link rel="stylesheet" href="css/fa/css/fontawesome-all.min.css">

<!--<link rel="stylesheet" href="css/style.jquery-ui.css">-->

<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
<!--chat -->
<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?5ivnAutwbkOv6PP9Mh64r441PaA9hCXE";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->
<!-- end chat-->
</head>
<body>
<!--wish, cart acts--> 
<!-- <div id='loadingmessage' style='display:none'>
       <img src='images/loader.gif'/>
</div>-->
<div class="loading" style="display:none">
	
</div>
<div class="loading-div" style="display:none">
	<img src="images/loader.gif" >
</div>
<div id="edded_nav_cart hide_mob" >
	1 item Added to cart
</div>
<div class="edded_wish_exists" >
	Item already in the wishlist
</div>
<div class="edded_to_wish" >
	item Added to wish list
</div>
<div class="order_placedd" >
	The order has been placed successfully.
</div>
<!--<div class="edded_to_login" >
	Login to add item to wish list !!
</div>-->
	   <!-- <img id="" src="../images/error.png" class="drawer-handle mob_vinga hide_desk"/>-->
	   
<header>
 

           
		<?php if($header['page'] != 'home'): ?>
        <!--     <a href="javascript:void(0);" id="ona_seacrh_mob" class="hide_desk" style="height: 20px;"><img style=" position: absolute; right: 1%;top: 43px;" src="../images/magnifying-glass.png"/></a>-->
    <button type="button" id="myElement2" class="navbar-toggle drawer-handle2" >
                         <!--   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">-->
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
            
            <div class="logo">
			<h1>LetaBox</h1> <a href="<?php echo BASE_HREF; ?>"><img src="images/logo-mid.png" alt="LetaBox"></a>
		</div>
		
            <div class="search hide_mhob">
			<!--<form  method="get" action="listing.php">
				<!--<input type="hidden" name="category" id="category" class="form-control input-lg" value="All">-->
                             <?php
               // $sqlCatShow = "SELECT `CatName`,`CatValue` FROM `".DB_PREFIX."categories` WHERE `disabledFlag` = 0 AND `deletedFlag` = 0 ORDER BY `CatName` ASC";
				//echo sqlOption($sqlCatShow,"category",$category,"Select","","");
				?>
				<!--<input id="search" type="search" name="search" placeholder="Search global ecommerce sites here..." value="<?php echo @$search; ?>">
				<input id="btnSubmit" type="submit" class="hide_mob" value="Search">
				<button id="btnSubmit" class="hide_desk" type="submit"><i class="fas fa-search"></i></button>
			</form>-->
                         <div class="search_bar">
              <form  method="get" action="listing.php">
	
    		<span class=" nav-facade-active" id="nav-search-in" style="width: auto;">
              <span data-value="search-alias=aps" id="nav-search-in-content" style="width: 60px; overflow: visible;">
                Category
              </span>
                    <span class="nav-down-arrow nav-sprite"><!--<i class="fas fa-angle-down land_mantha" style="color:black !important;"></i>--></span>
           
              <select title="Search in" class="searchSelect" id="searchDropdownBox" name="category"  style="top: 0px;">
                  
			 <option value=" <?php
                             if(@$_POST['category']){
                               echo @$_POST['category'];  
                             }
                             else{
                             ?>
                             Select
                             <?php } ?>" selected="selected">
                             <?php
                             if(@$_POST['category']){
                               echo @$_POST['category'];  
                             }
                             else{
                             ?>
                             Select
                             <?php } ?></option>
                                     <?php
              $project_desc1 = $mysqli->query("SELECT * from lbs_categories ORDER BY CatName ASC")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
   
$CatID=$obj_ona1->CatID;
$CatName=$obj_ona1->CatName;
$CatValue=$obj_ona1->CatValue;


              ?>
     <option value="<?php print $CatName;?>" title="<?php print $CatValue;?>"><?php print $CatValue;?></option>                              
     <?php } ?>
			  </select>
           
            </span>
            <div class="nav-searchfield-outer nav-sprite">
   <input type="search" autocomplete="off" name="search"  class="landing2"value="<?php echo @$search; ?>" title="Search For" id="twotabsearchtextbox" style="padding-right: 1px;">
            </div>
            <div class="nav-submit-button">
             <!-- <input type="submit" title="Go" class="nav-submit-input" value="Search">-->
                	<button id="btnSubmit" class="" type="submit"><i class="fas fa-search "></i></button>
            </div>
              </form>
</div>
                </div>
            
		<?php endif; ?>
		<nav>			
			<?php if($header['page'] == 'home'): ?>	
               <button type="button" id="myElement2" class="navbar-toggle drawer-handle2 myElement_home" >
            
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
                    <ul class="hide_mob">
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a></li>
                <?php endforeach; ?>
                </ul>
                    
                 
			<?php endif; ?>
                    
			<ul class="right">
                            <?php if($header['page'] == 'home'){ ?>
				<?php    if(isset($_SESSION["user_id"])){?>
                            <li><a href="my-profile.php" class="hide_mob"> Profile</a></li>
                             <li><a href="my-account.php" class="hide_mob"> Orders</a></li>
                            <li><a href="?account=logout" class="hide_mob"> Logout</a></li>
				<?php } else{ ?>
				<li><!--<a data-t class="signupModal hide_mob">Sign up</a>-->
                                    <a data-toggle="modal" href="#sUp" class="signupModal hide_mob">Sign up</a>
                                    
                              
                                </li>
				<li><!--<a onclick="location.href='../signin.php';"   class="signinModal hide_mob">Sign in</a>-->
                                     <a data-toggle="modal" href="#sIn" class="signinModal hide_mob">Sign In</a>
                                
                                
                                </li>
				<?php } ?>
                                <?php } else{ ?>
                                <?php    if(isset($_SESSION["user_id"])){?>
                            <li><a href="my-account.php" class="hide_mob"> Orders</a></li>
                            <li><a href="my-profile.php" class="hide_mob"> My Profile</a></li>
                            
                            <li><a href="?account=logout" class="hide_mob"> Logout</a></li>
				<?php } else{ ?>
                            <li><!--<a  onclick="location.href='../signup.php';" class="signupModal hide_mob">Sign up</a>-->
                               <a data-toggle="modal" href="#sUp" class="signupModal hide_mob">Sign up</a>
                            </li>
                            <li><!--<a  onclick="location.href='../signin.php';" class="signinModal hide_mob">Sign in</a>-->
                               <a data-toggle="modal" href="#sIn" class="signupModal hide_mob">Sign in</a>
                            </li>
                                <?php } } ?>
				<!--<li><a data-toggle="modal" href="#cH"  class="signinModal">check out</a></li>-->
				 <li class="hide_mob">  <a href="cart.php" id="cart-info"  class="icon cart-box" >                                
                                        
                                        <span class="counter">
				<?php 
				if(isset($_SESSION["productsx"])){
					//echo count($_SESSION["productsx"]); 
					echo array_sum(array_column($_SESSION['productsx'], 'quantity'));
				}else{
					echo 0; 
				}
				?>
				</span> <?php echo file_get_contents('images/icons/cart.svg'); ?> </a> </li>
                                
                                <li class="hide_desk">  <div id="myElement" class="<?php if($header['page'] == 'home'){ print 'myElementHome';} ?>">                                 
                                <a  id="cart-info"  class="icon drawer-handle cart-box">
                                                                        
                                        <span class="counter">
				<?php 
				if(isset($_SESSION["productsx"])){
					//echo count($_SESSION["productsx"]); 
					echo array_sum(array_column($_SESSION['productsx'], 'quantity'));
				}else{
					echo 0; 
				}
				?>
                                        </span> <?php echo file_get_contents('images/icons/cart.svg'); ?> </a></div> </li>
                              <!--  <li><button type="button" class="btn btn-demo" data-toggle="modal" data-target="#myModal2">
			Left Sidebar Modal
		</button></li>-->
			</ul>
		</nav>
	</div>
</header>
<div id="wits_barx2" class="hide_desk">   
	      <!-- <img id="drawer-hqandle" src="images/error.png" class="mob_vinga drawer-handle2"/>-->
                
                <i id="drawer-hqandle2" class="fas fa-times mob_vinga drawer-handle2"></i>
                <div class="mob_bott_heda">
                        <h3> Hello. <?php if(!isset($_SESSION['user_id'])){?>Sign In<?php }
                        
                        else{ print $_SESSION['Fname'];} ?></h3>   
                    </div>
    <ul class="mob_drop">
					
           <?php    if(isset($_SESSION["user_id"])){?>
        <li><a href="my-profile.php" class="hide_desk wits_barx2_acc"> <span style="color: #2f2f2e;font-weight: bold;">My Profile</span></a></li>
        <li><a href="?account=logout" class="hide_desk wits_barx2_acc"> <span style="color: #2f2f2e;font-weight: bold;">Logout</span></a></li>
         <li><a href="my-account.php" class="hide_desk wits_barx2_acc"> <span style="color: #2f2f2e;font-weight: bold;">Orders</span></a></li>
				<?php } else{ ?>
        <li><a onclick="location.href='../signup.php';" class="signupModal hide_desk wits_barx2_acc">  <span style="color: #2f2f2e;font-weight: bold;">Sign up</span></a></li>
        <li><a onclick="location.href='../signin.php';"  class="signinModal hide_desk wits_barx2_acc"> <span style="color: #2f2f2e;font-weight: bold;">Sign in</span></a></li>
        <li><a href="../my" class="hide_desk wits_barx2_acc"><span style="color: #2f2f2e;font-weight: bold;"> Orders</span></a></li>
				<?php } ?>
                                    <li><a href="#"> About</a></li>
                                     <li><a href="#"> Contact</a></li>
                                      <li><a href="#"> FAQs</a></li>
                                      <li><a href="#"> Guarantee</a></li>   
                                      <li><a href="no-results.php"> Get a Quote</a></li> 
                                    	
                                     
				</ul>
                <div class="mob_bott">
                    <div style="text-align: left !important" class="mop_push">
                     <br>   <br>
                     <b> <i class="fas fa-phone-volume"></i> Call Us on:</b> +25477777777
                     <br>   <br> <br>
                     <b> <i class="fas fa-envelope"></i> Email:</b> <a href="mailto:info@letabox.co.ke">info@letabox.co.ke</a>
                    <br>
                </div>
                    
                    <div class="social mop_push" style="text-align: left !important">
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
                </div>
                       <div style="width: 100%;"class="copy">
                           <br>
                    <p>&copy; <?php echo date('Y'); ?> LetaBox. All rights reserved. </p>
                </div>
                   
                </div>
</div>
 <?php
    
     if(@($_GET['account'] === 'logout')) {
         unset($_SESSION['user_id']);
           unset($_SESSION['Fname']);
             unset($_SESSION['Email']);         
           //session_destroy();
         print "<script language=\"javascript\"> 
var myurl='index.php'
window.location.assign(myurl)
</script>";
        
       
                
           }
           ?>
