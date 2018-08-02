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
    array('label'=>'Guarantee','href'=>'guarantee')
);

?>
<!DOCTYPE html>
<html lang="en"<?php echo $htmlClass; ?>>
<head>
    <meta charset="UTF-8">
    <base href="<?php echo BASE_HREF; ?>">
    <title><?php echo $header['title'] == '' ? 'LetaBox' : $header['title'].' - LetaBox'; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!--<link rel="stylesheet" href="vendors/featherlight/featherlight.min.css">-->
     <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!--wish, cart acts-->
   <!-- <div id='loadingmessage' style='display:none'>
       <img src='images/loader.gif'/>
</div>-->
   <div class="loading-div"><img src="images/loader.gif" ></div>
          <div id="edded_nav_cart" >
      1 item Added to cart
    </div>
         <div class="edded_wish_exists" >
      Item already in the wishlist
    </div>
         <div class="edded_to_wish" >
     item Added to wish list
    </div>
     <div class="edded_to_login" >
     Login to add item to wish list !!
    </div>
    <header>
        <div id="header_cart" class="container">
         

            <?php if($header['page'] != 'home'): ?>
            <div class="logo">
                <h1>LetaBox</h1>
                <a href="<?php echo BASE_HREF; ?>"><img src="images/logo-mid.png" alt="LetaBox"></a>
            </div>

            <div class="search">
                <!--<form action="listing" method="post">
                    <span class="icon"><?php echo file_get_contents('images/icons/search.svg'); ?></span>
                    <input type="search" name="s" id="s" placeholder="Search global ecommerce sites here...">
                    <input type="submit" value="Search">
                </form>-->
                 <form  method="get" action="listing.php">
         <input type="hidden" name="category" id="category" class="form-control input-lg" value="All">
       
         <input id="search" type="search" name="search" placeholder="Search global ecommerce sites here..." value="<?php echo @$search; ?>">
            <input id="btnSubmit" type="submit" value="Search">
        </form>
            </div>
            <?php endif; ?>

            <nav>
                <?php if($header['page'] == 'home'): ?>
                <ul>
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a></li>
                <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <ul class="right">
                    <?php    if(isset($_SESSION["user_id"])){?>
          <li><a href="my-account.php"> My account</a></li>
          <li><a href="?account=logout"> Logout</a></li>  
        <?php } else{ ?>
                    
  <li><a data-toggle="modal" href="#sUp" class="signupModal">Sign up</a></li>
  <li><a data-toggle="modal" href="#sIn"  class="signinModal">Sign in</a></li>
        <?php } ?>
          <!--<li><a data-toggle="modal" href="#cH"  class="signinModal">check out</a></li>-->
                    <li>
                        <a href="cart.php" id="cart-info"  class="icon cart-box" class="" >
                            <span class="counter"><?php 
if(isset($_SESSION["productsx"])){
	//echo count($_SESSION["productsx"]); 
	  echo array_sum(array_column($_SESSION['productsx'], 'quantity'));
}else{	echo 0; 
}

?></span>
                            <?php echo file_get_contents('images/icons/cart.svg'); ?>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </header>
    <?php
    
     if(@($_GET['account'] === 'logout')) { 
           session_destroy();
         print "<script language=\"javascript\"> 
var myurl='index.php'
window.location.assign(myurl)
</script>";
        
       
                
           }
           ?>
