<?php

require_once 'partials/config.php';

$header = array(
    'page'=>'single',
    'title'=>'Product details'
);
require_once 'partials/header.php';
?>
<?php
//$source = isset( $_GET['source'] )?$_GET['source']:"";
$productID = isset( $_GET['ID'] )?$_GET['ID']:0;
if(!empty($productID) ) {
?>
<section class="maincontent listing">

    <?php include_once 'partials/bar.inc.php'; ?>

    <div class="singlelist">

        <div class="item">
            <?php
  //Variables
  $ItemAttributes = array();
  
  $response = $client->lookup($productID);
    
  $response  = json_encode( $client->lookup($productID) );
  
  $response = json_decode($response, true);
  //echo $response->Items->Request->IsValid;
  if( $response["Items"]["Request"]["IsValid"] ) {
    
      if( is_array( $response["Items"]["Item"] ) ) {			
              
          $ASIN = $response["Items"]["Item"]["ASIN"];
		  $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
		  $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                  $MediumImageURL = $response["Items"]["Item"]["MediumImage"]["URL"];
		  $ItemAttributes["Binding"] = $response["Items"]["Item"]["ItemAttributes"]["Binding"];
		  $ItemAttributes["Brand"] = $response["Items"]["Item"]["ItemAttributes"]["Brand"];
		  $ItemAttributes["Color"] = $response["Items"]["Item"]["ItemAttributes"]["Color"];
          $ItemAttributes["Manufacturer"] = $response["Items"]["Item"]["ItemAttributes"]["Manufacturer"];
		  $ItemAttributes["Model"] = $response["Items"]["Item"]["ItemAttributes"]["Model"];
		  $ItemAttributes["Size"] = $response["Items"]["Item"]["ItemAttributes"]["Size"];
		  $Title = $response["Items"]["Item"]["ItemAttributes"]["Title"];
          $ListPrice = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]:"";
		  $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
		  $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]:"";
		/*  $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
		  $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
		  $ConvertedWeight = !empty($Weight)?$Weight/100:0;*/
                        //determine weight
                       $CatWeight=456;
                        
                       if($response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }
                 
                       else{
                        
                        $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }
                  
		  
		  $Amount = $Amount/100;
		  $BuyingCost = ($Amount+SHIPPING_RATE)*(1+TAX_RATE);
		  $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
		  $TotalCost = $BuyingCost+($ConvertedWeight/2.2*10);
		  $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
		  $ConvertedSellingCost = $ConvertedTotalCost*(1+0.16);
		  $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                  //new variables added
                     // $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"][1]["URL"];
                   $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"]["1"]["URL"];
                         //new params
                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/REALISTIC_EXCHANGE_RATE;
                        $ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=$profitKes/$ConvertedTotalCost;
  ?>
            <div class="container"><br><br>

                <h2><?php print $Title;?></h2>
                <p class="subtitle">From Amazon</p>
                <div class="gallery itemGall">
                    <ul>
                    
                         <?php
			  foreach(array_slice( $response["Items"]["Item"]["ImageSets"]["ImageSet"],0,4) as $value ){
                              //$visa=$value["MediumImage"]["URL"];
                               $visa=$value["LargeImage"]["URL"];
                               if (!empty($value)) {
				?>
                        <li>
                            <a href="<?php print $visa;?>">
                                <img src="<?php print $visa;?>" alt="">
                            </a>
                        </li>
                               <?php }  }
                          ?>
			 
                    </ul>
                    <img src="<?php echo $LargeImageURL;?>" alt="" id="mainGall">
                    <span class="clearfix"></span>
                </div>

                <div class="specs">
                    <h3><?php print $FormattedPrice; ?>/=</h3>
                   <!-- <p class="rating ratingStars"><?php //echo ratingstars(2); ?></p>-->
                   <!-- <p class="units">
                        <span>1 Unit</span>
                        <a href=""><?php echo file_get_contents('images/icons/plus.svg'); ?></a>
                        <a href=""><?php echo file_get_contents('images/icons/minus.svg'); ?></a>
                    </p>-->
                    <form  class="form-item ">
                                  <!--new params-->
                                             <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                             <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                              <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                                <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                              <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                                <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                                <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                            <!--end new params-->
                             <input name="price" type="hidden" value="<?php print $Amount;?>">
                                       <input name="title" type="hidden" value="<?php print $Title;?>">
                                             <div class="nav_cart_qty">
     <div class="input-group">    
    <input type="text" data-code="<?php print $product_code;?>" name="quantity" class="form-control input-number text-center quantity" value="1"/>
        <button type="button" id="add" data-code="<?php print 'nullz';?>" class="add btn cart_btn"><img src="images/icons/plus.png"></button>
    <button type="button" id="sub" value='-' field="quantity" data-code="<?php print 'nullz';?>" class="sub btn cart_btn"><img src="images/icons/minus.png"></button> 
             <input name="product_code" type="hidden" value="<?php print $ASIN;?>"> 
                 <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL;?>">   
                  <!-- <input name="product_link" type="hidden" value=""> --> 
            
                 

     </div></div>
                                       
                            
                                            <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost, 2); ?>">            
                                    
                                            <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>                                        
                                            <input name="product_url" type="hidden" value="<?php print $DetailPageURL; ?>"> 
                             <div class="float_cart_actions">
                    <!-- <a href="checkout.php" class="btn btn-sm btn-primary btn_addcart_abs2" >1 click checkout</a>-->
  <button type="submit" class="button small-btn boy-btn btn_addcart_abs" >Add to Cart</button>
  <br><br>
                 </div>
                    </form>
                </ul>
                    <article>
                        <h4>Brief description</h4>
                        <p class="brief">
                            <?php if( !empty($response["Items"]["Item"]["EditorialReviews"]) ){	
                            $EditorialReviewSource = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Source"];
			$EditorialReviewContent2 = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Content"];
                        echo truncate($EditorialReviewContent2,240) ;
                             } ?>
                        </p>
                    </article>
                    <p class="readmore">
                        <a href="#" id="toshop"  class="button yob-btn">Back to shop</a>
                        <a data-toggle="modal" href="#cH" class="button yob-btn">1 Click Checkout</a>
                          <!--<button type="submit" class="button small-btn boy-btn btn_addcart_abs" >Add to Cart</button>-->
                      <!--  <a href="cart" class="button boy-btn">Add to Cart</a>-->
                    </p>
                </div>
                <span class="clearfix"></span>

            </div>
        </div>
        <div class="container">
          <?php
           /* echo '<ul class="features-list">';
			  foreach( $response["Items"]["Item"]["ItemAttributes"]["Feature"] as $key =>  $value ){
				  echo '<li>'. $value .'</li>';
			  }
			  echo '</ul><hr>';*/
                        /*
                          echo '<ul class="features-list">';
			  foreach( $response["Items"]["Item"]["ImageSets"]["ImageSet"] as $value ){
				  echo '<li>'. $value["MediumImage"]["URL"] .'</li>';
			  }
			  echo '</ul>'*/

                          
          ?>
        </div>

        <div class="description">
            <div class="container">

                <div class="tabs">
                    <ul class="horizontal tablinks">
                        <li><a href="#desc">Description</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                    </ul>

                    <div id="desc" class="desc tab">
                        <h3>Product Description</h3>
                        <p><?php echo $EditorialReviewContent2; ?></p>
                    </div>

                    <div id="reviews" class="reviews tab">
                        <?php
                       //print 'vaa<br>'.$DetailPageURL ;
                       /*echo '<ul class="features-list">';
			  foreach( $response["Items"]["Item"]["ItemLinks"]["ItemLink"] as $value ){
				  echo '<li>'. $value["Description"]["URL"] .'</li>';
			  }
			  echo '</ul>'*/
                   
                      
                        ?>
               
                        <iframe src="<?php print $response["Items"]["Item"]["CustomerReviews"]["IFrameURL"];?>"  width="100%" height="500" frameborder="0"
        allowfullscreen sandbox>
  <p> <a href="<?php print $response["Items"]["Item"]["CustomerReviews"]["IFrameURL"];?>">
   
  </a> </p>
