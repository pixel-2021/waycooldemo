<?php
class kwik_kitchen extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('kwik_kitchen_view');
		
		$headcss='<meta name="description" content="Kwik Kitchen is the reason why food retains its original flavor, taste and nutrients.">
				  <meta name="keywords" content=" ">
				  
				  <title> Kwik Kitchen - WayCool </title>';
		$template->set('menu_disp', 'kwik_kitchen');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
