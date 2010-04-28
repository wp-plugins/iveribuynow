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
	
	<table id="iveri-transaction-table" class="widefat">
		<thead>
			<tr>
				<th>Status</th>
				<th>Ref</th>
				
				<th>Item</th>
				<th>Amount</th>
				<th>Client</th>
				<th>Date Processed</th>
				<th>Functions</th>			
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Status</th>
				<th>Ref</th>
				<th>Item</th>
				<th>Amount</th>
				<th>Client</th>
				<th>Date Processed</th>
				<th>Functions</th>
			</tr>
		</tfoot>
		<tbody>
	<?php foreach ($rows as $row) : ?>
			<tr>
				<td><?php echo $row->status; ?></td>
				<td><strong><?php echo $row->autoref; ?></strong></td>				
				<td><?php echo $row->item; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><a href="mailto:<?php echo $row->customer["billing_email"]; ?>"><?php echo $row->customer["billing_title"] . " " . $row->customer["billing_name"] . " " . $row->customer["billing_surname"]; ?></a></td>
				<td><?php echo $row->date; ?></td>
				<td>
					<a href="admin-ajax.php?action=iVeriBuyNow&jt_page=transaction&jt_task=viewcustomer&jt_id=<?php echo $row->id; ?>&jt_ajax=1&width=800&height=400" class="thickbox" title="Customer Data">[ Customer Data ]</a>
					<a href="admin-ajax.php?action=iVeriBuyNow&jt_page=transaction&jt_task=view&jt_id=<?php echo $row->id; ?>&jt_ajax=1&width=800&height=400" class="thickbox" title="Raw Transaction Data">[ Raw Data ]</a>
				</td>			
			</tr>	
	<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php endif; ?>