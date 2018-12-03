<?php

global $base_url;

$url = $_SERVER['REQUEST_URI'];
$context = substr( $url, strrpos( $url, '/' )+1 );
$title = $node->title;
$artistNode = node_load($node->field_artist['und'][0]['nid']);

if($context != 'exhibition' && $context != 'contemporary' && $context != 'aboriginal') {

	header('Location: '. $url . '/contemporary');
}

$currentNodeId = $node->nid;
?>

<?php
// Return all nids of nodes of type "exhibition".
$exhibitionNids = db_select('node', 'n')
	->fields('n', array('nid'))
	->fields('n', array('type'))
	->condition('n.type', 'exhibition')
	->condition('n.status', '1')
	->execute()
	->fetchCol(); // returns an indexed array

// Now return the node objects.
$exhibitionNodes = node_load_multiple($exhibitionNids);
foreach($exhibitionNodes as $exhibition) {

	//art pieces in exhibition
	$exhibitionArtPiecesNids = $exhibition->field_art_showcase['und'];
	foreach($exhibitionArtPiecesNids as $nid){

		//get the specific exhibition this art piece belongs to
		if($nid['target_id'] == $node->nid){
			$associatedExhibition = $exhibition;
		}
	}
}
//display only if there is an associated exhibition
if(isset($associatedExhibition)) {
	$associatedExhibitionArtPiecesNids = $associatedExhibition->field_art_showcase['und'];
	//remove the current artwork from the list
	$index = 0;
	$activeIndex = 0;
	foreach($associatedExhibitionArtPiecesNids as $key => $nid){
		//get the specific exhibition this art piece belongs to
		if($nid['target_id'] == $node->nid){
			$activeKey = $key;
			$activeIndex = $index;
		}

		$index++;
	}

	if($context== 'exhibition'){

		$prevNode = $associatedExhibitionArtPiecesNids[$activeIndex-1];
		$nextNode = $associatedExhibitionArtPiecesNids[$activeIndex+1];



		$prevUrl =  url('node/' . $prevNode['target_id']) . '/exhibition';
		$nextUrl = url('node/' . $nextNode['target_id']) . '/exhibition';

	}

	//fix for the admin only to ensure context remains when editing
	if(($context == 'exhibition' || $context == 'contemporary') && user_is_logged_in()) { ?>
	<script type="text/javascript">
		$ = jQuery
		$(window).ready(function(){
			$('.tabs-primary__tab-link').each(function(){
				if($(this).html() == 'Edit') {
					var href = $(this).attr('href')
					var newHref = href.replace('/edit', '/<?php echo $context ?>/edit');
					//$(this).attr('href',newHref);
				}
			})
		})

	</script>
	<?php }


	unset($associatedExhibitionArtPiecesNids[$activeKey]);

}

// get view
$view = views_get_view('artist');
$view->set_display('artist_art_contemporary');
$arguments = array($artistNode->nid);
array_push($arguments,$node->field_category['und'][0]['tid']); //category
$view->set_arguments($arguments);
$view->execute();
$activeIndex = 0;
$artNodes = $view->result;
$artNids = array();


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


foreach($artNodes as $artNode) {
	if(in_array($artNode->nid, $allExhibitionArtworks)) continue;
	array_push($artNids,array('target_id'=> $artNode->nid));
}

foreach($artNids as $index => $nid) {
	if($currentNodeId == $nid['target_id']) {
		$activeIndex = $index;
	}
}


if($context== 'contemporary' || $context== 'aboriginal'){

	$prevNode = $artNids[$activeIndex-1];
	$nextNode = $artNids[$activeIndex+1];

	$prevUrl =  url('node/' . $prevNode['target_id']) . '/' . $context;
	$nextUrl = url('node/' . $nextNode['target_id']) . '/' . $context;

}


?>
<div id="page">

