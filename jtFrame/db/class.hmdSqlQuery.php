<?php
/*
Plugin Name: jtFrame
Plugin URI: http://jumptag.co.za/projects/jtFrame
Description: A framework to simplify the development of wordpress frameworks
Version: 0.1
Author: Barry Roodt - Jumptag Web Development
Author URI: http://jumptag.co.za/
*/
	require_once "class.hmdSql.php";
	
	class hmdSqlQuery extends hmdSql {
		var $db;
		
		function hmdSqlQuery(&$db) {
			$this->db =& $db;
		}
	}
?>
