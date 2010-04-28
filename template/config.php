<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<?php $currencies = array(
		"ZAR"=>"South African Rand",
		"AUD"=>"Australian Dollar",
		"CAD"=>"Canadian Dollar",
		"CHF"=>"Swiss Franc",
		"DKK"=>"Danish Krone",
		"ETB"=>"Ethiopian Birr",
		"EUR"=>"European Union Euro",
		"GBP"=>"United Kingdom Pound Sterling",
		"HKD"=>"Hong Kong Dollar",
		"INR"=>"Indian Rupee",
		"JPY"=>"Japanese Yen",
		"KES"=>"Kenyan Shilling",
		"MYR"=>"Malaysian Ringgit",
		"NAD"=>"Namibia Dollar",
		"NGN"=>"Nigerian Naira",
		"NOK"=>"Norwegian Krone",
		"NZD"=>"New Zealand Dollar",
		"SEK"=>"Swedish Krona",
		"SGD"=>"Singapore Dollar",
		"USD"=>"United States Dollar" 
	);
	$currency_content = "";
	foreach ($currencies as $key=>$val){
		$currency_content .= "<option value='$key'";
		$currency_content .= ($key == $items["iveri_default_currency"]) ? " selected='selected'>" : ">";
		$currency_content .= $val . "</option>\n";
	} 
	
	$banks = array(
		"nedbank" => "NedBank[ZAR]",
		"imbank_usd" => "I&amp;M Bank[USD]",
		"imbank_kes" => "I&amp;M Bank[KES]",
		"chams_usd" => "Chams[USD]",
		"chams_ngn" => "Chams[NGN]",
		"cards_tech" => "Cards Technology[USD]"
	);
	
	$banks_content = "";
	foreach($banks as $key=>$val){
		$banks_content .= "<option value='$key'";
		$banks_content .= ($key == $items["iveri_default_bank"]) ? " selected='selected'>" : ">";
		$banks_content .= $val . "</option>\n";
	}
	
	?>
