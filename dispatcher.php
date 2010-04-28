<?php
/** ensure this file is being included by a parent file */

 class jtDispatcherIVeriBuyNow extends jtDispatcher {

 	/**
 	*	Constructor function
 	*	@param object the database connection
 	*	@param object the template object
 	*	@param array config data
 	*/
 	public function __construct($admin=false){
 		parent::__construct($admin); 		
 		$this->mainFrame->loadInclude("", "view.php");
 		$this->mainFrame->loadInclude("", "model.php"); 
 		if ($this->mainFrame->page == "transaction"){ 					
			$this->load("IVeriBuyNowTransaction", array("IVeriBuyNow", "jt_iveri"));
			$this->view->addDefaultScript("thickbox");
			$this->view->addDefaultStyle("thickbox");
 		} else {
			$this->load("IVeriBuyNow", array("IVeriBuyNow", "jt_iveri"));
 		}
 		 		
 	}
 	
 	public function install(){
 		$this->mainFrame->loadInclude("jtFrame", "class.install.php");
 		$model = new jtModelIVeriBuyNow($this->mainFrame->db);
 		$install = new jtInstall($model, $this->mainFrame->version, "jt_iveri");
 		$install->init();
 	}
 	
 	public function init(){
		add_shortcode('jtIVeriBuyNow', array(&$this, "addShortCode"));
 		//add_filter ('get_bookmarks', array(&$this, "addBookmark"));
 	}
 	
 	public function adminInit() { 		
			add_action('admin_menu', array(&$this, 'adminMenu'));
			add_action('admin_print_scripts', array(&$this->view, 'queueScripts'));
	}
	
	public function adminMenu(){		
		add_menu_page('iVeri BuyNow', 'iVeri BuyNow', 9, 'iVeriBuyNow', array(&$this, "adminDispatch"),"");
		add_submenu_page('iVeriBuyNow', 'Config', 'Config', 9, 'iVeriBuyNow', array(&$this, "adminDispatch"));
		add_submenu_page('iVeriBuyNow', 'Transactions', 'Transactions', 9, 'iVeriBuyNow&jt_page=transaction', array(&$this, "adminDispatch"));
	}
	
	public function dispatch(){
		if ($this->mainFrame->ajax == 1){
			$this->view->viewForm();
			$this->view->display();
			return;
		}
		
		if (isset($_GET["ivresult"])) {
			add_filter("the_posts", array(&$this, "createResultPage"));
			add_filter("the_content", array(&$this, "processResult"));			
		} else {
			$this->view->addDefaultStyle("iVeriForm", "form.css", true);
			$this->view->addDefaultScript("liveQuery", "jquery.livequery.min.js", true);
			$this->view->addDefaultScript("iVeriFormValidation", "form.js", true);
			$this->view->addDefaultScript("thickbox");
			$this->view->addDefaultStyle("thickbox");
		}
		
		return;
	}
		
	public function adminDispatch(){
		
		
		if ($this->mainFrame->page == "transaction"){			
			switch($this->mainFrame->task){
				case "view":
					$this->view->viewDetail();
					break;
				case "viewcustomer":
					$this->view->viewDetail(true);
					break;
				default:
					$this->view->viewList();					
				break;
			}
			$this->view->display();
			return;
		}
		
		if ($this->mainFrame->page == "config" || empty($this->mainFrame->page)){
			$this->view->adminConfig();	
			$this->view->display();	
			return;	
		}
		
		
	}
	
	public function addShortCode($attribs, $content=''){
		return $this->view->viewButton($attribs, $content);
	}
	
	public function processResult($content=""){				
		$this->view->viewResult($this->saveTransaction());
		$content = $this->view->display();
		return $content;
	}
	
	public function saveTransaction(){
		$transaction = new jtModelIVeriBuyNowTransaction($this->db);
		$transaction->status = jtUtility::getParam($_REQUEST, "ivresult");
		$transaction->raw_data = $_REQUEST;
		$transaction->amount = number_format((jtUtility::getParam($_POST, "LITE_ORDER_LINEITEMS_AMOUNT_1") / 100), 2);
		$transaction->item = jtUtility::getParam($_POST, "LITE_ORDER_LINEITEMS_PRODUCT_1");
		$transaction->autoref = jtUtility::getParam($_POST, "ECOM_CONSUMERORDERID");
		$transaction->transnum = jtUtility::getParam($_POST, "LITE_TRANSACTIONINDEX");
		$transaction->customer_data = jtModelIVeriBuyNowTransaction::mapRequestToCustomer();
		$transaction->store();		
		return $transaction->autoref;
	}
	
	public function createResultPage($rows){
		$result = new stdClass();
		$result->ID = 99999;
		$result->post_author = 1;
        $result->post_date = date("Y-m-d H:i:s");
		$result->post_date_gmt = date("Y-m-d H:i:s");
		$result->post_content = "";
		$result->post_title = "iVeri Payment Result";
		$result->post_category = 0;
        $result->post_excerpt = ""; 
        $result->post_status = "publish";
        $result->comment_status = "closed";
        $result->ping_status = "closed";
        $result->post_password = "";
        $result->post_name = "iveri-payment-result";
        $result->to_ping = "";
        $result->pinged = "";
        $result->post_modified = date("Y-m-d H:i:s");
        $result->post_modified_gmt = date("Y-m-d H:i:s");
        $result->post_content_filtered = "";
        $result->post_parent = 0;
        $result->guid = "";
        $result->menu_order = 0;
        $result->post_type = "page";
        $result->post_mime_type = "";
        $result->comment_count = 0;
        $result->ancestors = array();
        $result->filter = "raw";
		$rows = array($result);
		return $rows;
	}
	
 }
?>