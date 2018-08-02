<?php

require_once 'partials/config.php';

$header = array(
    'page'=>'confirm email',
    'title'=>'Get a custom quote for '.$s
);
require_once 'partials/header.php';

?>
<section class="maincontent">

    <div class="noresults">
        <div class="container">
             <article>
                 <br>
                 <h3>Your account is now active.</h3> 
                 <br>
            </article>
<?php

$comKey=filter_var($_GET['passkey'], FILTER_SANITIZE_STRING);
 //$passkey = $_GET['passkey'];
 //$mail_update = "UPDATE users SET com=NULL WHERE com='$passkey'";
$mail_update = $mysqli->query("UPDATE lbs_customer SET comcode='activated' WHERE comcode='$comKey'") or 
         die('Error : ('. $mysqli->errno .') '. $mysqli->error);
  
  if(@$mail_update>0){ 
 
  echo '<div class="col-md-12"> <a href="index.php" class="button boy-btn" >Sign in now</a></div>';
}
 else
 {
  echo "Some error occur.";
 }
?>
            

        </div>
    </div>
    

</section>
<?php require_once 'partials/footer.php'; ?>