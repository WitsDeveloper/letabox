<?php

require_once 'partials/config.php';

$header = array(
    'page'=>'404',
    'title'=>'404 Error'
);
require_once 'partials/header.php';
?>
<section class="maincontent">

    <div class="error">
        <div class="container">

            <img src="images/404.png" alt="">
            <article>
            <h2>404 Error</h2>
            <p>The page you are looking for cannot be found. Kindly <a href="">Go back home</a> or use the search bar above to search for a product.</p>
            </article>

        </div>
    </div>

</section>
<?php require_once 'partials/footer.php'; ?>
