<?php $nid = $output;
	$artNode = node_load($nid);
	$detail = artDetail($artNode);
?>
<?php 
$imageUrl  = '';
if(count($artNode->field_art_preview_image)){
	
	$imageUrl = image_style_url('artworks',$artNode->field_art_preview_image['und'][0]['uri'] ); 
}else {
	if(count($artNode->field_art_image)>0){
		$imageRef = $artNode->field_art_image['und'][0]['uri'];
		$imageUrl = image_style_url('artworks',$imageRef );
	}
}
$url = url('node/' . $artNode->nid);
if($clear == 'yes'){
	 $url = '#';
}?>

<?php if($imageUrl !=''){?>
	<div class="art <?php echo $artNodeId['target_id'];?> <?php echo count($artNode)?>">
		<a href="<?php echo $url; ?>/exhibition">
			<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
		</a>
	<div class='art-detail'>
		<?php $artist = node_load($artNode->field_artist['und'][0]['nid']); ?>
			<span class="artist-span" ><?php echo $artist->title; ?></span><br />
			<a class='title' href='<?php echo $url; ?>/exhibition'><?php echo $artNode->title; ?></a>
			<?php $break_separated = implode("<br /> ", $detail);?>
				<?php echo $break_separated ?>
	<?php if(count($artNode->field_sale_status)){
			if($artNode->field_sale_status['und'][0]['tid'] == '27'){?>
				<?php if($clear == ''){?><br><span class='sold'>Sold</span> <?php }?>
		<?php }
	}?>
	</div>
</div>
<?php }?>