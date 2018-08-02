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
                
                
            $Item = $response["Items"]["Item"];
            if (is_array($Item)) {
                $count = 1;

               
                  // print  $TotalPages_uni;
                    ?>


  <?php 
   

?>
<section  class="maincontent listing">
   

    <?php include_once 'partials/bar.inc.php'; ?>

   
   <div class="row">
    
       <div class="container">  <div class="bxslider" style="display: none;">
 <?php   
 foreach (array_slice($Item, 0, 4) as $key => $value) {

                    if (is_array($value)) {
                        $ASIN = $response["Items"]["Item"][$key]["ASIN"];
                        $MediumImageURL = $response["Items"]["Item"][$key]["MediumImage"]["URL"];
                        $LargeImageURL = $response["Items"]["Item"][$key]["LargeImage"]["URL"];
                        $Title = $response["Items"]["Item"][$key]["ItemAttributes"]["Title"];
                        
                    } 
 ?>
  
  <div><img src="<?php print $LargeImageURL;?>" title="<?php print $Title;?>"></div>


   
   <?php 
    
   //print $ASIN;
                       }?>
                     </div>
</div>
     
</div>  
      
    
    
      <?php                 }     
  

    
   ?>

    <div class="list">
        
        <div class="container">
          
           

            <div class="list-title">
              <!--  Pay with lipa Na Mpesa online -->
                <h2>Showing results for '<?php print $Keywords_uni; ?>'<span> <?php echo $TotalResults_uni;?> results</span></h2>
             
            </div>
            
    <?php }   }  ?>

            <?php include_once 'partials/list.inc.php'; ?>

            <span class="clearfix"></span>

        </div>
    </div>

   
       <?php if(isset($_SESSION['user_id'])){?>
    <div class="related">
        <div class="container">
            <br>  <br>
        <ul>
            <li class="main2">
                <div>
                    <h2>My Search History </h2>
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
             $(".loading").show(); 
               $(".modal-dialog").hide(); 
     $.ajax({
            type : 'post',
            url : 'cart_process.php', 
            data :  'rowid='+ rowid, 
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
                 $(".loading").hide(); 
                    $(".modal-dialog").show(); 
            }
        });
     });});
     </script>
    