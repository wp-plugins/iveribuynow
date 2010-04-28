<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<div class="item">
<h2>Payment Gateway Error</h2>
<p>
	Sorry, there seems to have been a problem processing your payment with iVeri.<br />
	If this problem persists, please contact us with the date and the time of your attempted purchase.
</p>
</div>
<?php endif;