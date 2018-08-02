<?php
require_once 'apiconn.php';
require_once 'partials/config.php';

$header = array(
    'page'=>'cart',
    'title'=>'shopping Cart'
);
require_once 'partials/header.php';
?>
<section class="maincontent">
    <div class="cart">
        <div class="container">
           
<?php

	if(isset($_SESSION["productsx"]) && count($_SESSION["productsx"])>0){ ?>
            <h2>Your Cart</h2>
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
		foreach($_SESSION["productsx"] as $product){                     
			$product_code = $product["product_code"];
                        $product_title = $product["title"]; 
                        $product_price = $product["price"]; 
                        $sellCost = $product["sellCost"]; 
                        $product_qty = $product["quantity"]; 
                        $thumbnail = $product["thumbnail"];
                        $icon='<img src="'.$thumbnail.'" class="icon_img"/>';                      
                        $currency='Kes';  
                        
		
              ?>
                <tr class="cart-item">
                    <td><a href="single.php?ID=<?php echo $product_code; ?>"><?php print $icon; ?></a></td>
                    <td class="hide_mob"><a href="single.php?ID=<?php echo $product_code; ?>"><?php echo $product_title; ?></a></td>
                    <td>                         <div class="nav_cart_qty">
     <div class="input-group">    
    <input type="text" name='quantity' data-code="<?php print $product_code;?>" class="form-control input-number text-center quantity" value="<?php print $product_qty;?>"/>
        <button type="button" id="add" data-code="<?php print $product_code;?>" class="add btn cart_btn"><img src="images/icons/plus.png"></button>
    <button type="button" id="sub" value='-' field="quantity" data-code="<?php print $product_code;?>" class="sub btn cart_btn"><img src="images/icons/minus.png"></button> 

     </div></div>
                    
                    </td>
                    <td><?php print wits_money($product_qty*$sellCost); ?> </td>
                    <td><a href="#" class="remove-item3" data-code="<?php print $product_code;?>">remove</a></td>
                </tr>
                <?php 
                   $subtotal = ($sellCost* $product_qty);
		$total = ($total + $subtotal);
                
                }  ?>
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
        <?php } else{ ?>
            <h3>No Items in the Cart</h3>  
            
        <?php } ?>

        </div>
    </div>
  

</section>
<?php require_once 'partials/footer.php'; ?>
<script>
    //for view cart update qty
    $(document).ready(function(){
                 $(".quantity_2").change(function() {		
		 var element = this;
		 setTimeout(function () { update_quantity.call(element) }, 2000);	
	});	
	function update_quantity() {
		var pcode = $(this).attr("data-code");
		var quantity = $(this).val(); 
		//$(this).parent().parent().fadeOut(); 
		$.getJSON( "cart_process.php", {"update_quantity":pcode, "quantityx":quantity} , function(data){		
			window.location.reload();			
		});
	}
    });
    
    //removing items from the cart
         $(".remove-item3").click(function(){	
		var pcode = $(this).attr("data-code");
                $(this).closest('tr').fadeOut('slow'); 
		$.getJSON( "cart_process.php", {"remove_code":pcode} , function(data){                   
                   $("#cart-info").html(data.items);
                   $(".cart-box").trigger( "click" );
                   window.location.reload();                  
                   
		});
	});
    
    </script>