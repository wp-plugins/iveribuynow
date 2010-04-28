jQuery(window).load(function(){	
	
    jQuery("#iveri-payment-form").live("submit", function(){
    	return iveri_validate();
    });    
    
    function iveri_validate(){
    	var valid = true;       
		var ccnum = jQuery("#iveri-cc");
		var cvv = jQuery("#iveri-cvv");
		var firstname = jQuery("#iveri-first");
		var surname = jQuery("#iveri-surname");
		var email = jQuery("#iveri-email");
		var priceInput = jQuery('#iveri-priceInput');
		
		if (priceInput.length > 0){
			if (!priceInput.val().match(/^\d{1,10}\.\d{2}$/i) && !priceInput.val().match(/^\d{1,10}$/i)){
				priceInput.next("p.error").show();
				valid = false;
			} else {
				priceInput.next("p.error").hide();
				jQuery('#iveri-order_amount').val(priceInput.val() * 100);
				jQuery('#iveri-order_lineitem_amount').val(priceInput.val() * 100);
			}
		}
		
		
        if (!ccnum.val().match(/^\d{16}$/i)){
			ccnum.next("p").addClass("error").show();
			valid = false;
		} else {
			ccnum.next("p").removeClass("error");			
		}
		
		if (!cvv.val().match(/^\d{3}$/i)){
			cvv.next("p.error").show();
			valid = false;
		} else {
			cvv.next("p.error").hide();			
		}
		
		if (firstname.val() == ""){
			firstname.next("p.error").show();			
			valid = false;
		} else {
			firstname.next("p.error").hide();					
		}
		
		if (surname.val() == ""){
			surname.next("p.error").show();
			valid = false;
		} else {
			surname.next("p.error").hide();		
		}
		
		if (email.val() == ""){
			email.next("p.error").show();
			valid = false;
		} else {
			email.next("p.error").hide();
		}

		return valid;
	}
	
});