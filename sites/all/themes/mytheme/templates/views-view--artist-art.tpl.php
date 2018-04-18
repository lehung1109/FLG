
<?php
$results = $view->result;

foreach ($results as $key => $value) {
	$artNode = node_load($value->nid);


	if ($artNode) {
		$detail = artDetail($artNode);
		?>

	<div class="art">
		<?php
		if(count($artNode->field_art_preview_image)){
			$imageUrl = file_create_url($artNode->field_art_preview_image['und'][0]['uri']);
		}else {
			$imageRef = $artNode->field_art_image['und'][0]['uri'];
			$imageUrl = image_style_url('exhibition-fallback',$imageRef );
		}
		$bigImageRef = $artNode->field_art_image['und'][0]['uri'];
		$bigImage = image_style_url('slideshow',$bigImageRef );


		?>
		<a href="<?php echo url('node/' . $artNode->nid); ?>/aboriginal">
			<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
		</a>
		<div class='art-detail'>
		
			<a class='title' href='<?php echo url('node/' . $artNode->nid); ?>/aboriginal'><?php echo $artNode->title; ?></a>
			
			
			<?php
			$break_separated = implode("<br /> ", $detail);
			?>
			<?php echo $break_separated ?>
			
			<?php
			if(count($artNode->field_sale_status)){
				if($artNode->field_sale_status['und'][0]['tid'] == '27'){?>
					<br/><span class='sold'>Sold</span>
					<?php }
			}
			?>
		</div>
	</div>
		<?php
	}
}
	?>
