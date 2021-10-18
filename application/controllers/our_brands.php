<?php
class our_brands extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('our_brands_view');
		
		$headcss='<meta name="description" content=" Delight your customers with our range of farm-fresh fruits & vegetables and home brands that are built ground up with extensive quality control from the source to your doorstep. ">
				  <meta name="keywords" content=" ">
				  
				  <title> Homegrown Brands - WayCool </title>';
		$template->set('menu_disp', 'our_brands');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
