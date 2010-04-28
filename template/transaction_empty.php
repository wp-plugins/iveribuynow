<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	
	<h2>Transaction Details</h2>
	<?php $status = jtUtility::getParam($_REQUEST, "jt_status") ?>
	<ul class="subsubsub">
		<li><a href="admin.php?page=iVeriBuyNow&jt_page=transaction&jt_status=0" <?php if (!$status): ?>class="current"<?php endif; ?>>All transactions</a> |</li>
		<li><a href="admin.php?page=iVeriBuyNow&jt_page=transaction&jt_status=success" <?php if ($status == "success"): ?>class="current"<?php endif; ?>>Successful transactions</a> |</li>
		<li><a href="admin.php?page=iVeriBuyNow&jt_page=transaction&jt_status=fail" <?php if ($status == "fail"): ?>class="current"<?php endif; ?>>Failed transactions</a> |</li>
		<li><a href="admin.php?page=iVeriBuyNow&jt_page=transaction&jt_status=error" <?php if ($status == "error"): ?>class="current"<?php endif; ?>>Errors</a></li>
	</ul>
	<div class="widefat">
		<p>&nbsp;Sorry, no results were found for your search</p>
	</div>
</div>
<?php endif; ?>