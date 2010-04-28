<?php
/*
Plugin Name: jtFrame
Plugin URI: http://jumptag.co.za/projects/jtFrame
Description: A framework to simplify the development of wordpress frameworks
Version: 0.1
Author: Barry Roodt - Jumptag Web Development
Author URI: http://jumptag.co.za/
*/
class jtInstall {

	public $model;
	public $version;
	public $configStr;

	public function __construct($model, $version, $configStr="jumptag_") {
		
		$this->model = $model;
		$this->version = $version;
		$this->configStr = (!empty($configStr)) ? $configStr : "jumptag_"; 
		
	}
	
	public function init() {
		
		// If model table exists then try upgrade, otherwise create it and add defaults
//		if (checkTable()) {
//			$this->model->upgrade();
//		}
//		else {
			$this->model->install();
			$this->loadDefaults();
//		}
		
	}
	
	public function loadDefaults(){
		$defaults = $this->model->getDefaults();
		
		if (is_array($defaults)){
				add_option($this->configStr, $defaults, null, "yes");
		}
	}
	
}
?>