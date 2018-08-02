<?php
// Calculator defaults (USD to KES)
/*define('USDKES_RATE',(float)$RateUSDKES);
define('EXCHANGE_FEE',0.015);
define('REALISTIC_EXCHANGE_RATE',(USDKES_RATE*(1+EXCHANGE_FEE)));
define('SHIPPING_RATE',7.99);
define('TAX_RATE',0.0875);
define('MARGIN',0.3);*/


//$products = repeatArray($oneproduct, $listItems);
?>


<ul class="slide" style="background: gray;">
    <?php
    
    $client->associateTag(AWS_ASSOCIATE_TAG);

// from now on you want to have pure arrays as response
$client->returnType(AmazonECS::RETURN_TYPE_ARRAY);
    
    if (!empty($search) && !empty($category)) {       
      
        ?>

        <?php
       //$response = json_encode($client->category($category)->search($search));
$response = json_encode($client->responseGroup('Images,ItemAttributes,VariationMatrix')->category($category)->search($search));          
$response = json_decode($response, true);

      if ($response["Items"]["Request"]["IsValid"]) {
               $Keywords = $response["Items"]["Request"]["ItemSearchRequest"]["Keywords"];
            $SearchIndex = $response["Items"]["Request"]["ItemSearchRequest"]["SearchIndex"];
            $TotalResults = $response["Items"]["TotalResults"];
            // $TotalResults =0;
            $TotalPages = $response["Items"]["TotalPages"];
            if (isset($_SESSION['user_id'])) {
                $regDate = date("Y-m-d h:i:s");
                $lbs_bill_shipping_id = $_SESSION['user_id'];

                $query2 = "INSERT INTO  lbs_history (lbs_bill_shipping_id,lbs_history_term,lbs_history_date) VALUES(?,?,?)";
                $statement2 = $mysqli->prepare($query2);
                $statement2->bind_param('iss', $lbs_bill_shipping_id, $Keywords, $regDate);
                $statement2->execute();
                if (!$statement2) {
                    die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
                }
            }          
        if ($TotalResults > 1) {
             
              $Item = $response["Items"]["Item"];
            if (is_array($Item)) {
                        $count = 1;


                foreach ($Item as $key => $value) {

                  if (is_array($value)&&!empty($response["Items"]["Item"][$key]["ASIN"]))           
                        {
                      if(empty($response["Items"]["Item"][$key]["Variations"])){
                        
                   $ASIN = $response["Items"]["Item"][$key]["ASIN"];
                        $MediumImageURL = $response["Items"]["Item"][$key]["MediumImage"]["URL"];
                        $Title = $response["Items"]["Item"][$key]["ItemAttributes"]["Title"];
                        $ListPrice = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"] : "";
                        $ListPrice = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"] : "";
                        //$Amount = !empty($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        #new
                   $LowestUsedPrice=isset($response["Items"]["Item"][$key]["OfferSummary"]["LowestUsedPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["OfferSummary"]["LowestUsedPrice"]["Amount"] : 0;
                   
                      if($ListPrice>0){
                      $Amount = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"] : 0;    
                     }
                     elseif($LowestUsedPrice!=0){
                      $Amount=$LowestUsedPrice;   
                     }
                     else{
                      $Amount=isset($response["Items"]["Item"][$key]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"] : 0;      
                    
                      }                    
                  
                        
                        $CostUSD = $Amount/100;
                        //determine weight
                      $CatWeight=DEFAULT_WEIGHT;                     
                        
                       if($response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }                 
                       else{
                        
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }                                      //end compare
                        //newest
                       $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + MARGIN);
                        //new
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/USDKES_RATE;
                        $ConvertedTotalCost_Usd=$ConvertedSellingCost/USDKES_RATE;
                        //end new
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);                       
                        
                        //new params
                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/USDKES_RATE;
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=($profitKes/$ConvertedTotalCost)*100;                        
                        //newest
                        
                        //pdt cat
               //added
                        $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
                        $DetailPageURL = $response["Items"]["Item"][$key]["DetailPageURL"];
                        $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                        //$TinyImage = $response["Items"]["Item"]["ThumbnailImage"]["URL"];

                        $EditorialReviewContent2 = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Content"];
                        $EditorialReviewContent2 = truncate($EditorialReviewContent2, 240);

                        $weightx = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]['Weight']['Units'];                    
                        
                      // $var = $response["Items"]["Item"][$key]["Variations"]["TotalVariations"];
                      
               
                       
                        
                 ?>    
    
                        
            <?php    }
            if(!empty($response["Items"]["Item"][$key]["Variations"])){
                
        $variationArray = $response["Items"]["Item"][$key]["Variations"];
       $variationDimensions = $response["Items"]["Item"][$key]["Variations"]["VariationDimensions"]["VariationDimension"];
                
            $ASIN = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ASIN"];
            $ParentASIN = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ParentASIN"];
             
                        $MediumImageURL = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["MediumImage"]["URL"];
                        $Title = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["Title"];
                        $ListPrice = isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"] : "";
                        $ListPrice = isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"] : "";
                        //$Amount = !empty($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        #new
                   $LowestUsedPrice=isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["OfferSummary"]["LowestUsedPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["OfferSummary"]["LowestUsedPrice"]["Amount"] : 0;
                   
                      if($ListPrice>0){
                      $Amount = isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;    
                     }
                     elseif($LowestUsedPrice!=0){
                      $Amount=$LowestUsedPrice;   
                     }
                     else{
                      $Amount=isset($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"] : 0;      
                    
                      }     
                        $CostUSD = $Amount/100;
                        //determine weight
                      $CatWeight=DEFAULT_WEIGHT;                     
                        
                       if($response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }                 
                       else{
                        
                        $Weight = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["Variations"]["Item"]["0"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }                                      //end compare
                        //newest
                       $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + MARGIN);
                        //new
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/USDKES_RATE;
                        $ConvertedTotalCost_Usd=$ConvertedSellingCost/USDKES_RATE;
                        //end new
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode); 
                        //new params
                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/USDKES_RATE;
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=($profitKes/$ConvertedTotalCost)*100;                       
                        //newest
                        
                        #get image
                          $id = $ASIN;
                                $ItemAttributes = array();
                                $responsex = $client->lookup($id);
                                $responsex = json_encode($client->lookup($id));
                                $responsex = json_decode($responsex, true);
                                ?>
                                                <div>
                                                <?php
                                                if ($responsex["Items"]["Request"]["IsValid"]) {
                                                    if (is_array($responsex["Items"]["Item"])) {

                                                        
                                                        $MediumImageURL= $responsex["Items"]["Item"]["MediumImage"]["URL"];
                                                        
                                                        
                                                        
                                                }}
                                                        
                                                        #end get image
            }
            
          
                }
                              $dummyImagy = 'http://via.placeholder.com/350x400';?>
    <li>
                            <div>
                                <?php //print 'ss->'.$ParentASIN; ?>
                                <div class="mob_40">
                                    
    <section class="image "> <a href="single.php?ID=<?php if(empty($variationArray)){ print $ASIN;} else{ print $ASIN; } ?>">              
                        <?php
                        if (!empty($MediumImageURL)) {
                            echo '<img class="cart_list_img" src="' . $MediumImageURL . '" alt="">';
                        } else {
                            echo '<img class="cart_list_img" src="' . $dummyImagy . '" alt="">';
                        }
                        ?>
                                    </a>
                                    <span class="hide_mob">

                                        <?php include 'addTocart.php';?>
                                    </span>
                                </section>
                                   
                                </div>
                                 <div class="mob_60">
                                <section class="name">
                                    <h3><a href="single.php?ID=<?php if(empty($variationArray)){ print $ASIN;} else{ print $ASIN; } ?>"><?php
                    if (!empty($Title)) {
                        echo truncate($Title, 40);
                    }
                    ?></a>
                                    
                                    <?php 
                                    if(!empty($variationArray)){
                     print ' ve variations';
                                           $variableString = json_encode($variationArray);
                                           //print_r($variationArray);
                                           // $variableString = print_r($variationArray, true);
               
                
                $regDate = date("Y-m-d h:i:s");
                $tempUser='x6WsgTT788#@dad';
                $query2 = "INSERT INTO  lbs_temp_history (lbs_temp_user,lbs_temp_ASIN,lbs_temp_string,lbs_temp_history_date) VALUES(?,?,?,?)";
                $statement2 = $mysqli->prepare($query2);
                $statement2->bind_param('isss',$tempUser,$ASIN,$variableString, $regDate);
                $statement2->execute();
                if (!$statement2) {
                    die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);
                }
                                    }else{              
                               print ' no variations';  
                                
                                
                                    }
                                    ?></h3>
                                </section>
                          
                             
                                <section class="price">
                                    <a href="single.php?ID=<?php if(empty($variationArray)){ print $ASIN;} else{ print $ASIN; } ?>"> <article>
                                            <p>From <?php echo 'Amazon'; ?></p>
                                            <h4><?php
                                            if (!empty($ListPrice)) {
                                                //echo $FormattedPrice;
                                                echo wits_money($ConvertedSellingCost);
                                            } else {
                                                //echo $FormattedPrice;
                                                   echo wits_money($ConvertedSellingCost);
                                            }
                                            ?></h4>
                                        </article>
                                    </a>
                                    <p class="right">
                                        <span><?php echo $product['likes']; ?></span>
                                    <form class="wish-form">

                                        <input class="user_id_wish" name="user_id_wish" type="hidden" value="<?php if(isset($_SESSION['user_id'])){print $_SESSION['user_id']; } else{ print '';}  ?>"> 
                                        <input name="product_code22" type="hidden" value="<?php print $ASIN; ?>"> 
                                        <input name="add_to_wish" type="hidden" > 

                                        <button type="submit" class="wish_btn" name="test_wish"  > <img src="images/icons/heart.png" class="hide_mob"/>
                                        <img src="images/icons/heart2.png" class="hide_desk wish_list_heart"/></button>
                                    </form>
                                    </p>
                                    <span class="clearfix"></span>
                                </section>
                                      <span class="hide_desk">

                                        <?php include 'addTocart.php';?>
                                    </span>
                                 </div>
                            </div>
                        </li>
     

                
            
           <?php }
            
            
        }
         

        }
        else{
       print "<script language=\"javascript\"> var myurl='no-results.php?search=$Keywords'
window.location.assign(myurl)
</script>";
        }
        ?>

    <?php
    } }
?>
</ul>



