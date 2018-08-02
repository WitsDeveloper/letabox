
    <header class="header">
  <!-- Navigation -->
  
<nav class="navbar navbar-inverse navbar-fixed-top">
                  <div class="container-fluid"><div class="row"><div class="col-md-3">
             <div class="navbar-header">
   <div class="navbar-cart-toggle navbar-toggle" data-toggle="collapse" data-target="#top-cart-collapse">
          <span class="glyphicon glyphicon-shopping-cart"></span>
        </div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-menu-collapse">
          <span class="sr-only">Toggle navigation</span> 
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./"> <img src="images/logo.JPG" alt=""> </a> 
    </div>
              </div>
 <div class="col-md-6">
<?php if(basename($_SERVER['PHP_SELF'])!='index.php'){ 
    include 'pdt_search.php';
 
 } ?>
 </div><div id="top-menu-collapse" class="col-md-3">
       <ul class="nav navbar-nav navbar-right">     
        <?php    if(isset($_SESSION["user_id"])){?>
          <li><a href="my-account.php"> My account</a></li>
          <li><a href="cart-process.php?account=logout" data-toggle="modal" data-target="#myModal2"> Logout</a></li>  
        <?php } else{ ?>
           <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="#" data-toggle="modal" data-target="#myModal2"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> 
          
        <?php } ?>
          
                  
<?php 
if(isset($_SESSION["productsx"])){
	echo '<li> <a href="view_cart.php" class="cart-box" id="cart-info" title="View Cart"><i class="fa fa-shopping-cart"></i> '.count($_SESSION["productsx"]).'</a></li>'; 
}else{
	echo '<li> <a href="view_cart.php" class="cart-box" id="cart-info" title="View Cart"><i class="fa fa-shopping-cart"></i>  0</a></li>'; 
}
?>
               
       
        </ul>
  </div> </div> </div> 
</nav>

  
  
  <?php
include 'includes/signup.php';
include 'includes/signin.php';

  ?>
</header>

    
    
    
  <!-- Navigation -->
  
  
  
  <?php
//include 'includes/signup.php';
//include 'includes/signin.php';

  ?>

