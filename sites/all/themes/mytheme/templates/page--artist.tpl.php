<?php


$artistId = $node->nid;


// get view
$view = views_get_view('artist');
$view->set_display('artist_art');
$arguments = array($artistId);
$view->set_arguments($arguments);
$view->execute();
$artistArtNodes = $view->result;



$url = $_SERVER['REQUEST_URI'];
$context = substr( $url, strrpos( $url, '/' )+1 );

$category = ($artistArtNodes[0]->_field_data['nid']['entity']->field_category['und'][0]['tid']);

if($category == 19 && $context != 'contemporary'){
 header('Location: '.$url . '/contemporary');
}

if($category == 19) {
	$context = 'contemporary';
}


?>

<!-- updated on the 11/12/2014 -->

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


	<div id="main" class="artist<?php if($context== 'contemporary'){ ?> contemporary-artist<?php } ?>" data-artist-id="<?php echo $node->nid ?>"<?php  if($context== 'contemporary'){ ?> data-contemporary="19"<?php } ?>>


		<div id="content" role="main">

			<div class="heading">
				<?php $title = $node->title; ?>
				<h1><?php if($context== 'contemporary'){ ?><a href="<?php echo url('node/267'); ?>">CONTEMPORARY ART STOCKROOM</a><?php } ?> <?php echo $node->title ?></h1>
			</div>

			<?php print render($page['highlighted']); ?>
			<?php //print $breadcrumb; ?>
			<a id="main-content"></a>
			<?php print render($tabs); ?>
			<?php print render($page['help']); ?>
			<?php if ($action_links): ?>
			<ul class="action-links"><?php print render($action_links); ?></ul>
			<?php endif; ?>

			<aside class="sidebar">
				<div class="follow">
					
					<?php print flag_create_link('artist', arg(1)); ?>
				</div>
				<div class="description">
					<?php
					$description = $node->field_about_the_artist['und'][0]['value'];

					echo $description;

					$cvLink = file_create_url($node->field_cv_resume['und'][0]['uri']);
					?>
					

					<a href="<?php echo $cvLink ?>" target="_blank">DOWNLOAD BIO / CV (PDF)</a>
				</div>
				<div class="read-more-mobile">Read More</div>

				<?php

				// get view for current exhibitions
				$view = views_get_view('exhibitions');
				$view->set_display('artist_current_exhibition');
				$arguments = array($node->nid);
				$view->set_arguments($arguments);
				$view->execute();
				print $view->render();


				// get view for upcoming exhibitions
				$view = views_get_view('exhibitions');
				$view->set_display('artist_upcoming_exhibition');
				$arguments = array($node->nid);
				$view->set_arguments($arguments);
				$view->execute();
				print $view->render();

				
				//past exhibitions attached to the node
				$pastExhibitionsNodeIdArray = $node->field_past_exhibitions['und'];

				$pastnew  = get_node_past();
				 ?>
					<div class="list">
					<h2>Past Exhibitions</h2>
					<ul>
						<?php foreach($pastnew as $row_pass){
							$node_pass = node_load($row_pass);
							$show = 'no';
							foreach($node_pass->field_artists_featured['und'] as $rowred){
								if($rowred['target_id'] == $artistId){
									$show = 'yes';
									$url = url('node/'.$row_pass);
								}
								
							}
							if($show == 'yes'){?> 
							<li><a href="<?php echo $url?>" target="_blank"><?php echo $node_pass->title ?></a></li>
						<?php } }?>

					<?php
					if(count($pastExhibitionsNodeIdArray) != 0 OR count($pastnew) != 0) { 
					foreach($pastExhibitionsNodeIdArray as $previousExhbitionsNodeId) {
						$previousExhibitionNode = node_load($previousExhbitionsNodeId['target_id']);

						$fileUrl = file_create_url($previousExhibitionNode->field_exhibition_pdf['und'][0]['uri']);
						?>
							<li><a href="<?php echo $fileUrl ?>" target="_blank"><?php echo $previousExhibitionNode->title ?></a></li>
						<?php } 
					}?>
												
					</ul>
					</div>

				<?php 	?>

				<?php
				$email = 'info@flg.com.au';
				$emailLink = 'mailto:' . $email .'?Subject=Interested%20in%20' . $node->title . '&Body=Hi%20I%20wish%20to%20join%20the%20preview%20list%20for%20' . $node->title;
				?>

				<h2><a href="<?php echo $emailLink ?>">JOIN PREVIEW LIST</a></h2>

				<?php
				// get view for upcoming exhibitions
				$view = views_get_view('artist');
				$view->set_display('press');
				$arguments = array($node->nid);
				$view->set_arguments($arguments);
				$view->execute();

				$results = $view->result;


				if(count($results)){
				?>

				<div class="media">
					<h2>Media Highlights</h2>

				<?php
					 foreach ($results as $key => $value) {
						 $node = node_load($value->nid);


						 //file_create_url
						 $imageUri = $node->field_image_press['und'][0]['uri'];
						 $imageUrl = image_style_url('press60x80',$imageUri);
						 $fileUri = $node->field_press_document['und'][0]['uri'];

						 $fileUrl = file_create_url($fileUri);
						 ?>
						<div class="item">
							<a href="<?php echo $fileUrl ?>" target="_blank">
								<img src="<?php echo $imageUrl ?>" alt="">
							</a>
						</div>
						<?php } ?>
				</div>

				<?php } ?>

				
				<div id="block-simplenews-1">
					<?php
					$block = module_invoke('simplenews', 'block_view', '1');
					print $block['content'];
					?>
				</div>


			</aside>
			<div class="main-content">
				<div class="art-showcase">
					
					<?php

					//this needs to get contemporary art that isn't currently in an exhibition

					// get view
					$view = views_get_view('artist');
					if($context== 'contemporary'){
						$view->set_display('artist_art_contemporary');
					}else{
						$view->set_display('artist_art');
					}
					//echo $artistId;
					$arguments = array($artistId);

					$view->set_arguments($arguments);
					$view->execute();
					print $view->render();

					?>
					<!-- end -->
					
					
					
					
					
					
				</div>
			</div>

		</div>
	</div>
</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>
<?php print render($page['bottom']); ?>