<header class="header" id="header" role="banner">
	<div class="clearnew"></div>
	<?php if ($logo): ?>
	<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" /></a>
	<?php endif; ?>

	<?php if ($site_name || $site_slogan): ?>
	<div class="header__name-and-slogan" id="name-and-slogan">
		<?php if ($site_name): ?>
		<h1 class="header__site-name" id="site-name">
			<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="header__site-link" rel="home"><span><?php print $site_name; ?></span></a>
		</h1>
		<?php endif; ?>

		<?php if ($site_slogan): ?>
		<div class="header__site-slogan" id="site-slogan"><?php print $site_slogan; ?></div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php
		   $block =block_load('block',5);
		   $output = drupal_render(_block_get_renderable_array(_block_render_blocks(array($block))));        
		   print $output;
		?>
	<?php if ($secondary_menu): ?>
	<nav class="header__secondary-menu" id="secondary-menu" role="navigation">
		<?php print theme('links__system_secondary_menu', array(
		'links' => $secondary_menu,
		'attributes' => array(
			'class' => array('links', 'inline', 'clearfix'),
		),
		'heading' => array(
			'text' => $secondary_menu_heading,
			'level' => 'h2',
			'class' => array('element-invisible'),
		),
	)); ?>
	</nav>
	<?php endif; ?>

	<?php print render($page['header']); ?>

</header>


<div id="main" class="artwork">

<div id="content" role="main">


<div class="heading">
	<?php
	if(count($node->field_year)) {
		$year = format_date(strtotime($node->field_year['und'][0]['value']), 'year');
	}else {
		$year = '';
	}
	?>
	<?php if($context== 'exhibition'){

	$date1 = date('jS F Y',strtotime($associatedExhibition->field_exibition_date['und'][0]['value']));
	$date2 = date('jS F Y',strtotime($associatedExhibition->field_exibition_date['und'][0]['value2']));

	?>
	<h1><?php echo $artistNode->title ?> <a href="<?php echo url('node/' . $associatedExhibition->nid) ?>"><span class="title"><?php echo $associatedExhibition->title ?></span></a> <?php echo $date1 ?> - <?php echo $date2 ?></h1>
	<?php }else if($context== 'aboriginal'){ ?>
	<h1><a href="/aboriginal">ABORIGINAL ART STOCKROOM</a>  <?php echo $artistNode->title ?></h1>
	<?php }else if($context== 'contemporary'){ ?>
	<h1><a href="/contemporary">CONTEMPORARY ART STOCKROOM</a>  <?php echo $artistNode->title ?></h1>
	<?php }else{ ?>


	<h1><span class="title"><?php echo $node->title ?></span> <?php echo $year ?> by <a href="<?php echo url('node/' . $artistNode->nid); ?>/contemporary"><?php echo $artistNode->title ?></a></h1>

	<?php } ?>
</div>
<div class="right-follow">
				<?php 
				
				if(count($node->field_artist['und'])) {

						$follow = $node->field_artist['und'][0]['nid'];
					
					}
					?>	
					<div class="follow">
					
						<?php print flag_create_link('artist',$follow); ?>
					</div>
			</div>
<?php global $user;?>

<div class="controls">

	<?php if(isset($prevNode)) { ?>
	<a href="<?php echo $prevUrl ?>">&lt;</a>
	<?php }else{?>
	<a class="disabled" href="#">&lt;</a>
	<?php } ?>

	<?php if(isset($nextNode)) { ?>
	<a href="<?php echo $nextUrl ?>">&gt;</a>
	<?php }else{?>
	<a class="disabled" href="#">&gt;</a>
	<?php } ?>
</div>

<?php print render($page['highlighted']); ?>
<?php //print $breadcrumb; ?>
<a id="main-content"></a>
<?php print render($tabs); ?>
<?php print render($page['help']); ?>
<?php if ($action_links): ?>
<ul class="action-links"><?php print render($action_links); ?></ul>
<?php endif; ?>