<div class="wrap">
	<form method="post" action="">
	<?php wp_nonce_field('update-options'); ?>
	<table width="80%" border="0">
      <tr>
        <td><h2>iVeri Buy Now Button Introduction</h2></td>        
      </tr>
    </table>
	<table width="80%">
	<tr>
	<td>
		<p>Thank you for installing the iVeri Buy Now Button plugin.</p>
		<h2>How to Use:</h2>
		<ol>
			<li><h4>Configure your payment gateway settings using the form below.</h4>
				<ol>
					<li>Remember to enter the iVeri Application ID as supplied to you by iVeri</li>
					<li>Select the Aquiring Bank as per your iVeri application (determines API Url and Currency to use)</li>
					<li>Set the Invoice Prefix to use for your auto-generated invoice numbers</li>
					<!-- <li>Select a default currency to be used for your buy now buttons</li> -->
					<li>Set a default price and item title - leave blank to allow your customers to enter their own price (for donations).</li>
					<li>Provide a url to a "Buy Now" button - leave blank to use the default</li>
					<li>Set the Return slug (the page name iVeri will post back to once a transaction has been processed). Default is "payment-result"</li>
					<li>Set the text and background colours to be used on the iVeri process pages - standard # codes apply</li>
				</ol>					
			</li>
			<li><h4>Insert the following shortcode into the post or page to display a "Buy Now" button</h4>
				<ol>
					<li>[jtIVeriBuyNow] - will display a "Buy Now" button using the default values entered via the configuration form below</li>
					<li>[jtIVeriBuyNow <strong>price="200.00"</strong>] - will set the price to "200.00" and use default title and currency (please use numbers only)</li>
					<li>[jtIVeriBuyNow <strong>price="0"</strong>] - will allow the customer to enter their own price (for donations)</li>
					<li>[jtIVeriBuyNow <strong>title="My Product"</strong>] - will set the item title to "My Product" and use default price and currency</li>
					<!-- <li>[jtIVeriBuyNow <strong>currency="USD"</strong>] - will set the currency code to USD and use default price and title</li> -->
					<li>[jtIVeriBuyNow <strong>button="http://url.to.new.button"</strong>] - will set button image to specified url</li>
					<li>[jtIVeriBuyNow <strong>price="200.00"</strong> <strong>title="My Product"</strong> <!-- <strong>currency="USD"</strong> -->] - will set all 3 options to the specified values</li>
					<li>You can mix and match the following options to override the defaults: <strong>"price"</strong>, <strong>"title"</strong>, <strong>"button"</strong><!-- , <strong>"currency"</strong> --></li>
				</ol>
			</li>
			<li><h4>Keep track of your transactions</h4>
				<ol>
					<li>Use the sub-menu provided to switch views between <strong>successful</strong>, <strong>failed</strong> and <strong>erroneous</strong> transactions</li>
					<li>Click on the <strong>customer's name</strong> to launch your email client and send an email to the customer</li>
					<li>Click <strong>[Customer Data]</strong> to view more information about the customer</li>
					<li>Click <strong>[Raw Data]</strong> to view all information returned by the iVeri transaction process (handy when trying to discover the source of any possible errors)</li>
				</ol>
			</li>
			<li><h4>Advanced: Customize all available templates</h4>
				<ol>
					<li>Browse through the <em>"wp-content/plugins/iVeriBuyNow/template"</em> folder</li>
					<li>Customize the look and feel of the <strong>transaction results</strong>, the <strong>payment form</strong> and more</li>
				</ol>
			</li>
		</ol>			
	</td>
	</tr>
	</table>	
	<br />
	<table align="left" width="80%">
	<tr>
	<td align="right"><a href="#" target="_blank">Follow on Twitter</a> | <a href="#" target="_blank">Plugin Website</a> | 
	<img src="<?php echo $globals["tmplUrl"] ?>/img/delicious.png" />
	<img src="<?php echo $globals["tmplUrl"] ?>/img/digg.png" />
	<img src="<?php echo $globals["tmplUrl"] ?>/img/facebook.png" />
	<img src="<?php echo $globals["tmplUrl"] ?>/img/reddit.png" />
	<img src="<?php echo $globals["tmplUrl"] ?>/img/sphinn.gif" />
	<img src="<?php echo $globals["tmplUrl"] ?>/img/twitter.gif" />
	</td>
	</tr>
	</table>
	<p>&nbsp;</p>
	<h2>iVeri Buy Now Button Configuration</h2>
	<table class="form-table">		
		<tr>
			<th scope="row">iVeri Application ID:</th>
			<td>
				<input type="text" name="items[iveri_merchant_id]" value="<?php echo $items["iveri_merchant_id"]; ?>" size="40" /> (Your merchant ID given to you by iVeri)
			</td>
		</tr>
		<tr>
			<th scope="row">Aquiring Bank:</th>
			<td>
				<select name="items[iveri_default_bank]">
					<?php echo $banks_content; ?>
				</select>
 					(The aquiring banks to be used to process the payments - determines which currency is to be used by default)
 			</td>
		</tr>
		<!-- 
		<tr>
			<th scope="row">iVeri API Gateway URL:</th>
			<td>
				<input type="text" name="items[iveri_url]" value="<?php echo (!empty($items['iveri_url'])) ? $items['iveri_url'] : "https://backoffice.iveri.co.za/Lite/Transactions/New/Authorise.aspx"; ?>" size="40" /> (The full url to iveri's payment gateway url)
			</td>
		</tr>
		-->		
		<tr>
			<th scope="row">Invoice Prefix (max 6 characters):</th>
			<td>
				<input type="text" name="items[iveri_invoice_prefix]" value="<?php echo $items["iveri_invoice_prefix"]; ?>" size="40" /> (Specify the auto invoice prefix : eg "INV" - will create "INV0012")
			</td>
		</tr>
		<!-- 		
		<tr>
			<th scope="row">Currency to be used:</th>
			<td>
				<select name="items[iveri_default_currency]">
					<?php //echo $currency_content; ?>
				</select>
 					(The default currency to be used for an item - can be overwritten)
			</td>
		</tr>
		-->
		<tr>
			<th scope="row">Default Item Price:</th>
			<td>
				<input type="text" name="items[iveri_default_price]" value="<?php echo $items["iveri_default_price"]; ?>" size="40" /> (The default price to be used for newly added buy now buttons - can be overwritten)
			</td>
		</tr>
		<tr>
			<th scope="row">Default Item Title:</th>
			<td>
				<input type="text" name="items[iveri_default_title]" value="<?php echo $items["iveri_default_title"]; ?>" size="40" /> (The default title to be used for newly added buy now buttons - can be overwritten)
			</td>
		</tr>
		<tr>
			<th scope="row">Default Button:</th>
			<td>
				<input type="text" name="items[iveri_button]" value="<?php echo $items["iveri_button"]; ?>" size="40" /> (Enter the full url to a custom "buy now" button, or leave blank to use the default)
			</td>
		</tr>
		<tr>
			<th scope="row">Transaction Return Slug:</th>
			<td>
				<input type="text" name="items[iveri_transaction_slug]" value="<?php echo $items["iveri_transaction_slug"]; ?>" size="40" /> (Enter the slug name of the transaction's return URL, eg. "payment-result")
			</td>
		</tr>
		<tr>
			<th scope="row">iVeri Text Colour:</th>
			<td>
				<input type="text" name="items[iveri_textcolor]" value="<?php echo $items["iveri_textcolor"]; ?>" size="40" /> (Specify the text colour to use on any intermediary payment pages)
			</td>
		</tr>
		<tr>
			<th scope="row">iVeri Background Colour:</th>
			<td>
				<input type="text" name="items[iveri_bgcolor]" value="<?php echo $items["iveri_bgcolor"]; ?>" size="40" /> (Specify the background colour to use on any intermediary payment pages)
			</td>
		</tr>
		<!-- 
		<tr>
			<th scope="row">Capture Client's Shipping Details:</th>
			<td>
				<select name="items[iveri_ship_to]">
					<option value="1" <?php if ($items["iveri_ship_to"]) echo "selected='selected'"; ?>>Yes</option>
					<option value="0" <?php if (!$items["iveri_ship_to"]) echo "selected='selected'"; ?>>No</option>
				</select>
			</td>
		</tr>
		-->		
	</table>
		<p class="submit"><input type="submit" name="save" value="Save Changes!" /></p>
	</form>
</div>
<?php 
	endif;
	
