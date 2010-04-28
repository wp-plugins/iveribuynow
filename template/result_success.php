<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<div class="item">
<h2>Payment Gateway Success</h2>
<p>
	Thank you, your payment has been processed successfully and a receipt has been sent to the specified email address.<br />
	Your order number is : <strong><?php echo $ordernum; ?></strong>. Please keep this number as a reference when querying your order with us.
</p>
</div>
<?php endif;