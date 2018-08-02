<?php

require_once 'partials/config.php';

$header = array(
    'page'=>'contact',
    'title'=>'Contact us'
);
require_once 'partials/header.php';
?>
<section class="maincontent contact">

    <div class="contactus">
        <div class="container">

            <h2>Contact us</h2>
            <p class="subtitle">Get in touch with us via the details below or send us a message using the form. We will get back to you - we promise.</p>

            <ul>
                <li class="contactdetails">
                    <div>
                        <h3>Contact Details</h3>
                        <p>Letabox,</p>
                        <p>4th floor, The citadel, Westlands</p>
                        <p>Nairobi, Kenya.</p>
                        <p class="sep"></p>
                        <p>+254 723 890890</p>
                        <p><a href="mailto:">info@letabox.co.ke</a></p>
                    </div>
                </li>
                <li class="contactform">
                    <div>
                        <h3>Contact Form</h3>
                        <form action="" method="post">
                            <p>
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Your full name...">
                            </p>
                            <p>
                                <label for="email">Email Address</label>
                                <input type="text" name="email" id="email" placeholder="Your email address">
                            </p>
                            <p>
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" placeholder="Your phone number">
                            </p>
                            <p>
                                <label for="message">Message</label>
                                <textarea name="message" id="message" placeholder="Your message..."></textarea>
                            </p>
                            <p>
                                <input type="submit" id="send" name="send" value="Send Message">
                            </p>
                        </form>
                    </div>
                </li>
            </ul>
            <span class="clearfix"></span>

        </div>
    </div>

    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3988.8407066995737!2d36.8082352880764!3d-1.26839220786019!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xea367e10accb7130!2sThe+Citadel!5e0!3m2!1sen!2sus!4v1503304278988" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>

</section>
<?php require_once 'partials/footer.php'; ?>