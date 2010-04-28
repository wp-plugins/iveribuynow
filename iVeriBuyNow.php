<?php
/*
Plugin Name: iVeri Buy Now Buttons
Plugin URI: http://iveri.co.za
Description: Description for the plugin is to go here 
Version: 0.1
Author: Barry Roodt - Jumptag Web Development
Author URI: http://jumptag.co.za/
*/
$root = dirname(dirname(dirname(dirname(__FILE__))));

if (file_exists($root.'/wp-load.php')) {
	require_once($root.'/wp-load.php');
} else {
	exit;
}

define('JT_PATH', trailingslashit(dirname(__FILE__)));
add_action('wp_ajax_iVeriBuyNow', 'iVeriBuyNow');
		
if (!function_exists("iVeriBuyNow")){
	function iVeriBuyNow() {
		
		if (!class_exists("jtMainFrame")){
			require_once(JT_PATH . 'jtFrame/class.mainframe.php'); 
		}		
		$jtMainFrame = jtMainFrame::newInstance(dirname(plugin_basename(__FILE__)));		
		$jtDispatcher = new jtDispatcherIVeriBuyNow(is_admin());
		// Setup the installer on activation of the plugin
		register_activation_hook(__FILE__, array(&$jtDispatcher, 'install'));
		if (is_admin() && $jtMainFrame->ajax){
			$jtDispatcher->adminDispatch();		
		} else {
			$jtDispatcher->execute();
		}
	}
}
if (function_exists("iVeriBuyNow") && !isset($_POST["jt_ajax"])) {		
		iVeriBuyNow();
}
?>