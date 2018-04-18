<div class="exhibition-list large">
	<h2>Current</h2>

	<?php foreach ($view->result as $key => $value) {

	$node = node_load($value->nid);

	if ($node) { ?>
		<div class="row">

			<?php
			$title = $node->title;
			$date1 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value']));
			$date2 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value2']));
			$imageUri = $node->field_ex_image['und'][0]['uri'];
			$imageUrl = image_style_url('235wx145h',$imageUri );
			$strippedDescription = strip_tags($node->field_description['und'][0]['value']);
			if (strlen($strippedDescription) > 300) {
				// truncate string
				$stringCut = substr($strippedDescription, 0, 300);
				// make sure it ends in a word so assassinate doesn't become ass...
				$strippedDescription = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
			}
			$summaryText = ($node->field_description['und'][0]['summary'] != '') ? $node->field_description['und'][0]['summary'] : $strippedDescription ;
			?>

			<a class="image-link" href="<?php echo url('node/' . $node->nid) ?>"><img src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>"></a>
			<div class="info">
				<a href="<?php echo url('node/' . $node->nid) ?>"><?php echo $node->field_artist_free_text['und'][0]['value'] ?> <span class="title"><?php echo $node->title ?></span> <?php echo $date1 ?> - <?php echo $date2 ?></a>
				<div class="summary">
					<?php echo $summaryText ?>
				</div>
			</div>
		</div>
		<?php
	}
}

	?>
</div>