<?php
//for amazon

define('AWS_API_KEY', 'AKIAIRZTSHWP3C5W4GWQ');
define('AWS_API_SECRET_KEY', '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');
define('AWS_ASSOCIATE_TAG', 'witstechnolog-20');
//define('AWS_ANOTHER_ASSOCIATE_TAG', 'ANOTHER ASSOCIATE TAG');

//require_once($class_dir.'/amazon/lib/AmazonECS.class.php');
require_once('../amazon/lib/AmazonECS.class.php');

$client = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'COM', AWS_ASSOCIATE_TAG);
			
$category = isset( $_REQUEST['category'] )?$_REQUEST['category']:"All";
$search = isset( $_REQUEST['search'] )?$_REQUEST['search']:"";
$page = !empty( $_REQUEST['page'] )?$_REQUEST['page']:1;

//Currency
$CurrencyCode = !empty($CurrencyCode)?$CurrencyCode:"USD";
$SwitchCurrencyCode = !empty($SwitchCurrencyCode)?$SwitchCurrencyCode:"KES";
//$RateUSDKES = currencyRate($CurrencyCode, $SwitchCurrencyCode);
$RateUSDKES = 102.3;
// Calculator defaults (USD to KES)
define('USDKES_RATE',$RateUSDKES);
define('EXCHANGE_FEE',0.015);//1.50%
define('REALISTIC_EXCHANGE_RATE',(USDKES_RATE*(1+EXCHANGE_FEE)));
define('SHIPPING_RATE',7.99);
define('TAX_RATE',0);



?>