
<?php
$results = $view->result;

$artistNid = $results[0]->field_field_artist[0]['raw']['nid'];


//get all exhibition artwork for the artist
$exhibitionView = views_get_view('artist');
$exhibitionView->set_display('exhibitions');
$arguments = array($artistNid);
$exhibitionView->set_arguments($arguments);
$exhibitionView->execute();
$artworksNidsInExhibition = $exhibitionView->result;
$allExhibitionArtworks = array();
foreach($artworksNidsInExhibition as $exhibitionNids){
	$exhibitionArtworks = $exhibitionNids->field_field_art_showcase;
	foreach($exhibitionArtworks as $art) {
		array_push($allExhibitionArtworks, $art['raw']['target_id']);
	}
}


?>
<!--

<?php print_r($results) ?>

-->

<?php

foreach ($results as $key => $value) {
	$artNode = node_load($value->nid);

	//if nid is in array skip
	if(in_array($value->nid, $allExhibitionArtworks)) continue;

	if ($artNode) {
		$detail = artDetail($artNode);
		?>

	<div class="art">
		<?php

		if(count($artNode->field_art_preview_image)){
			$imageUrl = file_create_url($artNode->field_art_preview_image['und'][0]['uri']);
			$width = $artNode->field_art_preview_image['und'][0]['width'];
		}else {
			$imageRef = $artNode->field_art_image['und'][0]['uri'];
			$imageUrl = image_style_url('exhibition-fallback',$imageRef );
			$width = $artNode->field_art_image['und'][0]['width'];
		}
		$bigImageRef = $artNode->field_art_image['und'][0]['uri'];
		$bigImage = image_style_url('slideshow',$bigImageRef );
		?>
		<a href="<?php echo url('node/' . $artNode->nid); ?>/contemporary" style="width:<?php echo $width?>px">
			<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
		</a>
		<div class='art-detail' style="width:<?php echo $width?>px">

			<a class='title' href='<?php echo url('node/' . $artNode->nid); ?>/contemporary'><?php echo $artNode->title; ?></a>
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
