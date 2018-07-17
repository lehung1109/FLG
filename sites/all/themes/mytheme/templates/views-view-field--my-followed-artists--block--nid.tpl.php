<?php 
	$node = node_load($output);
	
	$newWorks = sentius_checkNewestNode($output);
	$urlNewWorks = '#';
	$classWork = '';
	if(count($newWorks)>0){
		$urlNewWorks = url('node/'.$output);
		$check = false;
		$check = _sentius_check_access($output);
		if($check){
			$classWork = 'blue';
		}
	}

	$urlNews = "/news";
	$classNews = '';
	$newsNode = sentius_NewsNode($output);
	if(count($newsNode)>0){
		$check = false;
		$urlNews ="/news/".$newsNode[0]->nid;
		$check = _sentius_check_access($newsNode[0]->nid);
		if($check){
			$classNews = 'blue';
		}
	}


	$newEx = sentius_getExByAid($output);
	$urlnewEx = '#';
	$classEx  ='';
	if(count($newEx)>0){
		$urlnewEx = url('node/'.$newEx[0]->nid);
		$check = false;
		$check = _sentius_check_access($newEx[0]->nid);
		if($check){
			$classEx = 'blue';
		}
	}
?>
<div class="image">
	<?php $image = image_style_url('artise',$node->field_artist_image_dashboard['und'][0]['uri']);?>
	<a href="<?php echo url('node/'.$node->nid)?>"><img src="<?php echo $image?>" alt="" /></a>
</div>
<div class="content-follow">
	<h2 title="<?php echo $node->title?>"><?php echo truncate($node->title,17)?><div class="heart-wrapper"><?php print flag_create_link('artist', $node->nid); ?></div></h2>
	<ul>
		<li><a class="<?php echo $classWork?>" href="<?php echo $urlNewWorks?>">NEW WORKS</a></li>
		<li><a class="<?php echo $classNews?>" href="<?php echo $urlNews?>">NEWS!</a></li>
		<li><a class="<?php echo $classEx?>" href="<?php echo $urlnewEx?>">Exhibitions</a></li>
	</ul>
</div>