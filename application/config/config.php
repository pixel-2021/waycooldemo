<?php 
// local 
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);
if($_SERVER['HTTP_HOST'] == '192.168.0.58'){
$config['base_url'] = 'http://192.168.0.58/waycooldemo/'; // Base URL including trailing slash (e.g. http://192.168.0.47/)
$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)
define('img_base_url','http://192.168.0.58/waycooldemo/uploads/'); // Base URL including trailing slash (e.g. http://192.168.0.47/)

define('PAGEADMIN_URL','http://192.168.0.58/waycooldemo/');

}
else{

  $config['base_url'] = 'https://'.$_SERVER['SERVER_NAME'].'/'; // Base URL including trailing slash (e.g. http://192.168.0.47/)
  $config['default_controller'] = 'main'; // Default controller to load
  $config['error_controller'] = 'page_error'; // Controller used for errors (e.g. 404, 500 etc)
  define('img_base_url','https://'.$_SERVER['SERVER_NAME'].'/'); // Base URL including trailing slash (e.g. http://192.168.0.47/)
  
  define('PAGEADMIN_URL','https://'.$_SERVER['SERVER_NAME'].'/');
  define('MAILLOGO','https://'.$_SERVER['SERVER_NAME'].'/uploads/logo/');
  define('resumeurl','https://'.$_SERVER['SERVER_NAME'].'/uploads/resume/');
}

####for testing##########


define('BCCEMAIL','websupport@pixel-studios.com');
//define('BCCEMAILMEDIA','thulasiram.pixel@gmail.com,websupport@pixel-studios.com');
define('TOEMAIL','thulasiram.pixel@gmail.com');
define('productcount','9');
define('TIMER','10');
  /**************************************** Admin Tables *******************************/

 
if($_SERVER['HTTP_HOST'] == '192.168.0.47'){
  $config['db_host'] = 'localhost'; // Database host (e.g. 192.168.0.47)
  $config['db_name'] = 'waycool_db'; // Database name
  $config['db_username'] = 'root'; // Database username
  $config['db_password'] = ''; // Database password
}else{
  $config['db_host'] = 'localhost'; // Database host (e.g. 192.168.0.47)
  $config['db_name'] = 'mvc'; // Database name
  $config['db_username'] = 'mvc'; // Database username
  $config['db_password'] = 'mvc@123'; // Database password
}

define('DB_PREFIX',"way_");

/**************************************** Database Tables *******************************/


define('tbl_configuration',DB_PREFIX."configuration");

define('tbl_jobcareer',DB_PREFIX."jobcareers");
define('tbl_carrier',DB_PREFIX."carrier_us");
define('tbl_contact_us',DB_PREFIX."contact_us");
define('tbl_clientlist',DB_PREFIX."clientlist");
define('tbl_client',DB_PREFIX."client");

$config['storeid'] = '1';
$config['openurl']=array('apply_now'); 


?>