<div class="art-image">

	<?php

	$detail = artDetail($node);
	$comma_separated = implode(", ", $detail);

	$artImageUri = $node->field_art_image['und'][0]['uri'];

	$imageClass = 'horizontal';
	$bigImage = image_style_url('big-image',$artImageUri );

	$bigArtImageUri = $node->field_art_in_situ_large_popup['und'][0]['uri'];

	$width = $node->field_art_image['und'][0]['width'];
	$height = $node->field_art_image['und'][0]['height'];
	$ratio = $width/$height; // 5000/1000 = 5
	$ratioStr = ($ratio > 1) ? 'landscape': 'portrait'; // > 1 = landscape, < 1 = portrait


	$orientation = $node->field_orientation['und'][0]['tid'];


	?>
	<a class="<?php echo $imageClass ?> view-full-size" target="_blank" href="<?php echo file_create_url($artImageUri); ?>" title="<?php echo $node->title; ?>" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>">
		<img src="<?php echo file_create_url($artImageUri); ?>" alt="<?php echo $node->title ?>" style="<?php

		$restrictBy = null; // We will set the instruction here for what we do

		$orientation = $node->field_orientation['und'][0]['tid'];

		switch($orientation) {
			case 17:
				$restrictBy = 'height';

				break;

			case 18:
				$restrictBy = 'height';

				break;

			case 16:
				$restrictBy = 'width';

				break;
		}

		// Scale accordingly
		switch($restrictBy) {
			case 'width':
				?> width:100%;<?php
				break;
			case 'height':
				?> width:auto; height:600px;<?php
				break;
		} ?>">
	</a>

	<div class='art-detail center-text'>
		<?php
		if(count($node->field_sale_status)){?>
			<?php if($node->field_sale_status['und'][0]['tid'] == '27'){?>
				<span class='sold'>Sold</span>
			<?php }?>
			
		<?php }?>
		
		<a class='title' href='<?php echo url('node/' . $node->nid); ?>'><?php echo $node->title; ?></a>
		<?php echo $comma_separated ?>
		

	</div>

	<?php

	$title = $node->title;
	$artist = $artistNode->title;
	$artUrl = url('node/' . $node->nid);
	$mailToUrl = 'mailto:info@flg.com.au?Subject=Enquiry%20about%20' . $title . '%20' . $year . '%20by%20' . $artist . '&Body=';
	?>

	<div class="links">
		
		<a class="link-title" href="<?php echo $mailToUrl ?>">Enquire about work</a>
		<div class="share-add">
			
			<a class="link-title share-control" >Share</a>
		
		</div>
		

		<?php if($node->field_category['und'][0]['tid'] == '24')  { ?>
		<a href="<?php echo url('node/' . $artistNode->nid); ?>" class="link-title">View artist profile</a>
		<?php }else{ ?>
		<a href="<?php echo url('node/' . $artistNode->nid); ?><?php if($context == 'exhibition' || $context == 'contemporary') {?>/contemporary<?php } ?>" class="link-title">View artist profile</a>
		<?php } ?>
		
		

		<?php if($context == 'aboriginal') {?>
		

			<?php

			 $communityTid = $node->field_community['und'][0]['tid'];
			 $taxonomy_term_url = drupal_lookup_path('alias', 'taxonomy/term/'.$communityTid);

			 ?>
			<a href="<?php echo $base_url . '/' . $taxonomy_term_url ?>" class="link-title">Back to Community</a>
		
		<?php } ?>	
	</div>
	<div class="share-add-wrapper">
		<div class="share">
			<div class="sharethis-wrapper"> <div class="sharethis-inline-share-buttons"></div></div>
		</div>
	</div>
	<?php if($user->uid > 0){$list = sentius_getTaxonomy();?> 
			<div class="favourite">
				<p>Add this art to folder : <select id="tid"><?php foreach($list as $row){?><option value="<?php echo $row->tid?>"><?php echo $row->taxonomy_term_data_name?></option><?php }?></select><input type="button" value="Add" id="buttonAdd" nid="<?php echo arg(1)?>" /><p>
			</div>
		<?php }?>
	
</div>
<?php
	
