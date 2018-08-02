<div id="top-cart-collapse2" class="row beforebanner">
   
  <div id="cart_list_count" class="col-md-2">
      <a href="#" class="incart_update">
      <?php 
if(isset($_SESSION["productsx"])){
	echo count($_SESSION["productsx"]).' products in cart'; 
}else{
	echo 0; }
?>
      </a>
      
  </div>
    <div id="cart_slider" class="col-md-8">
           <?php
   /* if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ 
		print '<ul class="cart-products-loaded2">';
		foreach($_SESSION["productsx"] as $product){ 
			$product_code = $product["product_code"];
                        $quantity = $product["quantity"];
                        $thumbnail = $product["thumbnail"];                    
 print '<li class="cart-item my_list alert alert-dismissable"> <a data-code="'.$product_code.'" class="close remove-item2" >remove item</a> <img class="img-responsive" src="'.$thumbnail.'" alt="">';
                     
          // print '<li class="cart-item my_list alert alert-dismissable"> <a data-code="'.$product_code.'" class="close remove-item2" >remove item</a> <img class="img-responsive" src="http://via.placeholder.com/70x50" alt="">';
           print  '<input type="number" data-code="'.$product_code.'" class="form-control text-center quantity" value="'.$quantity.'"></li>';
   }
		print "</ul>";
		
	}?>*/
        
if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){?>
        <div  class="flexslider carousel">
  <ul class="slides cart-products-loaded2">
      <?php
    foreach($_SESSION["productsx"] as $product){ 
          $product_code = $product["product_code"];
          $quantity = $product["quantity"];
           $thumbnail = $product["thumbnail"];   
      ?>
    <li class="cart-item my_list alert alert-dismissable">
        <a data-code="<?php print $product_code?>" class="close remove-item2" >remove item</a> <img class="img-responsive" src="<?php print $thumbnail;?>" alt=""> 
         <?php   print  '<input type="number" data-code="'.$product_code.'" class="form-control text-center quantity" value="'.$quantity.'">';?>
    </li>
      <?php } ?>
    
 
  </ul>
      <?php } ?>
          
</div>
        <!--new car-->
        <?php       //if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ ?>
         <!--<div id="myCarousel" class="carousel prod-Carousel noslide" data-interval="0">
    
    <div class="container">
      <div class="row product-list">
		<?php	
          
		/*echo '<div class="carousel-inner products-carousel">';
		
			$count = 1;
			//foreach( $Item as $key => $value ){
                          foreach($_SESSION["productsx"] as $product){ 
           $product_code = $product["product_code"];
          $quantity = $product["quantity"];
           $thumbnail = $product["thumbnail"]; 
				
				$active = $count==1?$active="active":$active="";				
				echo '<div class="item '.$active.'">';
				
				echo '<div class="col-md-3">';				
                               // echo $product_code;?>
		     <a data-code="<?php print $product_code?>" class="close remove-item2" >remove item</a> <img class="img-responsive" src="<?php print $thumbnail; ?>" alt=""> 
         <?php   print  '<input type="number" data-code="'.$product_code.'" class="form-control text-center quantity" value="'.$quantity.'">';?>		
				<?php
				
				echo "</div>";// <!-- /.col-md-3 -->
				
				echo "</div>";// <!-- /.item -->
				
				$count++;
				
			}
			
	
		echo "</div>";*/// <!-- /.carousel-inner -->
                
              
        ?>
        
      </div> <!-- /.product-list -->
    <!-- </div> <!-- /.container -->
    
    <!-- Left and right controls -->
    <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> 
    <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a>
    
  </div>-->
        <?php   //} ?>
        <!--end new carf-->
       
    </div>
  <div class="col-md-2">
     <?php if(isset($_SESSION["productsx"])){ ?>
      <a class="btn btn-warning" href="view_cart.php">View cart</a><br>
      <a class="btn btn-warning" href="checkout.php">Checkout</a>
     <?php } else{ ?>
       <a class="btn btn-warning" href="#">View cart</a><br>
      <a class="btn btn-warning" href="#">Checkout</a>
     <?php } ?>
      
  </div>  
  </div>
  
  
  