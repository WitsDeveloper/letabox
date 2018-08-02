<?php

define('BASE_HREF', 'http://dev.letabox.co.ke/');

$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

function ratingstars($counter = 0) {

    // filled stars
    $html = '';
    if($counter > 0) {
        for($i=0; $i < $counter; $i++) {
            $html .= '<span class="filled">'.file_get_contents('images/icons/star-filled.svg').'</span>';
        }
    }

    // empty stars
    $empty = 5 - $counter;
    for($i=0; $i < $empty; $i++) {
        $html .= '<span>'.file_get_contents('images/icons/star-outline.svg').'</span>';
    }

    return $html;

}
//api configs
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

// NOTE: Requires PHP version 5 or later
if (version_compare(PHP_VERSION, '5.3.0', '>') ){
	# Load includes
	$incl_dir = "includes";
	$class_dir = "classes";
	$logs_dir = "logs";
	//$cust_dir = "customer";
	
	include "$incl_dir/config.php";
	require_once("$incl_dir/mysqli.functions.php");
	require_once("$incl_dir/functions.php");
	//require_once("$cust_dir/customer.functions.php");
        //fb
        
} 
else { 
	# PHP version not sufficient
	exit("This system will only run on PHP version 5.3 or higher!\n");
}

define('AWS_API_KEY', 'AKIAIRZTSHWP3C5W4GWQ');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_TAG', 'witstechnolog-20');
//define('AWS_ANOTHER_ASSOCIATE_TAG', 'ANOTHER ASSOCIATE TAG');

require_once($class_dir.'/amazon/lib/AmazonECS.class.php');
$client = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'COM', AWS_ASSOCIATE_TAG);
			
$category = isset( $_REQUEST['category'] )?$_REQUEST['category']:"All";
$search = isset( $_REQUEST['search'] )?$_REQUEST['search']:"";
$page = !empty( $_REQUEST['page'] )?$_REQUEST['page']:1;

//Currency
$CurrencyCode = !empty($CurrencyCode)?$CurrencyCode:"USD";
$SwitchCurrencyCode = !empty($SwitchCurrencyCode)?$SwitchCurrencyCode:"KES";
//$RateUSDKES = currencyRate($CurrencyCode, $SwitchCurrencyCode);
//new from SYS
$results = $mysqli->query("SELECT * FROM lbs_settings ") or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);


while($row = $results->fetch_object()) {
if($row->lbs_settings_name=='SHIPPING_RATE'){
 $SHIPPINGRATE=$row->lbs_settings_value;   
}
elseif($row->lbs_settings_name=='TAX_RATE'){
 $TAX_RATE=$row->lbs_settings_value;      
}
elseif($row->lbs_settings_name=='MARGIN'){
 $MARGIN=$row->lbs_settings_value;      
}
elseif($row->lbs_settings_name=='RateUSDKES'){
 $RateUSDKES=$row->lbs_settings_value;      
}
else{
    
}

 
} 

//end new from syste
//$RateUSDKES = 102.3;
// Calculator defaults (USD to KES)
/*define('USDKES_RATE',$RateUSDKES);
define('EXCHANGE_FEE',0.015);//1.50%
define('REALISTIC_EXCHANGE_RATE',(USDKES_RATE*(1+EXCHANGE_FEE)));
define('SHIPPING_RATE',$SHIPPINGRATE);
define('TAX_RATE',$TAX_RATE);*/
define('DEFAULT_WEIGHT',1.0);
define('USDKES_RATE',(float)$RateUSDKES);
define('EXCHANGE_FEE',0.015);
define('REALISTIC_EXCHANGE_RATE',(USDKES_RATE*(1+EXCHANGE_FEE)));
define('SHIPPING_RATE',$SHIPPING_RATE);
define('TAX_RATE',$TAX_RATE);
define('MARGIN',$MARGIN);

//Open database connection
$conn = db_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

?>