</iframe>
                        
                        
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="list similar rex_scroller">
        <div class="container">

            <h3>Similar Products</h3>

            <?php
                //$listItems = 17;
               // include_once 'partials/list.inc.php';
            ?>
            <ul class="slide ">
               
<?php 
 
foreach(array_slice($response["Items"]["Item"]["SimilarProducts"]["SimilarProduct"],0,5) as $value ){ ?>
    <li>
        <?php
                                 $id=$value["ASIN"];
   $ItemAttributes = array();  
  $response = $client->lookup($id);    
  $response  = json_encode( $client->lookup($id) );  
  $response = json_decode($response, true);
        ?>
        <div>
            <?php
              if( $response["Items"]["Request"]["IsValid"] ) {
                if( is_array( $response["Items"]["Item"] ) ) {			
              
    $ASIN = $response["Items"]["Item"]["ASIN"];
    $MediumImageURL2=$response["Items"]["Item"]["MediumImage"]["URL"];
     $Title2 = $response["Items"]["Item"]["ItemAttributes"]["Title"];
      $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
      
      //additional
       $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]:0;
		  $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"])?$response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]:"";
	
                   //determine weight
                       $CatWeight=456;
                        
                       if($response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }
                 
                       else{
                        
                        $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }
        $Amount = $Amount/100;
		  $BuyingCost = ($Amount+SHIPPING_RATE)*(1+TAX_RATE);
		  $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
		  $TotalCost = $BuyingCost+($ConvertedWeight/2.2*10);
		  $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
		  $ConvertedSellingCost = $ConvertedTotalCost*(1+0.16);
		  $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                       //new params
                  

                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/REALISTIC_EXCHANGE_RATE;
                        $ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=$profitKes/$ConvertedTotalCost;
                  
                  
?>
            <section class="image xx">
                <img src="<?php echo $MediumImageURL2; ?>" alt="">
               <!-- <span>
                    <a href="#" class="button small-btn yob-btn quickViewModal">Quick View</a><br />
                   <!-- <a href="" class="button small-btn boy-btn">Add to Cart</a>
                </span>-->
                 <span>
                    
                    <form  class="form-item">	
                             <!--new params-->
                                             <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                             <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                              <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                                <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                              <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                                <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                                <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                            <!--end new params-->
                                         <input name="price" type="hidden" value="<?php echo $Amount;?>">
                                          <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost, 2); ?>">    
                                       <input name="title" type="hidden" value="<?php print $Title2;?>">
        <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                 <input name="product_code" type="hidden" value="<?php print $ASIN;?>">
                    <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL2;?>">                 
                                   <input name="product_code" type="hidden" value="<?php print $ASIN;?>">  
                                   <input name="product_url" type="hidden" value="<?php print $DetailPageURL;?>">  
                                   
                                     
                                    
                                   <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>   
                               
                                      
                              
   <button type="button" data-toggle="modal"  data-target="#qView" data-id="<?php print $MediumImageURL.'6!#@6'.$Amount.'6!#@6'.$ConvertedWeight.'6!#@6'.$ConvertedSellingCost .'6!#@6'.$ASIN.'6!#@6'.$Title .'6!#@6'.$DetailPageURL ?>" class="button btn_push small-btn yob-btn quickViewModal">Quick View</button> 
                                        <button type="submit" class="button small-btn boy-btn" >Add to Cart</button>
                                        <p>
                                            <?php //print $EditorialReviewContent2; ?>
                                        </p>

<!--
                                                                                                             <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>

    <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL.'!#@'.round($ConvertedSellingCost, 2).'!#@'.$ASIN.'!#@'.$Title.'!#@'.$DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->
                               
                                 
                                          </form>
                </span>
            </section>
            <section class="name">
                <h3><a href="single"><?php if( !empty($Title2) ){
					echo truncate($Title2,40);
				}?></a></h3>
            </section>
            <section class="price">
                <article>
                    <p>From <?php echo 'Amazon'; ?></p>
                    <h4><?php echo 'Ksh. '.$Amount; ?></h4>
                </article>
                <p class="right">
                    <span><?php echo $product['likes']; ?></span>
                   <!-- <a href="#" class="wishlist outline"><?php //echo file_get_contents('images/icons/heart.svg'); ?></a>--0-->
                   <form class="wish-form">
                      
                                 
                                   <input name="product_code22" type="hidden" value="<?php print $ASIN;?>"> 
								      <input name="add_to_wish" type="hidden" > 
                                                               
                        <button type="submit" class="wish_btn" name="test_wish" > <img src="images/icons/heart.png"/></button>
                                                                      </form>
                </p>
                <span class="clearfix"></span>
            </section>
            
            <?php
  }
      ?>
            
        </div>
    </li>
<?php      } } ?>
</ul>
            
          
            <span class="clearfix"></span>

        </div>
    </div>
    

</section>
      <?php } } } ?>
<?php require_once 'partials/footer.php'; ?>
<script>
$(document).ready(function(){$('#qView').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
     $.ajax({
            type : 'post',
            url : 'cart_process.php', 
            data :  'rowid='+ rowid, 
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });});
     </script>

