<?php

require_once 'partials/config.php';

$header = array(
    'page'=>'account',
    'title'=>'Profile'
);
require_once 'partials/header.php';
?>
<section class="maincontent">

    <div class="profile">
        <div class="container">

            <?php
                $controls = '<span>';
                $controls .= '<a href="">'.file_get_contents('images/icons/plus.svg').'</a>';
                $controls .= '<a href="">'.file_get_contents('images/icons/minus.svg').'</a>';
                $controls .= '</span>';
            ?>

            <h2>My Account</h2>

            <div class="details">
                <img src="images/profile/1.jpg" alt="">
                <article>
                    <h3>Brian Wamiori</h3>
                    <p><a href="">brian@letabox.com</a> <span>&bull;</span> 0712 345678</p>
                    <p><a href="profile/edit">edit profile</a></p>
                </article>
                <span class="clearfix"></span>
            </div>

            <div class="tabs">
                <ul class="horizontal tablinks">
                    <li><a href="#orders">My Orders</a></li>
                    <li><a href="#wishlist">My Wishlist</a></li>
                </ul>

                <div id="orders" class="tab cart">
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Units</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                        <tr>
                            <td><a href=""><img src="images/products/13.png" alt=""></a></td>
                            <td><a href="">Apple iPhone X, Fully Unlocked 5.8", 64GB - Silver</a></td>
                            <td>1 <span><?php echo $controls; ?></span></td>
                            <td>Ksh 169,999/=</td>
                            <td><a href="">remove</a></td>
                        </tr>
                        <tr>
                            <td><a href=""><img src="images/products/13.png" alt=""></a></td>
                            <td><a href="">Apple iPhone X, Fully Unlocked 5.8", 64GB - Silver</a></td>
                            <td>1 <span><?php echo $controls; ?></span></td>
                            <td>Ksh 169,999/=</td>
                            <td><a href="">remove</a></td>
                        </tr>
                        <tr>
                            <td colspan="2">Price is inclusive of taxes, shipping &amp; handling</td>
                            <td>Subtotal</td>
                            <td colspan="2">Ksh. 339,999/=</td>
                        </tr>
                    </table>
                </div>

                <div id="wishlist" class="tab listing">
                    <?php include_once 'partials/list.inc.php'; ?>
                    <span class="clearfix"></span>
                </div>
            </div>

        </div>
    </div>

</section>
<?php require_once 'partials/footer.php'; ?>