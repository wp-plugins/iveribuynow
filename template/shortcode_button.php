<?php 
	$button = (!empty($item["button"])) ? "<img src='" . $item[button] . "' />" : "<img src='" . get_bloginfo("url") . "/wp-content/plugins/iVeriBuyNow/template/img/buynow.png' />";
?>
<a href="<?php bloginfo("url") ?>/wp-content/plugins/iVeriBuyNow/iVeriBuyNow.php?price=<?php echo $item["price"] ?>&title=<?php echo $item["title"]; ?>&currency=<?php echo $item["currency"] ?>&jt_ajax=1" class="thickbox"><?php echo $button; ?></a>