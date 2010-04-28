<?php
/** ensure this file is being included by a parent file */

 class jtViewIVeriBuyNow extends jtView {

 	/**
 	*	Constructor function
 	*	@param object the database connection
 	*	@param object the template object
 	*	@param array config data
 	*/
 	public function __construct($admin=false, $model){
 		parent::__construct($admin, $model); 
 	}
	
	public function adminConfig(){
	 	
	 	if (isset($_POST["items"])) {	 		
	 		$items = jtUtility::getParam($_POST, "items", array());
	 		switch($items["iveri_default_bank"]){
	 			case "imbank_usd":
					$items["iveri_default_currency"] = "USD";
	 				$items["iveri_url"] = "https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 			case "imbank_kes":
					$items["iveri_default_currency"] = "KES";
	 				$items["iveri_url"] = "https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 				
	 			case "chams_usd":
					$items["iveri_default_currency"] = "USD";
	 				$items["iveri_url"] = "https://backoffice.chams.iveri.com/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 				
	 			case "chams_ngn":
					$items["iveri_default_currency"] = "NGN";
	 				$items["iveri_url"] = "https://backoffice.chams.iveri.com/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 				
	 			case "cards_tech":
	 				$items["iveri_default_currency"] = "USD";
	 				$items["iveri_url"] = "https://backoffice.ctlnigeria.iveri.com/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 			
	 			default:
	 				$items["iveri_default_currency"] = "ZAR";
	 				$items["iveri_url"] = "https://backoffice.iveri.co.za/Lite/Transactions/New/Authorise.aspx";
	 				break;
	 		}
	 		if (is_array($items)){
	 			update_option("jt_iveri", $items);
	 			$this->config = $items;
	 		}
	 		
	 		$this->addTmplVar("msg", "Options updated successfully");
	 	}
	 	
	 	$this->addTmplVar("items", $this->config);
	 	$this->output = $this->getTemplate("config.php");
	}
	
	public function viewForm(){
		$price = jtUtility::getParam($_REQUEST, "price");
		$title = jtUtility::getParam($_REQUEST, "title");
		//$currency = jtUtility::getParam($_REQUEST, "currency", $this->config["iveri_default_currency"]);
		$currency = $this->config["iveri_default_currency"];
		/*
		if (!$price || !$title){
			$this->output = $this->getTemplate("payment_form_empty.php");
			return;
		}
		*/
		$this->addTmplVar("price", $price);
		$this->addTmplVar("title", $title);
		$this->addTmplVar("currency", $currency);
		$this->output = $this->getTemplate("payment_form.php");
		return;
		
	}
	
	public function viewButton($attribs, $content = ''){
		$defaults = array(
			"price"=>$this->config["iveri_default_price"], 
			"title"=>$this->config["iveri_default_title"],
			"button"=>$this->config["iveri_button"],
			"currency"=>$this->config['iveri_default_currency']
		);
		
		$values = shortcode_atts($defaults,$attribs);
		
			
		$this->addTmplVar("item", $values);
		return $this->getTemplate("shortcode_button.php");
	}
	
	public function viewResult($ordernum=false){
		$result = jtUtility::getParam($_REQUEST, "ivresult");
		switch($result){
			case "success":
				$this->addTmplVar("ordernum", $ordernum);
				$this->output = $this->getTemplate("result_success.php");
				break;				
			case "fail":
				$this->output = $this->getTemplate("result_fail.php");
				break;		
			case "tryagain":
				$this->output = $this->getTemplate("result_tryagain.php");
				break;
				
			default:
				$this->output = $this->getTemplate("result_error.php");
				break;
		}
		
		return;
	}
	
	
 }

class jtViewIVeriBuyNowTransaction extends jtView {

 	/**
 	*	Constructor function
 	*	@param object the database connection
 	*	@param object the template object
 	*	@param array config data
 	*/
 	public function __construct($admin=false, $model){

 		parent::__construct($admin, $model);

 		$this->params = array(
 			"transaction"=> jtUtility::getParam($_REQUEST, "jt_transaction"),
 			"status" => jtUtility::getParam($_REQUEST, "jt_status"),
 			"id" => jtUtility::getParam($_REQUEST, "jt_id") 		
 		);

 		$this->perPage = ($this->mainFrame->perPage) ? $this->mainFrame->perPage : $this->config["perPage"];

 		// generate our query, since we already have the necessary search criteria
 		$this->_select = $this->model->generateSQL($this->params);
 		// set our default limit
 		//$this->_select->setLimit($this->mainFrame->perPage, $this->mainFrame->pageStart);

 	}

 	/**
 	*	Perform a search for listings and return an object - i.e. short display
 	*	@param int mode (0 = no formatting, 1 = formatted)
 	*	@return object resulting rows
 	*/
 	public function getList($mode=0) {

		// first clear our limit, since we want to get the total number of rows.
		$this->_select->clearLimit();
		$this->_total_rows = $this->_select->getCount();
		$this->_select->setLimit($this->perPage, $this->mainFrame->pageStart);

		if ($this->_total_rows) { // our search has returned at least 1 result
			// reset our pagination to page 1 if we have less rows available than the number of listings allowed per page
			if ( $this->_total_rows <= $this->perPage ) {
				$this->mainFrame->pageStart = 0;
				$this->_select->setLimit($this->perPage, $this->mainFrame->pageStart);
			}

			// now set our orderBy clause and re-execute our query
			$this->_select->setOrderByTxt("created DESC");		

			$rows = $this->_select->getObjectTable();
			
			// get the results in the display mode required
			switch($mode) {
				case "1":
					// formatted / modified results
			 		$output = $this->getDisplayObject($rows, 0);
			 		break;
			 	default :
			 		// raw results
			 		$output = $rows;
			 		break;
			}

		} else 	{
			$output = '';
		}

		return $output;
 	}

 	/**
 	*	Return the rows formatted and ready for output
 	*	@param object the list of rows to loop through
 	*	@param bool return single or multiple rows
 	*	@return object formatted row
 	*/

 	public function getDisplayObject($rows, $single=1){

		$i = 0;

		foreach($rows as $row) {						
			$rows[$i]->date = date("Y-m-d H:i:s",$row->created);
			$rows[$i]->customer = jtUtility::unserialize($row->customer_data);
			$rows[$i]->raw = jtUtility::unserialize($row->raw_data);
			$rows[$i]->count = $i;			
			$i++;
		}

		if ($single) {
			return $rows[0];
		} else {
			return $rows;
		}

	}

	public function viewList(){

		$rows = $this->getList(0);
		//print_r($this->_select->toString());
		if ($this->_total_rows > 0) {				
			$displayRows = $this->getDisplayObject($rows,0);				

			$this->addTmplVar("isvalidPage", 1);
			$this->addTmplVar('numrows', count($rows));				
			$this->addTmplVar('rows', $displayRows);
			$this->output = $this->getTemplate("transaction_list.php");

		} else 	{
			$this->output = $this->getTemplate("transaction_empty.php");
		}

	}
	
	public function viewDetail($customer=false){
		$row = $this->getDisplayObject($this->_select->getObjectTable(), 1);
		
		
		if ($row->id) {		
			
			$this->addTmplVar("isvalidPage", 1);
			if ($customer){				
				$this->addTmplVar('row', $row->customer);
			} else {
				$this->addTmplVar('row', $row->raw);
			}
			$this->output = $this->getTemplate("transaction_detail.php");

		} else 	{
			$this->output = $this->getTemplate("transaction_empty.php");
		}

	}

 }
?>