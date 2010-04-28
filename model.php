<?php
/**
* @package jtIVeriBuyNow
* @copyright (C) 2009 Barry Roodt, Jumptag Web Development
*/

class jtModelIVeriBuyNow extends jtModel {

	/**
	* @param database A database connector object
	*/
	public function __construct( $db ) {
		$this->mainFrame = jtMainFrame::getInstance();
		$this->_db = $db;
	}

	public function store(){
		return true;
	}

	public function quickstore(){
		return true;
	}

	public function check() {
		return true;
	}
	
	public function formatForView(){
		return;
	}
	
	public function install(){
		$transaction = new jtModelIVeriBuyNowTransaction($this->_db);
		$transaction->install();
		return true;
	}

	public function getDefaults() {
		$default = array();
		$default["iveri_url"] = "https://backoffice.iveri.co.za/Lite/Transactions/New/Authorise.aspx";
		$default["iveri_default_bank"] = "nedbank";
		$default["iveri_merchant_id"] = "";
		$default["iveri_textcolor"] = "#ffffff";
		$default["iveri_bgcolor"] = "#86001B";
		$default["iveri_invoice_prefix"] = "WEBINV";
		$default["iveri_ship_to"] = 0;
		$default["iveri_button"] = '';
		$default["iveri_default_price"] = 100;
		$default["iveri_default_title"] = "Donation";
		$default["iveri_default_currency"] = "ZAR";
		$default["iveri_transaction_slug"] = "payment-result";
		return $default;
		
	}
}

class jtModelIVeriBuyNowTransaction extends jtModel {
	public $id;
	public $amount;
	public $item;
	public $status;	
	public $transnum;
	public $autoref;
	public $customer_data;
	public $raw_data;
	public $created;
	/**
	* @param database A database connector object
	*/
	public function __construct( $db ) {
		parent::__construct($db->prefix . "iveri_transaction", "id", $db);
	}
	
	public function load($id=null){
		$loaded = parent::load($id);
		$this->customer_data = ($loaded && !empty($this->customer_data)) ? jtUtility::unserialize($this->customer_data) : null;
		$this->raw_data = ($loaded && !empty($this->raw_data)) ? jtUtility::unserialize($this->raw_data) : null;
		return $loaded; 
	}

	public function store(){
		$this->created = time();
		
		$this->amount = jtUtility::cleanNumber($this->amount);
		
		$this->customer_data = (!is_serialized($this->customer_data)) ? jtUtility::serialize($this->customer_data) : $this->customer_data;
		$this->raw_data = (!is_serialized($this->raw_data)) ? jtUtility::serialize($this->raw_data) : $this->raw_data;
		
		if (!isset($this->status)) {
			$this->status = 0;
		}
		return parent::store();
	}

	public function quickstore(){
		$this->customer_data = (!is_serialized($this->customer_data)) ? jtUtility::serialize($this->customer_data) : $this->customer_data;
		$this->raw_data = (!is_serialized($this->raw_data)) ? jtUtility::serialize($this->raw_data) : $this->raw_data;
		return parent::store();
	}

	public function check() {
		if (!$this->transnum || !$this->item || !$this->amount){
			return false;
		}
		return true;
	}
	
	public function formatForView(){
		return;
	}
	
	public function install(){
		$sql = "CREATE TABLE IF NOT EXISTS `" . $this->_db->prefix . "iveri_transaction` (
			`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`amount` VARCHAR( 10 ) NOT NULL ,
			`item` VARCHAR( 200 ) NOT NULL ,
			`status` VARCHAR( 10 ) NOT NULL ,
			`transnum` VARCHAR( 200 ) NOT NULL ,
			`autoref` VARCHAR( 200 ) NOT NULL ,
			`customer_data` TEXT NOT NULL ,
			`raw_data` TEXT NOT NULL ,
			`created` VARCHAR( 100 ) NOT NULL
			) ENGINE = MYISAM ;
		";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	/**
	*	Return the sql necessary to perform a search on the db
	*	@param array $param
	*	@return object $select
	**/
	public function generateSQL($params=array()){			

		$select = new hmdSqlSelect($this->_db, $this->_tbl, "t", true);
		$select->addField("*","t");
		if($params["id"]){
			$select->where->addEquals("id", $params["id"], "t");
			return $select;
		}
		
		if ($params["status"]){
			$select->where->addEquals("status", $params["status"], "t");
		}
		
		if($params["transaction"]){
			$select->where->addLike("transnum", $params["transaction"], "t", true);
		}
		
		
		
		return $select;
	}
	
	public function mapRequestToCustomer(){
		$customer = array(
			"billing_title"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_NAME_PREFIX"),
			"billing_name"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_NAME_FIRST"),
			"billing_surname"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_NAME_LAST"),
			"billing_email"=> jtUtility::getParam($_POST, "ECOM_BILLTO_ONLINE_EMAIL"),
		
			"billing_suffix"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_NAME_SUFFIX"),
			"billing_street1"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_STREET_LINE1"),
			"billing_street2"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_STREET_LINE2"),
			"billing_street3"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_STREET_LINE3"),
			"billing_city"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_CITY"),
			"billing_state"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_STATEPROV"),
			"billing_postal_code"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_POSTALCODE"),
			"billing_country_code"=> jtUtility::getParam($_POST, "ECOM_BILLTO_POSTAL_COUNTRYCODE"),
			"billing_phone_number"=> jtUtility::getParam($_POST, "ECOM_BILLTO_TELECOM_PHONE_NUMBER"),
			"shipping_title"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_NAME_PREFIX"),
			"shipping_name"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_NAME_FIRST"),
			"shipping_middlename"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_NAME_MIDDLE"),
			"shipping_surname"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_NAME_LAST"),
			"shipping_suffix"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_NAME_SUFFIX"),
			"shipping_street1"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_STREET_LINE1"),
			"shipping_street2"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_STREET_LINE2"),
			"shipping_street3"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_STREET_LINE3"),
			"shipping_city"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_CITY"),
			"shipping_state"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_STATEPROV"),
			"shipping_postal_code"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_POSTALCODE"),
			"shipping_country_code"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_POSTAL_COUNTRYCODE"),
			"shipping_phone_number"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_TELECOM_PHONE_NUMBER"),
			"shipping_email"=> jtUtility::getParam($_POST, "ECOM_SHIPTO_ONLINE_EMAIL"),
		);
		
		return $customer;
		
	}
}
?>