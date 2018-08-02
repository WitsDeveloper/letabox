

<form  class="form-item">		
                                                            <!-- <input name="price" type="hidden" value="<?php //echo round($ConvertedSellingCost, 2) ;?>">-->
                                            <input name="price" type="hidden" value="<?php echo $CostUSD; ?>">
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
                                            <button type="submit" class="button small-btn boy-btn mob_add_cart" >Add to Cart</button>
                                            <p>
                    <?php print $EditorialReviewContent2; ?>
                                            </p>

                                            <!--
                                                                                                                                                         <a href="single.php?ID=<?php print $ASIN; ?>" class="button small-btn yob-btn quickViewModal">Quick View</a>
                                            
                                                <!-- <button type="button" class="button small-btn yob-btn quickViewModal" data-id="<?php print $MediumImageURL . '6!#@6' . round($ConvertedSellingCost, 2) . '6!#@6' . $ASIN . '6!#@6' . $Title . '6!#@6' . $DetailPageURL ?>" data-toggle="modal" data-target="#qView">quick view</button>-->


                                        </form>