?>
<div class="art-in-situ">
	<?php
	if(count($node->field_art_in_situ)){
		$artInSituUri = $node->field_art_in_situ['und'][0]['uri'];
		$artInSituPopupUri = $node->field_art_in_situ_large_popup['und'][0]['uri'];
		$imageUrl = file_create_url($artInSituUri);
		$imagePopupUrl = file_create_url($artInSituPopupUri);


		?>
		<?php if(isset($artInSituPopupUri)){?><a href="<?php echo $imagePopupUrl ?>"class="view-full-size"><?php } ?> <img src="<?php echo $imageUrl ?>" alt="Artwork In Situ" width="281" height="250"><?php if(isset($artInSituPopupUri)){?></a><?php } ?>
		<?php }	?>
	<p>Artwork to scale in-situ on 3.7m wall</p>
</div>



<?php

// Return all nids of nodes of type "exhibition".
$exhibitionNids = db_select('node', 'n')
	->fields('n', array('nid'))
	->fields('n', array('type'))
	->condition('n.type', 'exhibition')
	->condition('n.status', '1')
	->execute()
	->fetchCol(); // returns an indexed array

// Now return the node objects.
$exhibitionNodes = node_load_multiple($exhibitionNids);
foreach($exhibitionNodes as $exhibition) {

	//art pieces in exhibition
	$exhibitionArtPiecesNids = $exhibition->field_art_showcase['und'];
	foreach($exhibitionArtPiecesNids as $nid){

		//get the specific exhibition this art piece belongs to
		if($nid['target_id'] == $node->nid){
			$associatedExhibition = $exhibition;


		}
	}
}


//display only if there is an associated exhibition
if(isset($associatedExhibition)) {
	if($context== 'exhibition'){
		?>

	<div class="exhibition-preview preview-art-container als-container als-small" data-offset="<?php echo $activeIndex ?>">
		<h3>Part of the <?php echo $associatedExhibition->title ?> Exhibition</h3>
		<a class="more" href="<?php echo  url('node/' . $associatedExhibition->nid) ?> " style="z-index:1000">More from this exhibition</a>
		<?php
		renderArtList($associatedExhibitionArtPiecesNids, null,'exhibition');
		?>
	</div>
		<?php
	}
} ?>

<?php


