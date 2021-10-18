<?php

function pip()
{
	
	global $config;
    

	
    // Set our defaults
    $controller = $config['default_controller'];
    $action = 'index';
    $url = '';
	
	// Get request url and script url
	$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
	$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
	
	
	    	
	// Get our url path and trim the / of the left and the right
	if($request_url != $script_url) 
		$url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
	
		
    	
	// Split the url into segments
	$segments = explode('/', $url);	
	
	// Do our default checks
	if(isset($segments[0]) && $segments[0] != '') {		
		if(strpos($segments[0],"?") ===  false ){
			$controller = $segments[0];
		}
		else{			
			$controller = explode("?",$segments[0])[0];			
		}
			
	}



	//For '-' for slug
	if(strpos($controller,'_')!==false)
	{
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$actual_link=str_replace("_","-",$actual_link);	
		header("HTTP/1.1 301 Moved Permanently"); 		
		header('Location: '. $actual_link);	
	}
	//end For '-' for slug
	
	
	if(isset($segments[1]) && $segments[1] != '') {		
		if(strpos($segments[1],"?") ===  false ){
			$controller2 = $segments[1];
		}
		else{			
			$controller2 = explode("?",$segments[1])[0];			
		}			
	}
	
	
	
	//For '-' for slug
	if(strpos($controller2,'_')!==false)
	{
		$actual_link2 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		$actual_link2=str_replace("_","-",$actual_link2);	
		header("HTTP/1.1 301 Moved Permanently"); 		
		header('Location: '. $actual_link2);	
	}
	//end For '-' for slug

     $controller=str_replace("-","_",$controller);	
     $path = APP_DIR . 'controllers/' . $controller . '.php';
     //print_r( ); die();
		if(!file_exists($path)){
			if($controller!=""){
				 $controller = $config['error_controller'];
				 header("HTTP/1.1 301 Moved Permanently"); 
				 header("Location: ".BASE_URL.$config['error_controller']); 
				 exit();
			}
			else
				$controller = 'main';
		}
	
	if(!in_array($controller,$config['openurl'])){
	if(isset($segments[1]) && $segments[1] != '') {		
		if(strpos($segments[1],"?") ===  false ){
			$action = $segments[1];
		}
		else{
			
			$action = explode("?",$segments[1])[0];
		}
	}
	}
	
	
	
	
	$tempcontroller=$controller;
		
 $controller=str_replace("-","_",$controller);
	// Get our controller file
    $path = APP_DIR . 'controllers/' . $controller . '.php';
	
	if(file_exists($path)){
		
        require_once($path);
		
		
	} else {
		//echo $path; die();
        $controller = $config['error_controller'];
        require_once(APP_DIR . 'controllers/' . $controller . '.php');
	}	   
	//echo "gg"; die();
    // Check the action exists
    if(!method_exists($controller, $action)){
        $controller = $config['error_controller'];
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".BASE_URL.$config['error_controller']); 
		exit();
        //require_once(APP_DIR . 'controllers/' . $controller . '.php');
        //$action = 'index';
    }
		
	
	// Create object and call method
	$obj = new $controller;
	if(!in_array($tempcontroller,$config['openurl'])){
	
	$dataval=array_slice($segments, 2);
	}else{
			
		$dataval=array_slice($segments, 0);
		
	}
	
	//print_r($dataval); die();
	
	$dataval_arr=array();
	foreach($dataval as $val){
		$dataval_arr[]=str_replace("_","-",$val);	

	}

    die(call_user_func_array(array($obj, $action),$dataval));
}

?>
