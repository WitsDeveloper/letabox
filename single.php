<?php
require_once 'partials/config.php';

$header = array(
    'page' => 'single',
    'title' => 'Product details'
);
require_once 'partials/header.php';
?>
<?php
//$source = isset( $_GET['source'] )?$_GET['source']:"";
$productID = isset($_GET['ID']) ? $_GET['ID'] : 0;
if (!empty($productID)) {
    ?>
    <section class="maincontent listing">

        <?php include_once 'partials/bar.inc.php'; ?>

        <div class="singlelist">

            <div class="item">
                <?php
                //Variables
                $ItemAttributes = array();

                $response = $client->lookup($productID);

                $response = json_encode($client->lookup($productID));

                $response = json_decode($response, true);
                //echo $response->Items->Request->IsValid;
                if ($response["Items"]["Request"]["IsValid"]) {

                    if (is_array($response["Items"]["Item"])) {

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
                        $ListPrice = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"] : "";
                        $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        /*  $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                          $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                          $ConvertedWeight = !empty($Weight)?$Weight/100:0; */
                        //additional
                        $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                        #new
                        $LowestUsedPrice = isset($response["Items"]["Item"]["OfferSummary"]["LowestUsedPrice"]["Amount"]) ? $response["Items"]["Item"]["OfferSummary"]["LowestUsedPrice"]["Amount"] : 0;

                        if ($ListPrice > 0) {
                            $Amount = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                        } elseif ($LowestUsedPrice != 0) {
                            $Amount = $LowestUsedPrice;
                        } else {
                            $Amount = isset($response["Items"]["Item"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"]) ? $response["Items"]["Item"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"] : 0;
                        }
                        #count the units

                        $TotalNew = isset($response["Items"]["Item"]["OfferSummary"]["TotalNew"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalNew"] : 0;
                        $TotalUsed = isset($response["Items"]["Item"]["OfferSummary"]["TotalUsed"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalUsed"] : 0;
                        $TotalRefurbished = isset($response["Items"]["Item"]["OfferSummary"]["TotalRefurbished"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalRefurbished"] : 0;
                        #end new
                        //determine weight
                        //determine weight
                        $CatWeight = DEFAULT_WEIGHT;

                        if ($response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]) {
                            $Weight = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                            $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                            $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                        } else {

                            $Weight = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                            $WeightUnits = $response["Items"]["Item"]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                            $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight / 100;
                        }

                        //newest
                        $Amount = $Amount / 100;
                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + MARGIN);
                        //new
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/USDKES_RATE;
                        $ConvertedTotalCost_Usd = $ConvertedSellingCost / USDKES_RATE;
                        //end new
                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                        #$FormattedPrice = substr_replace($FormattedPrice, '99', -2);
                        //new params
                        $profitKes = $ConvertedSellingCost - $ConvertedTotalCost;
                        $profitUsd = $profitKes / USDKES_RATE;
                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                        $marginPercentage = ($profitKes / $ConvertedTotalCost) * 100;

                        //newest
                        $Iframe = $response["Items"]["Item"]["[ItemLinks]"]["ItemLink"]["1"]["URL"];
                        ?>
                        <div class="container"><br><br>

                            <h2 id="orig_tit"><?php print $Title; ?></h2>
                            <p class="subtitle">From Amazon</p>
                            <div class="row">
                            <div id="single_gal" class="gallery itemGall hide_mob">
                         
                                
                                <ul>

                        <?php
                        foreach (array_slice($response["Items"]["Item"]["ImageSets"]["ImageSet"], 0, 4) as $value) {
                            //$visa=$value["MediumImage"]["URL"];
                            $visa = $value["LargeImage"]["URL"];
                            if (!empty($value)) {
                                ?>
                                            <li>
                                                <a href="<?php print $visa; ?>">
                                                    <img src="<?php print $visa; ?>" alt="">
                                                </a>
                                            </li>
                                        <?php }
                                    }
                                    ?>

                                </ul>
                                <img src="<?php echo $LargeImageURL; ?>" alt="" id="mainGall">
                                <span class="clearfix"></span>
                            </div>
                                <!-- for inserting  dom on fly-->
                                <div id="single_gal2" class="gallery itemGall hide_mob">
                                    
                         
                                 </div>
                            <div class="specs">

                                <div class="mob_share_fon">
                                    <div id="share-buttons" class="leta_share_btns">    


                                        <!-- Facebook -->
                                        <a href="http://www.facebook.com/sharer.php?u=http://dev.letabox.co.ke/single.php?ID=<?php print $ASIN; ?>" target="_blank">
                                            <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
                                        </a>

                                        <!-- Google+ -->
                                        <a href="https://plus.google.com/share?url=http://dev.letabox.co.ke/single.php?ID=<?php print $ASIN; ?>" target="_blank">
                                            <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
                                        </a>



                                        <!-- Print -->
                                        <a href="javascript:;" onclick="window.print()">
                                            <img src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print" />
                                        </a>






                                    </div>

                                    <div class="social_share">
                                        <a href="#" class="social_before" onclick="return false;"><img src="images/share.png"/></a>
                                      <!--   <a href="#" class="social_after" onclick="return false;"><img src="images/cross-circular-button-outline.png"/></a>-->

                                    </div>
                                </div>
                                <h3 id="origi_price"><?php echo wits_money($ConvertedSellingCost); ?>/=</h3>
                                 <h3 id="newVar_price"></h3>

                                <p class="stock">
                                    <b>Stock</b><br>
                                    New: <span id="stoNew"><?php print $TotalNew; ?></span><br>
                                    Refurbished: <span id="stoRef"><?php print $TotalRefurbished; ?></span><br>
                                    Used: <span id="stoUsed"><?php print $TotalUsed; ?></span>

                                </p>
                                <form  class="form-item">
                                    <!--new params-->
                                    <div id="form-item_cart">
                                    <input name="totalCost_Usd" type="hidden" value="<?php print $TotalCost; ?>">
                                    <input name="totalCost_Ksh" type="hidden" value="<?php print $ConvertedTotalCost; ?>">
                                    <input name="convertedSellingcost_Ksh" type="hidden" value="<?php print $ConvertedSellingCost; ?>">
                                    <input name="convertedSellingcost_Usd" type="hidden" value="<?php print $ConvertedTotalCost_Usd; ?>">
                                    <input name="profitKes" type="hidden" value="<?php print $profitKes; ?>">
                                    <input name="profitUsd" type="hidden" value="<?php print $profitUsd; ?>">
                                    <input name="margin" type="hidden" value="<?php print $marginPercentage; ?>">
                                    <!--end new params-->
                                    <input name="price" type="hidden" value="<?php print $Amount; ?>">
                                    <input name="title" type="hidden" value="<?php print $Title; ?>">
                                    <div class="nav_cart_qty">
                                        <div class="input-group">    
                                            <input type="text" data-code="<?php print $product_code; ?>" name="quantity" class="form-control input-number text-center quantity" value="1"/>
                                            <button type="button" id="add" data-code="<?php print 'nullz'; ?>" class="add btn cart_btn"><img src="images/icons/plus.png"></button>
                                            <button type="button" id="sub2" value='-' field="quantity" data-code="<?php print 'nullz'; ?>" class="sub2 btn cart_btn"><img src="images/icons/minus.png"></button> 
                                            <input name="product_code" type="hidden" value="<?php print $ASIN; ?>"> 
                                            <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL; ?>">   
                                             <!-- <input name="product_link" type="hidden" value=""> --> 



                                        </div></div>


                                    <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost, 2); ?>">            

                                    <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>                                        
                                    <input name="product_url" type="hidden" value="<?php print $DetailPageURL; ?>"> 
                                    </div>
                                    <div class="variations">
                                  
                                        <?php
$project_desc1 = $mysqli->query("SELECT * from lbs_temp_history WHERE lbs_temp_ASIN='$ASIN'")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
   
$data=$obj_ona1->lbs_temp_string;


/*foreach ($Itemx as  $key=>$value)  {
    $VariationAttributes = $value['VariationAttributes']['VariationAttribute'];

    $size = $VariationAttributes[0]["Value"];
    $color = $VariationAttributes[1]["Value"];
     $varName = $VariationAttributes["Name"];
    if(!in_array($color, $colorArray)){
        $colorArray[]=$color;
    }
    if(!in_array($size, $sizeArray)){
        $sizeArray[]=$size;
    }
}   */ }
//print 'test json<br><hr>'.$data = json_decode($data, true);
$data = json_decode($data, true);
$total_items = count($data['TotalVariations']);
$variation_width = count($data['VariationDimensions']['VariationDimension']);

$CURRENT_VARIATIONS= $data['VariationDimensions']['VariationDimension'];
$loop = 0;
$var_id=1;

while($loop < $variation_width){  
	echo $data['VariationDimensions']['VariationDimension'][$loop];
    
	echo '<select id="var_'.$var_id.'" class="variationzz" name="'.$data['VariationDimensions']['VariationDimension'][$loop].'">';
       
		foreach($data['Item'] as $i ):
			
$option_value = $i['VariationAttributes']['VariationAttribute'][$loop]['Value'];
//echo '<option class="var_'.$i['ASIN'].'" value="'.$i['ASIN'].','.$option_value.'">'.$option_value.'</option>';               
echo '<option class="var_'.$i['ASIN'].'" value="'.$option_value.'">'.$option_value.'</option>'; 	
        endforeach;
	echo '</select>';
	$loop++;
        $var_id++;
}

echo '<input type="hidden" value="'.implode(",",$CURRENT_VARIATIONS).'" name="variations"/><br>';
?>


     </div>
                                    <div class="float_cart_actions">                                       
                                        <button type="submit" class="button small-btn boy-btn btn_addcart_abs" >Add to Cart</button>
                                        <br><br>
                                    </div>
                                </form>
                             
                                <article>
                                    <h4>Brief description</h4>
                                    <p id="briefDes" class="brief">
            <?php
            if (!empty($response["Items"]["Item"]["EditorialReviews"])) {
                $EditorialReviewSource = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Source"];
                $EditorialReviewContent2 = $response["Items"]["Item"]["EditorialReviews"]["EditorialReview"]["Content"];
                echo truncate($EditorialReviewContent2, 240);
            }
            ?>
                                    </p>
                                </article>
                                <p class="readmore">
                                    <a href="#" id="toshop"  class="button yob-btn">Back to shop</a>
                                    <a data-toggle="modal" href="#cH" class="button yob-btn">1 Click Checkout</a>
                                    <!--<button type="submit" class="button small-btn boy-btn btn_addcart_abs" >Add to Cart</button>-->
                                    <!--  <a href="cart" class="button boy-btn">Add to Cart</a>-->
                                </p>
                            </div>
                        </div>

                            <div class="bxslider hide_desk" style="display: none;">
            <?php
            foreach (array_slice($response["Items"]["Item"]["ImageSets"]["ImageSet"], 0, 4) as $value) {
                $visa = $value["LargeImage"]["URL"];
                ?>

                                    <div><img src="<?php print $visa; ?>" title="<?php print $Title; ?>"></div>



                                    <?php
                                    //print $ASIN;
                                }
                                ?>
                            </div>

                            
                            <span class="clearfix"></span>

                        </div>

                    </div>
                    <div class="container">

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
            /* echo '<ul class="features-list">';
              foreach( $response["Items"]["Item"]["ItemLinks"]["ItemLink"] as $value ){
              echo '<li>'. $value["Description"]["URL"] .'</li>';
              }
              echo '</ul>' */
            ?>

                                    <iframe src="<?php print $response["Items"]["Item"]["CustomerReviews"]["IFrameURL"]; ?>"  width="100%" height="500" frameborder="0"
                                            allowfullscreen sandbox>
                                        <p> <a href="<?php print $response["Items"]["Item"]["CustomerReviews"]["IFrameURL"]; ?>">

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
                        <div class="mob_flex mob_flex_single"><ul class="slide quick_ul">

            <?php
            if (!empty($response["Items"]["Item"]["SimilarProducts"]["SimilarProduct"])) {
                foreach (array_slice($response["Items"]["Item"]["SimilarProducts"]["SimilarProduct"], 0, 5) as $value) {
                    ?>
                                        <li class="quick_list"><div class="new_divx">
                                <?php
                                $id = $value["ASIN"];
                                $ItemAttributes = array();
                                $response = $client->lookup($id);
                                $response = json_encode($client->lookup($id));
                                $response = json_decode($response, true);
                                ?>
                                                <div>
                                                <?php
                                                if ($response["Items"]["Request"]["IsValid"]) {
                                                    if (is_array($response["Items"]["Item"])) {

                                                        $ASIN = $response["Items"]["Item"]["ASIN"];
                                                        $MediumImageURL2 = $response["Items"]["Item"]["MediumImage"]["URL"];
                                                        $Title2 = $response["Items"]["Item"]["ItemAttributes"]["Title"];
                                                        $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;

                                                        //additional
                                                        $Amount = !empty($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                                                        $CurrencyCode = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["CurrencyCode"] : "";
                                                        #new
                                                        $LowestUsedPrice = isset($response["Items"]["Item"]["OfferSummary"]["LowestUsedPrice"]["Amount"]) ? $response["Items"]["Item"]["OfferSummary"]["LowestUsedPrice"]["Amount"] : 0;

                                                        if ($ListPrice > 0) {
                                                            $Amount = isset($response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"]) ? $response["Items"]["Item"]["ItemAttributes"]["ListPrice"]["Amount"] : 0;
                                                        } elseif ($LowestUsedPrice != 0) {
                                                            $Amount = $LowestUsedPrice;
                                                        } else {
                                                            $Amount = isset($response["Items"]["Item"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"]) ? $response["Items"]["Item"]["OfferSummary"]["LowestRefurbishedPrice"]["Amount"] : 0;
                                                        }
                                                        #count the units

                                                        $TotalNew = isset($response["Items"]["Item"]["OfferSummary"]["TotalNew"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalNew"] : 0;
                                                        $TotalUsed = isset($response["Items"]["Item"]["OfferSummary"]["TotalUsed"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalUsed"] : 0;
                                                        $TotalRefurbished = isset($response["Items"]["Item"]["OfferSummary"]["TotalRefurbished"]) ? $response["Items"]["Item"]["OfferSummary"]["TotalRefurbished"] : 0;
                                                        #end new
                                                        //determine weight
                                                        //determine weight
                                                        $CatWeight = DEFAULT_WEIGHT;

                                                        if ($response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"]) {
                                                            $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["_"];
                                                            $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["PackageDimensions"]["Weight"]["Units"];
                                                            $ConvertedWeight = !empty($Weight) ? $Weight / 100 : 0;
                                                        } else {

                                                            $Weight = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["_"];
                                                            $WeightUnits = $response["Items"]["Item"][$key]["ItemAttributes"]["ItemDimensions"]["Weight"]["Units"];
                                                            $ConvertedWeight = !empty($Weight) ? $Weight / 100 : $CatWeight / 100;
                                                        }

                                                        //newest
                                                        $Amount = $Amount / 100;
                                                        $BuyingCost = ($Amount + SHIPPING_RATE) * (1 + TAX_RATE);
                                                        $ConvertedBuyingCost = currencyConverter($BuyingCost, REALISTIC_EXCHANGE_RATE);
                                                        $TotalCost = $BuyingCost + ($ConvertedWeight / 2.2 * 10);
                                                        $ConvertedTotalCost = currencyConverter($TotalCost, REALISTIC_EXCHANGE_RATE);
                                                        $ConvertedSellingCost = $ConvertedTotalCost * (1 + MARGIN);
                                                        //new
                                                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/USDKES_RATE;
                                                        $ConvertedTotalCost_Usd = $ConvertedSellingCost / USDKES_RATE;
                                                        //end new
                                                        $FormattedPrice = formattedPrice($ConvertedSellingCost, $SwitchCurrencyCode);
                                                        #$FormattedPrice = substr_replace($FormattedPrice, '99', -2);
                                                        //new params
                                                        $profitKes = $ConvertedSellingCost - $ConvertedTotalCost;
                                                        $profitUsd = $profitKes / USDKES_RATE;
                                                        //$ConvertedTotalCost_Usd = $ConvertedSellingCost/REALISTIC_EXCHANGE_RATE;
                                                        $marginPercentage = ($profitKes / $ConvertedTotalCost) * 100;

                                                        //newest
                                                        ?>
                                                            <section class="image xx">
                                                                <img src="<?php echo $MediumImageURL2; ?>" alt="">
                                                           
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
                                                                        <input name="price" type="hidden" value="<?php echo $Amount; ?>">
                                                                        <input name="sellCost" type="hidden" value="<?php echo round($ConvertedSellingCost, 2); ?>">    
                                                                        <input name="title" type="hidden" value="<?php print $Title2; ?>">
                                                                        <input name="quantity" type="hidden" value="<?php print 1; ?>" placeholder="Quantity">
                                                                        <input name="product_code" type="hidden" value="<?php print $ASIN; ?>">
                                                                        <input name="thumbnail" type="hidden" value="<?php print $MediumImageURL2; ?>">                 
                                                                        <input name="product_code" type="hidden" value="<?php print $ASIN; ?>">  
                                                                        <input name="product_url" type="hidden" value="<?php print $DetailPageURL; ?>">  



                                                                        <input type="hidden" name="weight" value="<?php print $ConvertedWeight; ?>"/>   



                                                                        <button type="button" data-toggle="modal"  data-target="#qView" data-id="<?php print $MediumImageURL . '6!#@6' . $Amount . '6!#@6' . $ConvertedWeight . '6!#@6' . $ConvertedSellingCost . '6!#@6' . $ASIN . '6!#@6' . $Title . '6!#@6' . $DetailPageURL ?>" class="button btn_push small-btn yob-btn quickViewModal">Quick View</button> 
                                                                        <button type="submit" class="button small-btn boy-btn" >Add to Cart</button>
                                                                        <p>
                            <?php //print $EditorialReviewContent2;  ?>
                                                                        </p>

                                                                        <!--
                                                                                                                                                                                     <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>
                                                                        
                                                                            <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL . '!#@' . round($ConvertedSellingCost, 2) . '!#@' . $ASIN . '!#@' . $Title . '!#@' . $DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->


                                                                    </form>
                                                                </span>
                                                            </section>
                                                            <section class="name">
                                                                <h3><a href="single.php?ID=<?php print $ASIN; ?>"><?php
                                                                            if (!empty($Title2)) {
                                                                                echo truncate($Title2, 40);
                                                                            }
                                                                            ?></a></h3>
                                                            </section>
                                                            <section class="price">
                                                                <article>
                                                                    <p>From <?php echo 'Amazon'; ?></p>
                                                                    <h4><?php echo wits_money($ConvertedSellingCost); ?></h4>
                                                                </article>
                                                                <p class="right">
                                                                    <span><?php echo $product['likes']; ?></span>
                                                                   <!-- <a href="#" class="wishlist outline"><?php //echo file_get_contents('images/icons/heart.svg');  ?></a>--0-->
                                                                <form class="wish-form">

                                                                    <input class="user_id_wish" name="user_id_wish" type="hidden" value="<?php if (isset($_SESSION['user_id'])) {
                                                                                print $_SESSION['user_id'];
                                                                            } else {
                                                                                print '';
                                                                            } ?>"> 
                                                                    <input name="product_code22" type="hidden" value="<?php print $ASIN; ?>"> 
                                                                    <input name="add_to_wish" type="hidden" > 

                                                                    <button type="submit" class="wish_btn" name="test_wish"  > <img src="images/icons/heart.png" class="hide_mob"/>
                                                                        <img src="images/icons/heart2.png" class="hide_desk wish_list_heart"/></button>
                                                                </form>
                                                                </p>
                                                                <span class="clearfix"></span>
                                                            </section>

                            <?php
                        }
                        ?>
                                                    </div>  
                                                </div>
                                            </li>
                    <?php
                    }
                }
            } else {
                print 'NO RELATED PRODUCTS!!';
            }
            ?>
                            </ul>
                        </div>


                        <span class="clearfix"></span>

                    </div>
                </div>
        <div class="container">
            <div class="pdt_not_found">
            Did you find what you were looking for?
            If not, click <a href="no-results.php" style="color:red">here</a> to place a custom quote.
        </div>   </div>


            </section>
        <?php }
    }
} ?>
<?php require_once 'partials/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#qView').on('show.bs.modal', function (e) {
            $(".loading").show();
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: 'cart_process.php',
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched-data').html(data);//Show fetched data from database
                    $(".loading").hide();
                }
            });
        });
        //for variations 1.size
        $(".variationzzc").change(function () {
    var link_name = $(this).attr('name'); 
    var optionz = $(this).parent().parent().parent().find('select[name='+link_name+']').val();   
   
  var splits = optionz.split(",");
var asin=splits[0];

var url = window.location.toString();
var oldUrl = url.substring(url.lastIndexOf('=') + 1);
var value=window.location = url.replace(/ID=oldUrl/, 'ID=url');
var oyu = url.replace(oldUrl, asin);
window.location.href = oyu;
    
      // alert(oyu);
      $.ajax({
				url: "cart_process.php",
				type: "POST",
				dataType:"json", 				
                                data :  "optionz="+optionz,
			}).done(function(data){ 
                              console.log(data);  			    
                      //var asin = data.asin;
                       // var valuez = data.valuez;
                        // var var_name = data.var_name;
                        //alert(valuez+" +"+var_name+"+ "+asin);
   
                     
			})
                        .fail(function(data) {
		
				console.log(data);
			
});
    });
    

   
});
       
        
    
    
    $(document).ready(function () {  
        
        
    var allOptions = $('#var_2 option');    
    //$('single_gal2').hide()
    $('#var_1').change(function () {
     //$(".loading").show();
    var link_name = $(this).attr('name'); 
    var optionz = $(this).parent().parent().parent().find('select[name='+link_name+']').val();     
    var asin=$('select[name='+link_name+'] :selected').attr('class');
    var asin = asin.substring(4);
     //alert(asin);
    
    
    //get pdt asin
//var splits = optionz.split(",");
//var asin=splits[0];
//var asin=optionz;
       $('#var_2 option').remove()
        var classN = $('#var_1 option:selected').prop('class');                 
        var opts = allOptions.filter('.' + classN);
        $.each(opts, function (i, j) {
            $(j).appendTo('#var_2');
        });
        
    
     $.ajax({
				url: "cart_process.php",
				type: "POST",				 				
                                data :  "optionz="+asin,
                                dataType:"json",
			}).done(function(data){ 
                              console.log(data); 
                              
                  var carousl = data.carousl;
                  var price_dom = data.price;
                   var stoNew = data.stoNew;
                  var stoRef = data.stoRef;
                   var stoUsed = data.stoUsed;
                   var orig_tit = data.orig_tit;
                   var Des = data.Des;
                   var briefDes = data.briefDes;
                   var formItem = data.formItem;
              
                   
                    //$("#single_gal").replaceWith(carousl);
                    $('#single_gal').html(carousl);
                    $("#origi_price").html(price_dom);
                    $("#stoNew").html(stoNew);
                    $("#stoRef").html(stoRef);
                    $("#stoUsed").html(stoUsed);
                    $("#orig_tit").html(orig_tit);
                    $("#desc").html(Des);
                    $("#briefDes").html(briefDes);
                    $("#form-item_cart").html(formItem);
                   
                    
                  $(".loading").hide();   
   
                     
			})
                        .fail(function(data) {
		
				console.log(data);
			
});
        
    
        
        

        
    });
    
    //var_2 click
     
    

    
    
    
});
</script>

