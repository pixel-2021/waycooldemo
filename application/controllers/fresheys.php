<?php
class fresheys extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('fresheys_view');
		
		$headcss='<meta name="description" content="Traditional food and ingredients made convenient for the modern family. Fresheys offers a range of kitchen ingredients, mediums and ready-to-cook products with a focus on convenience. ">
				  <meta name="keywords" content=" ">
				  
				  <title> Fresheys - WayCool </title>';
		$template->set('menu_disp', 'fresheys');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
