<?php


 $class_dir = "../classes";        
          
 define('AWS_API_KEY', 'AKIAIRZTSHWP3C5W4GWQ');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_TAG', 'witstechnolog-20');

require_once($class_dir.'/amazon/lib/AmazonECS.class.php');
//require_once('../amazon/lib/AmazonECS.class.php');

$client = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'COM', AWS_ASSOCIATE_TAG);
			
$category = isset( $_REQUEST['category'] )?$_REQUEST['category']:"All";
$search = isset( $_REQUEST['search'] )?$_REQUEST['search']:"";
$page = !empty( $_REQUEST['page'] )?$_REQUEST['page']:1;

//Currency
$CurrencyCode = !empty($CurrencyCode)?$CurrencyCode:"USD";
$SwitchCurrencyCode = !empty($SwitchCurrencyCode)?$SwitchCurrencyCode:"KES";
//$RateUSDKES = currencyRate($CurrencyCode, $SwitchCurrencyCode);

//new from SYS
$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

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
//print $RateUSDKES = 102.3;
// Calculator defaults (USD to KES)
define('USDKES_RATE',$RateUSDKES);
define('EXCHANGE_FEE',0.015);//1.50%
define('REALISTIC_EXCHANGE_RATE',(USDKES_RATE*(1+EXCHANGE_FEE)));
define('SHIPPING_RATE',$SHIPPINGRATE);
define('TAX_RATE',$TAX_RATE);



?>