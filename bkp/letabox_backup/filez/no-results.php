<?php
$s= isset($_GET['search']) ? $_GET['search'] : 'empty';
require_once 'partials/config.php';

$header = array(
    'page'=>'single',
    'title'=>'Get a custom quote for '.$s
);
require_once 'partials/header.php';

?>
<section class="maincontent">

    <div class="noresults">
        <div class="container">
             <article>
                
                 <p id="custom_order_response"></p>
            </article>

            <article>
                <h3>Sorry. Your search result for "<?php print $s;?>" did not yield any results.</h3>
                <p>Don't give up yet. Fill in the form below and we shall send you a custom quote for your product</p>
            </article>
            <form class="custom_quote" >
                 <p>
                    <label for="name">Product full Name: <small>Product full name</small></label>
                    <input type="text" name="yname" id="yname" placeholder="Enter product name..." required>
                </p>
                <p>
                    <label for="url">Product URL: <small>Type in the URL where we can find the product.</small></label>
                    <input type="text" name="url" id="url" placeholder="www.website.com" required>
                </p>
                <p>
                    <label for="features">Product Features: <small>Enter any specifications about your product. e.g. Model, Size, Color</small></label>
                    <textarea name="features" id="features" placeholder="Enter product features..."></textarea>
                </p>
                   <p>
                    <label for="name">Email <small>Your Email address</small></label>
                    <input type="text" name="Email" id="Email" placeholder="Enter Email..." required>
                </p>
                   <p>
                    <label for="name">Phone<small>Mobile Number</small></label>
                    <input type="text" name="Phone" id="Phone" placeholder="Enter phone number..." required>
                </p>
               
                <input type="hidden" name="customer_quote_id"/>
                <br>  <br>
                <p>
                    <input type="submit" name="custom_quote" id="custom_quote" value="Send me a Custom Quote">
                </p>
            </form>

        </div>
    </div>
    

</section>
<?php require_once 'partials/footer.php'; ?>