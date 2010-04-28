<?php
/*
Plugin Name: jtFrame
Plugin URI: http://jumptag.co.za/projects/jtFrame
Description: A framework to simplify the development of wordpress frameworks
Version: 0.1
Author: Barry Roodt - Jumptag Web Development
Author URI: http://jumptag.co.za/
*/
 class jtDispatcher {
	public $isAdmin;
 	public $mainFrame;
 	public $sql;
 	public $rows;
 	public $output;
 	public $config;
 	public $view;
 	public $model;
	public $db;

 	/**
 	*	Constructor function
 	*	@param object the database connection
 	*	@param object the template object
 	*	@param array config data
 	*/
 	public function __construct($admin=false){
		$this->mainFrame = jtMainFrame::getInstance();
		$this->db = $this->mainFrame->db;
 		$this->view = "";
 		$this->isAdmin = $admin;
 	}
 	
 	public function execute(){
 		
 		if ($this->isAdmin){
 			$this->adminInit();
 			//$this->adminDispatch();
 			
 		} else {
 			$this->init();
 			$this->dispatch();
 		}
 	}
 	
 	public function adminInit(){
 		return;
	}
	
	public function adminDispatch(){
		return;
	}
	
	public function init(){
		return;
	}
	
	public function dispatch(){
		return;
	}
	
	public function load($suffix, $configArr){
		$view = "jtView" . $suffix;
		$model = "jtModel" . $suffix;		
 		$this->model = new $model($this->mainFrame->db);
 		$this->view = new $view($this->admin, $this->model);
 		$this->view->config = jtUtility::getConfig($configArr[0],$configArr[1]);
	}	
	
 }
?>