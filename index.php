<?php
require_once 'apiconn.php';
require_once 'partials/config.php';
$header = array(
    'page'=>'home',
    'title'=>''
);
require_once 'partials/header.php';
?>
<section  class="maincontent listing hide_desk">
   

    <?php include_once 'partials/bar.inc.php'; ?>
    
    </section>
<section class="landing">
 <div class="container">

        <img src="images/logo-mid.png" alt="LetaBox">  <!-- 
        <h2 class="home_intro">Search global e-commerce stores, add to cart and ship to Kenya</h2>    
        <form  method="get" action="listing.php">
        
          <?php
                //$sqlCatShow = "SELECT `CatName`,`CatValue` FROM `".DB_PREFIX."categories` WHERE `disabledFlag` = 0 AND `deletedFlag` = 0 ORDER BY `CatName` ASC";
				//echo sqlOption($sqlCatShow,"category",$category,"Select","","");
				?>
         <input id="search" type="search" name="search" placeholder="Search global ecommerce sites here..." value="<?php echo $search; ?>">
    
            <input id="btnSubmit" type="submit" class="hide_mob" value="Search">
				<button id="btnSubmit" class="hide_desk" type="submit"><i class="fas fa-search "></i></button>
        </form>-->
    

    </div>
     <div class="container">
         <div class="search_bar">
              <form  method="get" action="listing.php">
	
    		<span class=" nav-facade-active" id="nav-search-in" style="width: auto;">
              <span data-value="search-alias=aps" id="nav-search-in-content" style="width: 60px; overflow: visible;">
                Category
              </span>
                    <span class="nav-down-arrow nav-sprite"></span>
           
              <select title="Search in" class="searchSelect" id="searchDropdownBox" name="category"  style="top: 0px;">
                  
				 <option value="Select" selected="selected">All</option>
                                     <?php
              $project_desc1 = $mysqli->query("SELECT * from lbs_categories ORDER BY CatName ASC")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
   
while($obj_ona1= $project_desc1->fetch_object())
     {
   
$CatID=$obj_ona1->CatID;
$CatName=$obj_ona1->CatName;
$CatValue=$obj_ona1->CatValue;


              ?>
     <option value="<?php print $CatName;?>" title="<?php print $CatValue;?>"><?php print $CatValue;?></option>                              
     <?php } ?>
			  </select>
           
            </span>
            <div class="nav-searchfield-outer nav-sprite">
                <input type="search" autocomplete="off" name="search"  class="landing2"value="<?php echo @$search; ?>" title="Search For" id="twotabsearchtextbox" style="padding-right: 1px;">
            </div>
            <div class="nav-submit-button">
             <!-- <input type="submit" title="Go" class="nav-submit-input" value="Search">-->
                	<button id="btnSubmit" class="" type="submit"><i class="fas fa-search "></i></button>
            </div>
              </form>
</div>
     </div>
</section>
<?php require_once 'partials/footer.php'; ?>
<?php
//Close connection
db_close($conn);
ob_flush(); 
?>