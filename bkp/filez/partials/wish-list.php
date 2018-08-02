<ul class="slide">
    <?php
$project_desc1 = $mysqli->query("SELECT * from lbs_wish WHERE lbs_bill_shipping_id=".$_SESSION['user_id']." LIMIT 5")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
  if ($project_desc1->num_rows <1) {?>
                                       No Records                                  
                                            
  <?php }
  else{
      
      
               

   while($obj_ona1= $project_desc1->fetch_object())
     {
       //get pdt particularts
      $ItemAttributes = array();
  
  $response = $client->lookup($obj_ona1->lbs_wish_productcode);
    
  $response  = json_encode( $client->lookup($obj_ona1->lbs_wish_productcode));
  
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
		  $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
		  $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
		  $ConvertedWeight = !empty($Weight)?$Weight/100:0;
		  
		  $Amount = $Amount/100;
		  $BuyingCost = ($Amount+SHIPPING_RATE)*(1+TAX_RATE);
		  $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
		  $TotalCost = $BuyingCost+($ConvertedWeight/2.2*10);
		  $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
		  $ConvertedSellingCost = $ConvertedTotalCost*(1+0.16);
		  $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                $dummyImagy='http://via.placeholder.com/350x400';
       ?>

    <li>
        <div>
            <section class="image"> <a href="single.php?ID=<?php print $ASIN; ?>">              
                              <?php if( !empty($MediumImageURL) ){
				echo '<img class="cart_list_img" src="'. $MediumImageURL .'" alt="">';
				}
                                else{
                              echo '<img class="cart_list_img" src="'.$dummyImagy.'" alt="">';      
                                }
                                
                                ?>
                </a>
                <span>
                    
                    <form  class="form-item">		
                                        <!-- <input name="price" type="hidden" value="<?php //echo round($ConvertedSellingCost, 2) ;?>">-->
                                           <input name="price" type="hidden" value="<?php echo $Amount;?>">
                                           <input name="sellCost" type="hidden" value="<?php echo $ConvertedSellingCost;?>">
                                         
                                       <input name="title" type="hidden" value="<?php print $Title;?>">
        <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                 <input name="product_code" type="hidden" value="<?php print $ASIN;?>">
                    <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL;?>">                 
                                   <input name="product_code" type="hidden" value="<?php print $ASIN;?>">  
                                   <input name="product_url" type="hidden" value="<?php print $DetailPageURL;?>">   
                              
                                   <button type="button" data-toggle="modal"  data-target="#qView" data-id="<?php print $MediumImageURL.'!#@'.$Amount.'!#@'.$ConvertedSellingCost.'!#@'.$ASIN.'!#@'.$Title.'!#@'.$DetailPageURL ?>" class="button btn_push small-btn yob-btn quickViewModal">Quick View</button> 
                                        <button type="submit" class="button small-btn boy-btn" >Add to Cart</button>
                                        <p>
                                            <?php print $EditorialReviewContent2; ?>
                                        </p>

<!--
                                                                                                             <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>

    <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL.'!#@'.round($ConvertedSellingCost, 2).'!#@'.$ASIN.'!#@'.$Title.'!#@'.$DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->
                               
                                 
                                          </form>
                </span>
            </section>
            <section class="name">
                <h3><a href="single.php?ID=<?php print $ASIN; ?>"><?php if( !empty($Title) ){
					echo truncate($Title,40);
				}?></a></h3>
            </section>
            <section class="price">
               <a href="single.php?ID=<?php print $ASIN; ?>"> <article>
                    <p>From <?php echo 'Amazon'; ?></p>
                    <h4><?php if( !empty($ListPrice) ){
					echo $FormattedPrice ;                    
				}else{							  
					echo $FormattedPrice;
				} ?></h4>
                </article>
               </a>
                <p class="right">
                      <span><?php echo $product['likes']; ?></span>
                <form class="wish-form">
                      
                                 
                                   <input name="product_code22" type="hidden" value="<?php print $ASIN;?>"> 
								      <input name="add_to_wish" type="hidden" > 
                                                               
                        <button type="submit" class="wish_btn" name="test_wish" > <img src="images/icons/heart.png"/></button>
                                                                      </form>
                </p>
                <span class="clearfix"></span>
            </section>
        </div>
    </li>
  <?php }
  
      }
  }
     } ?>

</ul>

 



