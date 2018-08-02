<div id="wits_barx" class="bar">
 

    <div id="top-cart-collapse2" class="container ms-account-wrapper">
        <!--<img id="drawer-hqandle" src="images/error.png" class="mob_vinga drawer-handle"/>-->
        <i id="drawer-hqandle" class="fas fa-times mob_vinga drawer-handle"></i>

        <div class="container1">
 

            <h2 class="hide_desk your_cart_mob">

                Your Cart</h2>
            <br>
               <?php if (count($_SESSION["productsx"])< 1) { ?>
                <br>
                <div class="hide_desk"><h2 class=" your_cart_mob" style= "background: transparent;  color: red;  border: 0px; font-size: 16px !important;">

                Empty Cart</h2>
            <br>    <br>
            <i class="fas fa-cart-plus" style="font-size: 35px;text-align: center; color: black;"></i>
                <br>
                 <br>
    </div>
    
    
    <?php } ?>
            <?php if (isset($_SESSION["productsx"]) && count($_SESSION["productsx"]) > 0) { ?>
                <h2><?php
                    echo array_sum(array_column($_SESSION['productsx'], 'quantity'));
                    ?> Products in Cart</h2>
                <?php } ?>
        </div>
        <div class="container2 container_slider">

            <?php if (isset($_SESSION["productsx"]) && count($_SESSION["productsx"]) > 0) { ?>    

                <ul class="slides cart-products-loaded2">
                <?php
                foreach ($_SESSION["productsx"] as $product) {
                    $product_code = $product["product_code"];
                    $quantity = $product["quantity"];
                    $thumbnail = $product["thumbnail"];
                    $title = $product["title"];
                    $product_price = $product["price"];
                    $sellCostF = round($product["sellCost"], 2);
                    $sellCost = $product["sellCost"];
                    ?>
                        <li>
                            <div class="yiana">
         <div class="image visa">
             <img src="<?php if ($thumbnail != '') { echo $thumbnail;} else { echo $dummyImagy;} ?>" class=""/>
                                </div>
                                <div class="info invo">
                                    <a data-code="<?php print $product_code ?>" class="close remove-item2" ><i class="fas fa-times"></i></a>
                                    <h3><a href="<?php echo $product['href']; ?>"><?php echo truncate($title, 25); ?></a></h3>
                                     <h3><a href="#">Seller: Amazon</a></h3>

                                    <div class="input-group"> 
                                        <input type="text" data-code="<?php print $product_code; ?>" class="nav_cart_btn input-number text-center quantity" value="<?php print $quantity; ?>"/>
                                        <button type="button" id="add" data-code="<?php print $product_code; ?>" class="add btn cart_plus_min">
                                            <img src="images/icons/plus_w.png" class="hide_mob">
                                                <img src="images/icons/plus.png" class="hide_desk">
                                        </button>
                                        <button type="button" id="sub" data-code="<?php print $product_code; ?>" class="sub btn cart_plus_min">
                                            <img src="images/icons/minus_w.png" class="hide_mob">
                                         <img src="images/icons/minus.png" class="hide_desk"></button> 
                                           <a  class="" >
        <?php if ($quantity == 1) {
            print 'Unit';
        } else {
            print 'Units';
            } ?></a>
                                    </div>
                                  <div class="mob_price_bar"> <a  class="" ><br><?php
                                        print wits_money($sellCost);
                                        //print $FormattedPrice = substr_replace($sellCost, '99', -2);
                                        ?></a>
                                         
                 </div>
                                 
                                 
                              


                               

                            </div>
                        </li>

    <?php } ?>   

                </ul>
<?php } ?>

        </div>
        <div class="container3">
            <article class="spacer_nav">
            <br>
<?php if (isset($_SESSION["productsx"]) && count($_SESSION["productsx"]) > 0) { ?>
                    <a class="button small-btn hide_mob boy-btn" href="cart.php">View cart</a><br>
                    <a class="button small-btn bow-btn" data-toggle="" href="checkout.php">Check out</a>
    <?php
    $total = 0;
    foreach ($_SESSION["productsx"] as $product) {

        $sellCost = $product["sellCost"];

        $product_qty = $product["quantity"];
        $currency = 'Ksh';
        //$subtotal = ($product_price * $product_qty);
        $sellCostTotal = ($sellCost * $product_qty);
        $total = ($total + $sellCostTotal);
    }
    print '<br><div class="mbaaaa"><b>Total:</b> <a >' . wits_money($total) . '</a></div>';
}
?>

            </article><span class="clearfix"></span>
            <span class="clearfix"></span>
        </div>
    </div>
</div>

<!-- for the left  nav--><!--end for the left nav-->

