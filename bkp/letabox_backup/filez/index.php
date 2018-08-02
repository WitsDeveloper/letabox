<?php
require_once 'apiconn.php';
require_once 'partials/config.php';
$header = array(
    'page'=>'home',
    'title'=>''
);
require_once 'partials/header.php';
?>
<section class="landing">
    <div class="container">

        <img src="images/logo-mid.png" alt="LetaBox">
        <h2>Search global e-commerce stores, add to cart and ship to Kenya</h2>    
        <form  method="get" action="listing.php">
         <input type="hidden" name="category" id="category" class="form-control input-lg" value="All" >
            <!--<input type="search" name="s" id="s" placeholder="Search global ecommerce sites here...">-->
         <input id="search" type="search" name="search" placeholder="Search global ecommerce sites here..." value="<?php echo $search; ?>">
            <input type="submit" value="Search" id="btnSubmit">
        </form>
    

    </div>
</section>
<?php require_once 'partials/footer.php'; ?>
<?php
//Close connection
db_close($conn);
ob_flush(); 
?>