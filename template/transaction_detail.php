<?php if (!$globals["isvalidPage"]) : ?>
<p>Sorry, but you cannot access this page directly</p>
<?php else : ?>
<table class="widefat">
	<thead>
		<tr>
			<th>Field Name</th>
			<th>Field Value</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Field Name</th>
			<th>Field Value</th>
		</tr>
	</tfoot>
	<tbody>
<?php foreach ($row as $key=>$value) : 
		if (!empty($value)):
			$key = eregi_replace("_", " ", $key);
			$key = strtolower($key);
			$key = ucwords($key);
?>
		<tr>
			<td><strong><?php echo $key; ?></strong></td>
			<td><?php echo $value; ?></td>
		</tr>	
<?php endif; endforeach; ?>
	</tbody>
</table>
<?php endif; ?>