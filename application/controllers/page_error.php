<?php
class page_error extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('page_error_view');
		
		$headcss='<meta name="description" content=" ">
				  <meta name="keywords" content=" ">
				  
				  <title> 404 Page not found - Waycool </title>';
		$template->set('menu_disp', 'page_error');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
