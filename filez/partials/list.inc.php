<?php

function repeatArray($array, $repeat) {
    $result = array();
    $eCount = count($array);
    for ($j = 0; $j < $repeat; $j++) {
        $result[] = $array[0];
    }
    return $result;
}

$listItems = isset($listItems) ? $listItems : 5;
$oneproduct = array(
    array(
        'name' => 'iPhone X',
        'href' => '',
        'image' => '13.png',
        'from' => 'Amazon',
        'fromUrl' => 'amazon.com',
        'price' => '169,999',
        'likes' => '567'
    )
);

$products = repeatArray($oneproduct, $listItems);
?>
<ul class="slide" style="background: gray;">
    <?php
    if (!empty($search) && !empty($category)) {
        ?>

        <?php
        $response = json_encode($client->category($category)->search($search));
        $response = json_decode($response, true);
        if ($response["Items"]["Request"]["IsValid"]) {
            ?>


            <?php
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
            ?> 





        <?php
        //echo '<div class="carousel-inner products-carousel">';
        if ($TotalResults > 1) {
            $Item = $response["Items"]["Item"];
            if (is_array($Item)) {
                $count = 1;


                foreach (array_slice($Item, 0, 20) as $key => $value) {

                    if (is_array($value)) {
                        $ASIN = $response["Items"]["Item"][$key]["ASIN"];
                        $MediumImageURL = $response["Items"]["Item"][$key]["MediumImage"]["URL"];
                        $Title = $response["Items"]["Item"][$key]["ItemAttributes"]["Title"];
                        $ListPrice = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"] : "";
                        $ListPrice = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"] : "";
                        $Amount = !empty($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"][$key]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        
                        //determine weight
                       $CatWeight=456;
                        
                       if($response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]){
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                       }
                 
                       else{
                        
                        $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight/100;
                       }

                        //new weight
                        //$myweight = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];


                        $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + 0.16);
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                        $FormattedPrice = substr_replace($FormattedPrice, '99', -2);
                        
                        //new params
                        $profitKes=$ConvertedSellingCost-$ConvertedTotalCost;
                        $profitUsd=$profitKes/REALISTIC_EXCHANGE_RATE;
                        $ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage=$profitKes/$ConvertedTotalCost;
                        
                        //pdt cat
                        
       //$pdtCat = $response["Items"]["Item"][$key]["ItemAttributes"]["Binding"];


                        //added
                        $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
                        $DetailPageURL = $response["Items"]["Item"][$key]["DetailPageURL"];
                        $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                        //$TinyImage = $response["Items"]["Item"]["ThumbnailImage"]["URL"];

                        $EditorialReviewContent2 = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Content"];
                        $EditorialReviewContent2 = truncate($EditorialReviewContent2, 240);

                        $weightx = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]['Weight']['Units'];
                        //foreach ( $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"] as $t):
                        // echo $weightx = $t['weight'].'<br> ';
                        //endforeach;
                    } else {
                        $ASIN = $response["Items"]["Item"]["ASIN"];
                        $MediumImageURL = $response["Items"]["Item"]["MediumImage"]["URL"];
                        $Title = $response["Items"]["Item"]["ItemAttributes"]["Title"];
                        $ListPrice = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"] : "";
                        $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                        $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                        $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;

                        //my weight
                        //$myweight = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                        /* $weightx = '';
                          foreach ( $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"] as $t):
                          echo $weightx = $t['weight'].'<br> ';
                          endforeach; */
                        $weightx = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]['Weight']['Units'];

                        $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + 0.16);
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                        $FormattedPrice = substr_replace($FormattedPrice, '99', -2);
                        //added
                        $DetailPageURL = $response["Items"]["Item"]["DetailPageURL"];
                        $LargeImageURL = $response["Items"]["Item"]["LargeImage"]["URL"];
                        $EditorialReviewContent2 = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Content"];
                        $EditorialReviewContent2 = truncate($EditorialReviewContent2, 240);
                        //$TinyImage = $response["Items"]["Item"]["ThumbnailImage"]["URL"];                                          
                    }
                    $dummyImagy = 'http://via.placeholder.com/350x400';
                    ?>

                        <li>
                            <div>

                                <section class="image"> <a href="single.php?ID=<?php print $ASIN; ?>">              
                        <?php
                        if (!empty($MediumImageURL)) {
                            echo '<img class="cart_list_img" src="' . $MediumImageURL . '" alt="">';
                        } else {
                            echo '<img class="cart_list_img" src="' . $dummyImagy . '" alt="">';
                        }
                        ?>
                                    </a>
                                    <span>

                                        <form  class="form-item">		
                                                            <!-- <input name="price" type="hidden" value="<?php //echo round($ConvertedSellingCost, 2) ;?>">-->
                                            <input name="price" type="hidden" value="<?php echo $Amount; ?>">
                                            <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost,2); ?>">

                                            <input name="title" type="hidden" value="<?php print $Title; ?>">
                                            <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                                            <input name="product_code" type="hidden" value="<?php print $ASIN; ?>">
                                            <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL; ?>">  
                                            <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>
                                            <input name="product_code" type="hidden" value="<?php print $ASIN; ?>">  
                                            <input name="product_url" type="hidden" value="<?php print $DetailPageURL; ?>">   
                                            <!--new params-->
                                            
                                               <!--<input name="pdtCat" type="text" value="<?php //print $pdtCat; ?>">-->
                                             <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                             <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                              <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                                <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                              <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                                <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                                <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                            <!--end new params-->

<!--<button type="button" data-toggle="modal"  data-target="#qView" data-id="<?php print $MediumImageURL.'6!#@6'.$Amount.'6!#@6'.$ConvertedWeight.'6!#@6'.$ConvertedSellingCost .'6!#@6'.$ASIN.'6!#@6'.$Title .'6!#@6'.$DetailPageURL ?>" class="button btn_push small-btn yob-btn quickViewModal">Quick View</button> -->
<button type="button" data-toggle="modal"  data-target="#qView" data-id="<?php print $MediumImageURL.'6!#@6'.$Amount.'6!#@6'.$ConvertedWeight.'6!#@6'.$ConvertedSellingCost .'6!#@6'.$ASIN.'6!#@6'.$Title .'6!#@6'.$TotalCost.'6!#@6'.$ConvertedTotalCost.'6!#@6'.$ConvertedSellingCost.'6!#@6'.$ConvertedTotalCost_Usd.'6!#@6'.$profitKes.'6!#@6'.$profitUsd.'6!#@6'.$marginPercentage.'6!#@6'.$DetailPageURL ?>" class="button btn_push small-btn yob-btn quickViewModal">Quick View</button> 
                                            <button type="submit" class="button small-btn boy-btn" >Add to Cart</button>
                                            <p>
                    <?php print $EditorialReviewContent2; ?>
                                            </p>

                                            <!--
                                                                                                                                                         <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>
                                            
                                                <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL . '6!#@6' . round($ConvertedSellingCost, 2) . '6!#@6' . $ASIN . '6!#@6' . $Title . '6!#@6' . $DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->


                                        </form>
                                    </span>
                                </section>
                                <section class="name">
                                    <h3><a href="single.php?ID=<?php print $ASIN; ?>"><?php
                    if (!empty($Title)) {
                        echo truncate($Title, 40);
                    }
                    ?></a></h3>
                                </section>
                                <section class="price">
                                    <a href="single.php?ID=<?php print $ASIN; ?>"> <article>
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


                                        <input name="product_code22" type="hidden" value="<?php print $ASIN; ?>"> 
                                        <input name="add_to_wish" type="hidden" > 

                                        <button type="submit" class="wish_btn" name="test_wish" > <img src="images/icons/heart.png"/></button>
                                    </form>
                                    </p>
                                    <span class="clearfix"></span>
                                </section>
                            </div>
                        </li>


                <?php
                }
            }
        } else {
            print "<script language=\"javascript\"> 
var myurl='no-results.php?search=$Keywords'
window.location.assign(myurl)
</script>";
        }
        ?>

        </div> <!-- /.product-list -->




            <?php }
        ?>

    <?php
}
?>
</ul>

