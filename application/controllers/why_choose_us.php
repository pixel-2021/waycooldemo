<?php
class why_choose_us extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('why_choose_us_view');
		
		$headcss='<meta name="description" content="We have deep and wide sourcing for fresh fruits and vegetables, staples, and other kitchen essentials. ">
				  <meta name="keywords" content=" ">
				  
				  <title> Why Choose Us - WayCool </title>';
		$template->set('menu_disp', 'why_choose_us');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
