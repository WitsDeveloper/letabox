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
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1 
header('Expires: Sun, 17 Jan 1982 08:52:00 GMT'); // Date in the past
#Enable Sessions 
session_start(); 

#Site Settings 
define('SYSTEM_NAME', 'Leta Box');
define('SYSTEM_SHORT_NAME', 'Leta Box');
define('PARENT_HOME_URL', 'http://localhost/letabox/admin');
define('SYSTEM_URL', 'http://localhost/letabox/admin');
define('SYSTEM_LOGO_URL', 'http://via.placeholder.com/150x50&text=Logo');
#Site Contacts
define('COMPANY_PHONE', '+254-721-428-276');
define('COMPANY_ADDRESS', '');
#Folders
define('SYS_PATH', dirname(__DIR__));
define('IMAGE_FOLDER', SYSTEM_URL.'/images');
define('FILE_PATH', dirname(__DIR__). DIRECTORY_SEPARATOR ."files". DIRECTORY_SEPARATOR);
define('ATTACHMENT_PATH', dirname(__DIR__). DIRECTORY_SEPARATOR ."attachments". DIRECTORY_SEPARATOR);
define('FILE_FOLDER', SYSTEM_URL.'/files');
define('ATTACHMENT_FOLDER', SYSTEM_URL.'/attachments');
define('THEME_FOLDER', SYSTEM_URL.'/themes');
#Theme
define('THEME_NAME_BE', 'backend-theme');
define('THEME_DIR_BE', SYS_PATH.DIRECTORY_SEPARATOR."themes".DIRECTORY_SEPARATOR.THEME_NAME_BE);
define('THEME_URL_BE', THEME_FOLDER.'/'.THEME_NAME_BE);
#Emails used for alarts/notifications
define('INFO_NAME', 'WITS ADMINISTRATOR');
define('INFO_EMAIL', 'info@witstechnologies.co.ke');
define('SUPPORT_NAME', 'WITS SUPPORT');
define('SUPPORT_EMAIL', 'servicedesk@witstechnologies.co.ke');
define('DEVELOPER_NAME', 'Sammy M. Waweru');
define('DEVELOPER_EMAIL', 'sammy@witstechnologies.co.ke');
#Database Settings
define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');
define('DB_PREFIX', '');
#Mailer Settings
define('MAILER_FROM_NAME', '');
define('MAILER_FROM_EMAIL', '');
define('MAILER', 'mail');
define('SENDMAIL', '/usr/sbin/sendmail');
define('SMTP_AUTH', TRUE);
define('SMTP_SECU', 'ssl');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_HOST', '');
define('SMTP_PORT', 465);
#Permission Settings
define('LIMIT_USERS', FALSE);
define('LIMIT_ALLOWED', 2);
#Timezone Settings 
date_default_timezone_set('Africa/Nairobi');
#reCAPTCHA keys 
define('RECAPTCHA_PUBLIC_KEY', '');
define('RECAPTCHA_PRIVATE_KEY', '');
#Google Analytics 
define('GOOGLE_ANALYTICS_ID', '');
#SEO Settings 
define('META_KEYS', '');
define('META_DESC', '');
?>