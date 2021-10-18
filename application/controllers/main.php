<?php
class Main extends Controller {
	function index()
	{
 		$common=$this->loadModel('common_model');
		 
		//echo "reach"; print_r($getEproductcat); exit;
		 
		//echo "reach"; print_r($getAproductcat); exit;
		 
		//print_r($getEproductcatprods); exit;
	 	$template = $this->loadView('home_view');
		
		$headcss='<meta name="description" content="Waycool is one of India’s fastest growing Agri-tech
		companies that has established itself as the largest food development and distribution services">
				  <meta name="keywords" content="">
				  <meta name="google-site-verification" content="CHQf36c2aF98SDNoeCIyapJzTxEdfOMQJGLmkc5mY_A" />
				  <title> WayCool Foods and Products </title>';
		$template->set('menu_disp', 'home');	 
	    $template->set('headcss',$headcss);
		 
		//print_r($getRproductcat);		exit;
		 
	 
	//	$template->set('timer',$timer);
		$template->render();		
		
	}
}

?>
