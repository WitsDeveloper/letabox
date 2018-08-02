<?php 
/********************************************* 
Company:	Wits Technologies Ltd 
Developer:	Sammy Mwaura Waweru 
Mobile:		+254721428276 
Email:		sammy@witstechnologies.co.ke 
Website:	http://www.witstechnologies.co.ke/ 
Date Last Modified: 01/12/2014 
Last Modified By: Sammy Waweru 
*********************************************/ 

#Handle Errors 

error_reporting(E_ALL ^ E_NOTICE); 
//error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1 
header('Expires: Sun, 17 Jan 1982 08:52:00 GMT'); // Date in the past
#Enable Sessions 
session_start(); 

#Site Settings 
define('SYSTEM_NAME', 'Leta Box');
define('SYSTEM_SHORT_NAME', 'Leta Box');
define('PARENT_HOME_URL', 'http://dev.letabox.co.ke/');
define('SYSTEM_URL', 'http://dev.letabox.co.ke/');
define('SYSTEM_LOGO_URL', 'http://dev.letabox.co.ke/images/logo-mid.png');
#Site Contacts
define('COMPANY_PHONE', '+254-721-428-276');
define('COMPANY_ADDRESS', '');
#Folders
define('SYS_PATH', dirname(__DIR__));
define('IMAGE_FOLDER', SYSTEM_URL.'/images');
define('FILE_PATH', "../files/");
define('ATTACHMENT_PATH', "../attachments/");
define('FILE_FOLDER', SYSTEM_URL.'/files');
define('ATTACHMENT_FOLDER', SYSTEM_URL.'/attachments');
define('THEME_FOLDER', SYSTEM_URL.'/themes');
#Theme
define('THEME_NAME_FE', 'frontend-theme');
define('THEME_DIR_FE', SYS_PATH.DIRECTORY_SEPARATOR."themes".DIRECTORY_SEPARATOR.THEME_NAME_FE);
define('THEME_URL_FE', THEME_FOLDER.'/'.THEME_NAME_FE);
define('THEME_NAME_BE', 'backend-theme');
define('THEME_DIR_BE', SYS_PATH.DIRECTORY_SEPARATOR."themes".DIRECTORY_SEPARATOR.THEME_NAME_BE);
define('THEME_URL_BE', THEME_FOLDER.'/'.THEME_NAME_BE);
#Emails used for alarts/notifications
define('INFO_NAME', 'WITS ADMINISTRATOR');
define('INFO_EMAIL', 'info@witstechnologies.co.ke');
define('SUPPORT_NAME', 'WITS SUPPORT');
define('SUPPORT_EMAIL', 'support@witstechnologies.co.ke');
define('DEVELOPER_NAME', 'Sammy M. Waweru');
define('DEVELOPER_EMAIL', 'sammy@witstechnologies.co.ke');
#Database Settings
define('DB_HOST', 'localhost');
define('DB_USER', 'letabox_letabox_sys');
define('DB_PASS', 'letabox_letabox_sys');
define('DB_NAME', 'letabox_letabox_sys');
define('DB_PREFIX', 'lbs_');
#added db settings
   $mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');
   global $mysqli;
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
#Mailer Settings
define('MAILER_FROM_NAME', 'SYS');
define('MAILER_FROM_EMAIL', 'sys@witstechnologies.co.ke');
define('MAILER', 'mail');
define('SENDMAIL', '/usr/sbin/sendmail');
define('SMTP_AUTH', TRUE);
define('SMTP_SECU', '');
define('SMTP_USER', 'sammy@witstechnologies.co.ke');
define('SMTP_PASS', '');
define('SMTP_HOST', '');
define('SMTP_PORT', 465);
#Timezone Settings 
date_default_timezone_set('Africa/Nairobi');
#reCAPTCHA keys 
define('RECAPTCHA_PUBLIC_KEY', '6LfGSFIUAAAAAHjaEtxhr6uFSAMO7VBpERduy3DG');
define('RECAPTCHA_PRIVATE_KEY', '6LfGSFIUAAAAAABDncZdlL6BhD6JB_PH9zQCgHv0');
#Google Analytics 
define('GOOGLE_ANALYTICS_ID', '');
#SEO Settings 
define('META_KEYS', '');
define('META_DESC', '');
?>