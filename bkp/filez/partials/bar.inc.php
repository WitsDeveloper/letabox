<div id="wits_barx" class="bar">
  
    <div id="top-cart-collapse2" class="container">

      
        <div class="container1">
            <?php  if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ ?>
            <h2><?php
       
	
            echo array_sum(array_column($_SESSION['productsx'], 'quantity'));


?> Products in Cart</h2>
            <?php } ?>
        </div>
          <div class="container2 container_slider">
     
        <?php
        
if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){?>      
  <ul class="slides cart-products-loaded2">
      <?php
    foreach($_SESSION["productsx"] as $product){ 
          $product_code = $product["product_code"];
          $quantity = $product["quantity"];
          $thumbnail = $product["thumbnail"];   
          $title= $product["title"];  
          $product_price = $product["price"]; 
          $sellCost = round($product["sellCost"],2);
          
      ?>
       <li>
                <div class="yiana">
<div class="image visa" style="background-size: cover !important; background-position: top center !important;height: 86px;background:url( <?php if($thumbnail!=''){echo $thumbnail;} else{ echo $dummyImagy; }?>); ">
                      <!--  <a href="">
                            <img src="<?php //print $thumbnail;?>" alt="">
                        </a>-->
                    </div>
                    <div class="info invo">
                        <h3><a href="<?php echo $product['href']; ?>"><?php echo truncate($title,25); ?></a></h3>
                     
                       <div class="input-group"> 
    <input type="text" data-code="<?php print $product_code;?>" class="nav_cart_btn input-number text-center quantity" value="<?php print $quantity;?>"/>
    <button type="button" id="add" data-code="<?php print $product_code;?>" class="add btn cart_plus_min"><img src="images/icons/plus_w.png"></button>
    <button type="button" id="sub" data-code="<?php print $product_code;?>" class="sub btn cart_plus_min"><img src="images/icons/minus_w.png"></button> 
     </div>
                                <a  class="" >
                                        <?php if($quantity==1){ print 'Unit'; } else{ print 'Units';} ?><br><?php 
                           
                                print wits_money($sellCost);
                                //print $FormattedPrice = substr_replace($sellCost, '99', -2);
                           
                           
                           ?></a>
                        <br>
                           <a data-code="<?php print $product_code?>" class="close remove-item2" >remove</a>
                    
                   
                    </div>
                  
                </div>
            </li>
 
      <?php } ?>   
 
  </ul>
      <?php } ?>
          
          </div>
              <div class="container3">
        <article class="spacer_nav">
                <?php if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ ?>
      <a class="button small-btn boy-btn" href="cart.php">View cart</a><br>
      <a class="button small-btn bow-btn" data-toggle="" href="checkout.php">Checkout</a>
     <?php 
     
    
     $total = 0;
		foreach($_SESSION["productsx"] as $product){                    
		
                        $sellCost= $product["sellCost"]; 
                       
                        $product_qty = $product["quantity"];                                                                
                         $currency='Ksh'; 
                         $subtotal = ($product_price * $product_qty);
                         $sellCostTotal = ($sellCost * $product_qty);
			$total = ($total + $subtotal);
   	}
             print '<br><div class="mbaaaa"><a >'.wits_money($total).'</a></div>';
                }
     

      
      
      ?>
       
        </article><span class="clearfix"></span>
        <span class="clearfix"></span>
              </div>
    </div>
</div>

