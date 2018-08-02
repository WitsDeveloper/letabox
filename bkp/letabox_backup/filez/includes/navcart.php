<div id="top-cart-collapse2" class="row beforebanner">
   
  <div id="cart_list_count" class="col-md-2">
      <br> <br>
      <a href="#" class="incart_update">
          <strong style="color: black !important;">
      <?php 
if(isset($_SESSION["productsx"])){
	echo count($_SESSION["productsx"]).' products in cart'; 
}else{
	echo 'No product in the cart'; }
?>
          </strong>
      </a>
      
  </div>
    <div id="cart_slider" class="col-md-8">
           <?php
        
if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){?>
        <div  class="flexslider carousel">
  <ul class="slides cart-products-loaded2">
      <?php
    foreach($_SESSION["productsx"] as $product){ 
          $product_code = $product["product_code"];
          $quantity = $product["quantity"];
          $thumbnail = $product["thumbnail"];   
          $title= $product["title"];  
          
      ?>
    <li class="cart-item my_list alert alert-dismissable row">
        <div class="fif"><img class="img-responsive" src="<?php print $thumbnail;?>" alt=""> </div> 
     <div class="fif2">
            <div class="nav_cart_qty">
     <div class="input-group">  
         <p><?php print $title;?></p>
    <button type="button" id="sub" data-code="<?php print $product_code;?>" class="sub btn btn-warning">-</button>
   <!-- <input type="text" id="1" value="0" class="field" />-->
    <input type="text" data-code="<?php print $product_code;?>" class="form-control input-number text-center quantity" value="<?php print $quantity;?>"/>
    <button type="button" id="add" data-code="<?php print $product_code;?>" class="add btn btn-success">+</button>
     </div></div>
            <a data-code="<?php print $product_code?>" class="close remove-item2" >remove item</a>
     </div>

    </li>
      <?php } ?>   
 
  </ul>
      <?php } ?>
          
</div>
        	<div class="row">
	
        
       
                        <div class="col-lg-2">
                                   
                        </div>
	</div>
        
       
    </div>
  <div class="col-md-2">
      <br> 
     <?php if(isset($_SESSION["productsx"])){ ?>
      <a class="btn btn-warning" href="view_cart.php">View cart</a><br>
      <a class="btn btn-warning" href="checkout.php">Checkout</a>
     <?php } ?>
      
  </div>  
  </div>


  
  
  