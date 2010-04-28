<?php
/*
Plugin Name: jtFrame
Plugin URI: http://jumptag.co.za/projects/jtFrame
Description: A framework to simplify the development of wordpress frameworks
Version: 0.1
Author: Barry Roodt - Jumptag Web Development
Author URI: http://jumptag.co.za/
*/
class jtLoader {
	public $model;
	public $view;
	public $task;
	public $output;
	
	
	public function __construct($model, $view, $task){
		$this->task = $task;
		$this->view = $view;
		$this->model = $model;
		$this->output = $this->loadTask();
	}
	
	public function loadTask(){
		switch( $this->task ) {
			case "edit":
				return $this->view->edit();
			break;
			
			case "delete":
				return jtModel::delete($this->model);
			break;
		
			case "status":
				return jtModel::storeStatus($this->model);
			break;
		
			case "multi_delete":
				return jtModel::multiDelete($this->model);
				break;
		
			default:
				if (method_exists($this->view, $this->task)){
					$task = $this->task;
					return $this->view->$task();
				} else {
					return $this->view->search();
				}
			break;
		}
	}
	
	public function getOutput(){
		if (empty($this->output)){
			$this->output = $this->view->output;
		}
		return $this->output;
	}
}
?>