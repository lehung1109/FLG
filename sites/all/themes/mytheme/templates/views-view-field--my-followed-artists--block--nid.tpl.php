<?php $node = node_load($output);

?>
<div class="image">
	<?php $image = image_style_url('small_image',$node->field_artist_image['und'][0]['uri']);?>

	<a href="<?php echo url('node/'.$node->nid)?>"><img src="<?php echo $image?>" alt="" /></a>
</div>
<div class="content-follow">
	<h2><?php echo $node->title?></h2>
	<ul>
		<li><a href="<?php echo url('node/'.$node->nid)?>">NEW WORKS</a></li>
		<li><a href="<?php echo url('node/'.$node->nid)?>">NEWS!</a></li>
		<li><a href="<?php echo url('node/'.$node->nid)?>">Exhibitions</a></li>
	</ul>
</div>