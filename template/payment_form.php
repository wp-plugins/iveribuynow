<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<div class="iveri-payment-form-container">
	<?php if (!empty($price) && intval($price) > 0): ?>
		<p><strong>You have requested a <?php echo $title ?> for <?php echo $currency . $price ?></strong><br />
			Please fill in the following details
		</p>
	<?php endif; ?>	
	
	<form method="post" action="<?php echo (!empty($globals['iveri_url'])) ? $globals['iveri_url'] : "https://backoffice.iveri.co.za/Lite/Transactions/New/Authorise.aspx"; ?>" id="iveri-payment-form">
	<!-- required hidden fields, no need to edit -->
	    <input type="hidden" name="Lite_Merchant_ApplicationID" value="<?php echo $globals["iveri_merchant_id"]; ?>" />
	    <input type="hidden" name="Lite_Order_Amount" value="<?php echo intval(jtUtility::cleanNumber($price) * 100); ?>" id='iveri-order_amount' />
	    <input type="hidden" name="Lite_Order_BudgetPeriod" value="0" />
	    <input type="hidden" name="Lite_Website_TextColor" value="<?php echo $globals["iveri_textcolor"]; ?>" />
	    <input type="hidden" name="Lite_Website_BGColor" value="<?php echo $globals["iveri_bgcolor"]; ?>" />
	    <input type="hidden" name="Lite_AutoInvoice_Ext" value="<?php echo $globals["iveri_invoice_prefix"]; ?>" />
	    <input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="<?php echo $globals["iveri_invoice_prefix"]; ?>" />
	    <input type="hidden" name="Lite_Currency_AlphaCode" value="<?php echo $currency; ?>" />
	    
	    <input type="hidden" name="Lite_On_Error_Resume_Next" value="true" />
	    <input type="hidden" name="Lite_TransactionIndex" value="<?php echo md5(time()); ?>" />
	    <input type="hidden" name="MerchantReference" value="<?php echo md5(time()); ?>" />
	    
	    <input type="hidden" name="Ecom_ConsumerOrderID" value="AUTOGENERATE" />
	    <input type="hidden" name="Ecom_SchemaVersion" value="" />
	    <input type="hidden" name="Ecom_TransactionComplete" value="false" />
	    <input type="hidden" name="Lite_Payment_Card_PreAuthMode" value="false" />
	    <input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
	    
	    <input type="hidden" name="Lite_Website_Successful_url" value="<?php bloginfo("url"); ?>/<?php echo $globals["iveri_transaction_slug"]; ?>/?ivresult=success" />
		<input type="hidden" name="Lite_Website_Fail_url" value="<?php bloginfo("url"); ?>/<?php echo $globals["iveri_transaction_slug"]; ?>/?ivresult=fail" />
		<input type="hidden" name="Lite_Website_TryLater_url" value="<?php bloginfo("url"); ?>/<?php echo $globals["iveri_transaction_slug"]; ?>/?ivresult=tryagain" />
		<input type="hidden" name="Lite_Website_Error_url" value="<?php bloginfo("url"); ?>/<?php echo $globals["iveri_transaction_slug"]; ?>/?ivresult=error" />

	<!-- products, no need to edit -->
	    <input type="hidden" id="Lite_Order_LineItems_Product_1" name="Lite_Order_LineItems_Product_1" value="<?php echo $title; ?>" />
	    <input type="hidden" id="Lite_Order_LineItems_Quantity_1" name="Lite_Order_LineItems_Quantity_1" value="1" />
	    <input type="hidden" id='iveri-order_lineitem_amount' name="Lite_Order_LineItems_Amount_1" value="<?php echo intval(jtUtility::cleanNumber($price) * 100); ?>" />

	<!-- Ecml start-->

	    <!-- ShipTo 
	    <input type="hidden" id="Ecom_ShipTo_Postal_Name_Prefix" name="Ecom_ShipTo_Postal_Name_Prefix" value="NWJ">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Name_First" name="Ecom_ShipTo_Postal_Name_First" value="NEWTON">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Name_Middle" name="Ecom_ShipTo_Postal_Name_Middle" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Name_Last" name="Ecom_ShipTo_Postal_Name_Last" value="LIGRANGE">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Name_Suffix" name="Ecom_ShipTo_Postal_Name_Suffix" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Street_Line1" name="Ecom_ShipTo_Postal_Street_Line1" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Street_Line2" name="Ecom_ShipTo_Postal_Street_Line2" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_Street_Line3" name="Ecom_ShipTo_Postal_Street_Line3" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_City" name="Ecom_ShipTo_Postal_City" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_StateProv" name="Ecom_ShipTo_Postal_StateProv" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_PostalCode" name="Ecom_ShipTo_Postal_PostalCode" value="">
	    <input type="hidden" id="Ecom_ShipTo_Postal_CountryCode" name="Ecom_ShipTo_Postal_CountryCode" value="">
	    <input type="hidden" id="Ecom_ShipTo_Telecom_Phone_Number" name="Ecom_ShipTo_Telecom_Phone_Number" value="">
	    <input type="hidden" id="Ecom_ShipTo_Online_Email" name="Ecom_ShipTo_Online_Email" value="">
		-->
		<?php if (empty($price) || intval($price) <= 0): ?>		
		<fieldset>
			<legend>Donation Details</legend>
			<div>
				<label>Amount to donate in <?php echo $currency; ?>:</label>
				<input type="text" value="" id="iveri-priceInput" /> *
				<p class="error">Please enter a valid amount to donate using numbers only, eg 20.00</p>
			</div>
		</fieldset>
	<?php endif; ?>
		
		
	    <!-- BillTo - can edit if desired -->
	    <fieldset>
	    	<legend>Billing Details</legend>
	        <div>
	            <label>Title:</label>	            
					<select name="Ecom_BillTo_Postal_Name_Prefix">
					    <option value="Mr." >Mr.</option>
					    <option value="Mrs." >Mrs.</option>
					    <option value="Miss." >Miss.</option>
					    <option value="Ms." >Ms.</option>
					    <option value="Prof." >Prof.</option>
					    <option value="Dr." >Dr.</option>
					    <option value="Sir." >Sir.</option>
					</select>
			</div>
			<div>
				<label>First Name:</label>
				<input type="text" name="Ecom_BillTo_Postal_Name_First" value="" id="iveri-first" /> *
				<p class="error">Please enter your first name</p>
			</div>
			<div>
				<label>Surname:</label>
				<input type="text" name="Ecom_BillTo_Postal_Name_Last" value="" id="iveri-surname" /> *
				<p class="error">Please enter your surname</p>
			</div>
			<div>
	            <label>Email:</label>
	            <input type="text" name="Ecom_BillTo_Online_Email" value="" id="iveri-email" /> *
	            <p class="error">Please enter your email address</p>
	        </div>
	     </fieldset>
	<!-- More fields if you require further billing details - place as you see fit
	    <input type="text" id="Ecom_BillTo_Postal_Name_Suffix" name="Ecom_BillTo_Postal_Name_Suffix" value="iVeri">
	    <input type="text" id="Ecom_BillTo_Postal_Street_Line1" name="Ecom_BillTo_Postal_Street_Line1" value="">
	    <input type="text" id="Ecom_BillTo_Postal_Street_Line2" name="Ecom_BillTo_Postal_Street_Line2" value="">
	    <input type="text" id="Ecom_BillTo_Postal_Street_Line3" name="Ecom_BillTo_Postal_Street_Line3" value="">
	    <input type="text" id="Ecom_BillTo_Postal_City" name="Ecom_BillTo_Postal_City" value="">
	    <input type="text" id="Ecom_BillTo_Postal_StateProv" name="Ecom_BillTo_Postal_StateProv" value="">
	    <input type="text" id="Ecom_BillTo_Postal_PostalCode" name="Ecom_BillTo_Postal_PostalCode" value="">
	    <input type="text" id="Ecom_BillTo_Postal_CountryCode" name="Ecom_BillTo_Postal_CountryCode" value="">
	    <input type="text" id="Ecom_BillTo_Telecom_Phone_Number" name="Ecom_BillTo_Telecom_Phone_Number" value="4457500">	            
	-->
	    <!-- Payment -->
	    <fieldset>
	    	<legend>Card Details</legend>
	        <div>
	            <label>Credit Card Number:</label>
	                <input type="text" name="Ecom_Payment_Card_Number" value="" id="iveri-cc" /> *
	                <p class="info">Please type your credit card number without any spaces or hyphens</p>
	        </div>
			<div>
	            <label>CVV:</label>	           
	              <input type="text" name="Ecom_Payment_Card_Verification" value="" id="iveri-cvv" /> *
	              <p class="error">Please enter the credit card's cvv number</p>	              
	        </div>
			<div>
	            <label>Expiry Date:</label>
	                <input type="hidden" name="Ecom_Payment_Card_StartDate_Day" value="00" />
	                <input type="hidden" name="Ecom_Payment_Card_StartDate_Month" value="07" />
	                <input type="hidden" name="Ecom_Payment_Card_StartDate_Year" value="1999" />
	                <input type="hidden" name="Ecom_Payment_Card_ExpDate_Day" value="00" />
	                <select name="Ecom_Payment_Card_ExpDate_Month">
	                	<?php for ($i=1;$i<=12;$i++) { ?>
	                		<option><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
	                	<?php } ?>
	                </select>
	                <select name="Ecom_Payment_Card_ExpDate_Year">
	                	<?php for ($i=date("Y");$i<=date("Y", time() + (60 * 60 * 24 * 365 * 10));$i++) { ?>
	                		<option><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
	                	<?php } ?>
	                </select>
	        </div>
	     </fieldset>
	<!-- Ecml end-->
	        <div>
	            <input type="submit" name="Authorise" value="Authorise" />	            
	        </div>
	</form>
</div>
<?php endif; 