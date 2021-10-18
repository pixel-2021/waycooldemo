<?php 
// local 
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);
if($_SERVER['HTTP_HOST'] == '192.168.0.58'){
$config['base_url'] = 'http://192.168.0.58/waycooldemo/website/'; // Base URL including trailing slash (e.g. http://192.168.0.47/)
$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)
define('img_base_url','http://192.168.0.58/waycooldemo/website/uploads/'); // Base URL including trailing slash (e.g. http://192.168.0.47/)

define('PAGEADMIN_URL','http://192.168.0.58/waycooldemo/website/');

}
else{

$config['base_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/clients/waycool/beta/'; // Base URL including trailing slash (e.g. http://192.168.0.47/)
$config['default_controller'] = 'main'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)
define('img_base_url','http://'.$_SERVER['SERVER_NAME'].'/clients/waycool/beta/uploads/'); // Base URL including trailing slash (e.g. http://192.168.0.47/)

define('PAGEADMIN_URL','http://'.$_SERVER['SERVER_NAME'].'/clients/waycool/beta/');
define('MAILLOGO','http://'.$_SERVER['SERVER_NAME'].'/clients/waycool/beta/uploads/logo/');
define('resumeurl','http://'.$_SERVER['SERVER_NAME'].'/clients/waycool/beta/uploads/resume/');
}

####for testing##########


define('BCCEMAIL','websupport@pixel-studios.com');
//define('BCCEMAILMEDIA','thulasiram.pixel@gmail.com,websupport@pixel-studios.com');
define('TOEMAIL','thulasiram.pixel@gmail.com');
define('productcount','9');
define('TIMER','10');
  /**************************************** Admin Tables *******************************/

 
if($_SERVER['HTTP_HOST'] == '192.168.0.47'){
  $config['db_host'] = '192.168.0.47'; // Database host (e.g. 192.168.0.47)
  $config['db_name'] = 'badabro_db'; // Database name
  $config['db_username'] = 'root'; // Database username
  $config['db_password'] = ''; // Database password
}else{
  $config['db_host'] = '192.168.0.47'; // Database host (e.g. 192.168.0.47)
  $config['db_name'] = 'mvc'; // Database name
  $config['db_username'] = 'mvc'; // Database username
  $config['db_password'] = 'mvc@123'; // Database password
}

define('DB_PREFIX',"akas_");

/**************************************** Database Tables *******************************/


define('tbl_configuration',DB_PREFIX."configuration");

define('tbl_jobcareer',DB_PREFIX."jobcareers");
define('tbl_carrier',DB_PREFIX."carrier_us");
define('tbl_contact_us',DB_PREFIX."contact_us");
define('tbl_clientlist',DB_PREFIX."clientlist");
define('tbl_client',DB_PREFIX."client");

define('tbl_projecttype',DB_PREFIX."projecttype");
define('tbl_projectstatus',DB_PREFIX."projectstatus");
define('tbl_project',DB_PREFIX."project");
define('tbl_projectimg',DB_PREFIX."projectimg");
define('tbl_projectenquiry',DB_PREFIX."projectenquiry");
define('tbl_career',DB_PREFIX."career");
define('tbl_location',DB_PREFIX."location");
define('tbl_position',DB_PREFIX."position");
define('tbl_announcement',DB_PREFIX."announcement");
define('tbl_careers',DB_PREFIX."careers");
define('tbl_popup_enquiry',DB_PREFIX."popup_enquiry");
define('tbl_platinum_enquiry',DB_PREFIX."platinum_enquiry");

define('tbl_nurse_training_enquiry',DB_PREFIX."nurse_training_enquiry");
define('tbl_rnd_committee_enquiry',DB_PREFIX."rnd_committee_enquiry");

define('listingcount','6');
define('PRODUCTERROR','Content will be updated soon...');


$config['storeid'] = '1';
$config['openurl']=array('apply_now'); 


?>