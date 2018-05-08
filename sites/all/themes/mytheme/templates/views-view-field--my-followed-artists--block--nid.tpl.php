<?php $node = node_load($output);
	
	$newEx = sentius_getExByAid($output);


	$urlnewEx = '#';
	if(count($newEx)>0)
		$urlnewEx = url('node/'.$newEx[0]->entity_id);

	$newWorks = sentius_checkNewestNode($output);
	$urlNewWorks = '#';

	if(count($newWorks)>0)
		$urlNewWorks = url('node/'.$newWorks[0]->nid);
?>
<div class="image">
	<?php $image = image_style_url('small_image',$node->field_artist_image['und'][0]['uri']);
	
	?>

	<a href="<?php echo url('node/'.$node->nid)?>"><img src="<?php echo $image?>" alt="" /></a>
</div>
<div class="content-follow">
	<h2><?php echo $node->title?><div class="heart-wrapper"><?php print flag_create_link('artist', $node->nid); ?></div></h2>
	<ul>
		<li><a href="<?php echo $urlNewWorks?>">NEW WORKS</a></li>
		<li><a href="<?php echo url('node/'.$node->nid)?>">NEWS!</a></li>
		<li><a href="<?php echo $urlnewEx?>">Exhibitions</a></li>
	</ul>
</div>