if(isset($artistNode->nid)){


	// get view
	$view = views_get_view('artist');
	$view->set_display('artist_art_contemporary');
	$arguments = array($artistNode->nid);
	array_push($arguments,$node->field_category['und'][0]['tid']); //category

	$view->set_arguments($arguments);
	$view->execute();

	$artNodes = $view->result;
	$artNids = array();

	//get all exhibition artwork for the artist
	$exhibitionView = views_get_view('artist');
	$exhibitionView->set_display('exhibitions');
	$arguments = array($artistNode->nid);
	$exhibitionView->set_arguments($arguments);
	$exhibitionView->execute();
	$artworksNidsInExhibition = $exhibitionView->result;
	$allExhibitionArtworks = array();
	$exhibitionWorks = array();
	$nodeexhibition = array();

	foreach($artworksNidsInExhibition as $exhibitionNids){
		$exhibitionArtworks = $exhibitionNids->field_field_art_showcase;

		$exhibitionNid = $exhibitionNids->nid;
		$nodeexhibition = node_load($exhibitionNid);
		
		foreach($exhibitionArtworks as $art) {
			array_push($allExhibitionArtworks, array('target_id' => $art['raw']['target_id']));
			array_push($exhibitionWorks, $art['raw']['target_id']);
		}
	}

	
	
	
	foreach($artNodes as $artNode) {
		if(in_array($artNode->nid, $allExhibitionArtworks)) continue;
		if($artNode->nid == $currentNodeId) continue;
		if(in_array($artNode->nid,$exhibitionWorks)) continue;
		array_push($artNids,array('target_id'=> $artNode->nid));
	}
	$sql = "SELECT node.nid AS nid, node.title AS node_title, weight_weights.weight AS weight_weights_weight, 'node' AS field_data_field_artist_node_entity_type FROM  {node} node INNER JOIN {field_data_field_contemporary_stock} field_data_field_contemporary_stock ON node.nid = field_data_field_contemporary_stock.entity_id AND (field_data_field_contemporary_stock.entity_type = 'node' AND field_data_field_contemporary_stock.deleted = '0') LEFT JOIN {field_data_field_artist} field_data_field_artist ON node.nid = field_data_field_artist.entity_id AND (field_data_field_artist.entity_type = 'node' AND field_data_field_artist.deleted = '0') LEFT JOIN {weight_weights} weight_weights ON node.nid = weight_weights.entity_id WHERE (( (field_data_field_artist.field_artist_nid = '".$artistNode->nid."' ) )AND(( (node.status = '1') AND (node.type IN  ('art')) AND (field_data_field_contemporary_stock.field_contemporary_stock_value = '1') ))) ORDER BY weight_weights_weight ASC";
	
	$query = db_query($sql);
	//echo '<pre>';
	$count = 0;
	foreach($query as $row){
		
		if(in_array($row->nid, $artNids)) continue;
		
		array_push($artNids,array('target_id'=> $row->nid));
		$count ++;
	}
	$artNids = array_reverse($artNids);
	if(count($artNids) != 0) {
		if($context== 'contemporary' || $context == 'aboriginal'){
			$artistArg = ($context == 'aboriginal') ? '' : $context;
			?>

		<div class="exhibition-preview preview-art-container als-container als-small" data-offset="<?php echo $activeIndex ?>">
			
			<h3><?php echo ucwords($context)?> pieces by <a href="<?php echo url('node/' . $artistNode->nid) ?>/<?php echo $context ?>"><?php echo $artistNode->title ?></a> in stockroom</h3>
			<a class="more" style="z-index: 100;" href="<?php echo url('node/' . $artistNode->nid) ?>/<?php echo $artistArg ?>">Go to Stockroom Page</a>


			<?php
			
			
			renderArtList($artNids, null,$context);
			?>
		</div>
			<?php  }else{ ?>
			<?php if($node->field_category['und'][0]['tid'] == '24')  { ?>
				
				
			<div class="exhibition-preview preview-art-container preview-art-full-width als-container als-full" data-offset="<?php echo $activeIndex ?>">
				<h3>Other pieces by <a href="<?php echo url('node/' . $artistNode->nid) ?>"><?php echo $artistNode->title ?></a> in stockroom</h3>
				<?php

				renderArtList($artNids, true, 'aboriginal', 6);
				?>
			</div>
				<?php }else { ?>
					
					
			<div class="exhibition-preview preview-art-container preview-art-full-width als-container als-full" data-offset="<?php echo $activeIndex ?>">
				<h3>Contemporary pieces by <a href="<?php echo url('node/' . $artistNode->nid) ?>/contemporary"><?php echo $artistNode->title ?></a> in stockroom</h3>
				<?php
				renderArtList($artNids, true, 'contemporary', 6);
				?>
			</div>

				<?php } ?>

			<?php }
	}
}

if($context== 'contemporary'){
	
	
	if(!empty($allExhibitionArtworks)) { 
		$show = true;
		if(count($nodeexhibition)>0){
			if(count($nodeexhibition->field_show_as)>0){
				if($nodeexhibition->field_show_as['und'][0]['tid'] == 34){
					$show = false;
				}
			}
			
		}
		
		if($show == true){
		?>
		
	<div class="exhibition-preview preview-art-container als-container als-small" data-offset="<?php echo $activeIndex ?>">
		<h3>Exhibition pieces by <a href="<?php echo url('node/' . $exhibitionNid) ?>"><?php echo $artistNode->title ?></a></h3>
		<?php
		renderArtList($allExhibitionArtworks, null,'exhibition');
		?>
	</div>
		<?php } } ?>
	<?php }  ?>

</div>
</div>
</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>
<?php global $user;
	if($user->uid > 0){
		$nid = arg(1);
		$check = _sentius_check_access($nid);
		if($check){
			_sentius_insert_access($nid);
		}
	}

	
?>
<?php print render($page['bottom']); ?>