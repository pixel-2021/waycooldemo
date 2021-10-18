<?php

class View {

	private $pageVars = array();
	private $template;
	public $model;

	public function __construct($template)
	{
		$this->template = APP_DIR .'views/'. $template .'.php';
	}
	
	public function loadModel($name)
	{
	
		require(APP_DIR .'models/'. strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	
	public function set($var, $val)
	{
		$this->pageVars[$var] = $val;
	}

	public function render()
	{
		extract($this->pageVars);

		ob_start();
		require($this->template);
		echo ob_get_clean();
	}
	
	public function renderinvariable()
	{
		extract($this->pageVars);
		ob_start();
		require($this->template);
		return ob_get_clean();
	}
    
}

?>