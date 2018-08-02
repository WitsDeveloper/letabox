<?php
//require_once 'apiconn.php';
require_once 'partials/config.php';

$header = array(
    'page'=>'listing',
    'title'=>'Listing'
);
require_once 'partials/header.php';
//for univrsal search
if( !empty($search) && !empty($category) )
    
    {
?>

  <?php
  $response  = json_encode( $client->category($category)->search($search) );  
  $response = json_decode($response, true);
   if( $response["Items"]["Request"]["IsValid"] ) {
    
		$Keywords_uni = $response["Items"]["Request"]["ItemSearchRequest"]["Keywords"];
		$SearchIndex_uni = $response["Items"]["Request"]["ItemSearchRequest"]["SearchIndex"];
		$TotalResults_uni = $response["Items"]["TotalResults"];
		$TotalPages_uni = $response["Items"]["TotalPages"];
   }
    }     
  

?>
<section class="maincontent listing">

    <?php include_once 'partials/bar.inc.php'; ?>

    <?php
    $deals = array(
        array(
            'name'=>'iPhone X',
            'href'=>'',
            'image'=>'13.png',
            'from'=>'Amazon',
            'fromUrl'=>'amazon.com',
            'price'=>'169,999',
            'likes'=>'567'
        ),
        array(
            'name'=>'iPhone X',
            'href'=>'',
            'image'=>'13.png',
            'from'=>'Amazon',
            'fromUrl'=>'amazon.com',
            'price'=>'169,999',
            'likes'=>'567'
        ),
        array(
            'name'=>'iPhone X',
            'href'=>'',
            'image'=>'13.png',
            'from'=>'Amazon',
            'fromUrl'=>'amazon.com',
            'price'=>'169,999',
            'likes'=>'567'
        )
    );
    ?>
    

    <div class="list">
        
        <div class="container">
           

            <div class="list-title">
                <h2>Showing results for '<?php print $Keywords_uni; ?>'<span> <?php echo $TotalResults_uni;?> results</span></h2>
                <form action="" method="post">
                  <!--  <p>
                        <label for="category">Category</label>
                        
                <?php
           /*   $category="All";
                $sqlCatShow = "SELECT `CatName`,`CatValue` FROM `".DB_PREFIX."categories` WHERE `disabledFlag` = 0 AND `deletedFlag` = 0 ORDER BY `CatName` ASC";
				echo sqlOption($sqlCatShow,"category",$category,"All","","");*/
				?>
                
                    </p>-->
                    <p>
                        <label>Price in Ksh.</label>
                        <input type="text" name="lower" id="lower" placeholder="" value="100000">
                        <em>-</em>
                        <input type="text" name="higher" id="higher" placeholder="" value="150000">
                    </p>
                   <!-- <p>
                        <label>Condition</label>
                        <span>
                            <label for="new">New: <input type="checkbox" name="" id="new" checked></label>
                        </span>
                        <span>
                            <label for="refurbished">Certified Refurbished: <input type="checkbox" name="" id="refurbished" checked></label>
                        </span>
                        <span>
                            <label for="used">Used: <input type="checkbox" name="" id="used" checked></label>
                        </span>
                    </p>-->
                    <span class="clearfix"></span>
                </form>
            </div>

            <?php include_once 'partials/list.inc.php'; ?>

            <span class="clearfix"></span>

        </div>
    </div>

   <!-- <div class="loadmore">
        <a href="" class="button">Load More</a>
    </div>-->
   <!--<div class="related">
        <div class="container">
            <br>
        <ul>
            <li class="main">
                <div>
                    <h2>Today's Deals</h2>
                    <ul>
                    <?php foreach($deals as $deal): ?>
                        <li>
                            <div>
                                <section class="image">
                                    <img src="images/products/<?php echo $deal['image']; ?>" alt="">
                                    <span>
                                        <a href="#" class="button small-btn yob-btn quickViewModal">Quick View</a><br />
                                        <a href="" class="button small-btn boy-btn">Add to Cart</a>
                                    </span>
                                </section>
                                <section class="name">
                                    <h3><a href="single"><?php echo $deal['name']; ?></a></h3>
                                </section>
                                <section class="price">
                                    <article>
                                        <p>From <?php echo $deal['from']; ?></p>
                                        <h4><?php echo 'Ksh. '.$deal['price']; ?></h4>
                                    </article>
                                    <span class="clearfix"></span>
                                </section>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <span class="clearfix"></span>
                </div>
            </li><li class="main">
                <div>
                    <h2>People who bought this also bought</h2>
                    <ul>
                    <?php foreach($deals as $deal): ?>
                        <li>
                            <div>
                                <section class="image">
                                    <img src="images/products/<?php echo $deal['image']; ?>" alt="">
                                    <span>
                                        <a href="#" class="button small-btn yob-btn quickViewModal">Quick View</a><br />
                                        <a href="" class="button small-btn boy-btn">Add to Cart</a>
                                    </span>
                                </section>
                                <section class="name">
                                    <h3><a href="single"><?php echo $deal['name']; ?></a></h3>
                                </section>
                                <section class="price">
                                    <article>
                                        <p>From <?php echo $deal['from']; ?></p>
                                        <h4><?php echo 'Ksh. '.$deal['price']; ?></h4>
                                    </article>
                                    <span class="clearfix"></span>
                                </section>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                    <span class="clearfix"></span>
                </div>
            </li>
        </ul>
        <span class="clearfix"></span>
        </div>
    </div>-->
       <?php if(isset($_SESSION['user_id'])){?>
    <div class="related">
        <div class="container">
            <br>  <br>
        <ul>
            <li class="main2">
                <div>
                    <h2>My Search History</h2>
                    <br>
                    <ul>
                        <?php
                        if(isset($_SESSION['user_id'])){
       $project_desc1 = $mysqli->query("SELECT * from lbs_history WHERE lbs_bill_shipping_id=".$_SESSION['user_id']." LIMIT 15")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);              
      while($obj_ona1= $project_desc1->fetch_object()){
      print '<li>'.$obj_ona1->lbs_history_term.' searched on '.date("jS F, Y", strtotime("$obj_ona1->lbs_history_date")).'</li>';
                        }
                        }else{
                       print '<li>Login to see your search history</li>';        
                        }
                        
                        ?>
                    </ul>
                    <span class="clearfix"></span>
                </div>
            </li>
        </ul>
        <span class="clearfix"></span>
        </div>
    </div>
   
       <?php } ?>
    


</section>
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
    