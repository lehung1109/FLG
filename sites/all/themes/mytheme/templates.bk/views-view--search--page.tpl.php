<?php foreach ($view->result as $key => $value) { ?>
<?php
	$node = node_load($value->nid);
	if ($node) {

		$imageRef = $node->field_art_image['und'][0]['uri'];
		$image = image_style_url('slideshow',$imageRef );
		$thumbnailImage = image_style_url('130x75',$imageRef );

		if(isset($_GET['cm-to-inch'])){
			if($_GET['cm-to-inch']){
				$cm = false;
			}else{
				$cm = true;
			}
		}else {
			$cm = true;
		}

		$detail = array();

		?>

		<a href="<?php echo url('node/' . $node->nid); ?>">

			<img src="<?php echo $thumbnailImage; ?>" alt="<?php echo $node->title ?>" width="130" height="75">
		</a>
	<?php } ?>

<?php } ?>

<?php if ($pager): ?>
<?php print $pager; ?>
<?php endif; ?>
