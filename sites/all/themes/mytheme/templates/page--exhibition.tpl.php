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


	<div id="main" class="exhibition">
		<div id="content" role="main">

			<div class="heading">
				<?php
				$title = $node->title;
				$date1 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value']));
				$date2 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value2']));
				?>
				<h1><a href="<?php echo url('node/259')?>">Exhibitions</a> <?php echo $node->field_artist_free_text['und'][0]['value'] ?><span class="title"><?php echo $node->title ?></span> <?php echo $date1 ?> - <?php echo $date2 ?></h1>
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


				<div class="description">
					<?php
					$description = $node->field_description['und'][0]['value'];
					echo $description;
					?>
				</div>
				<?php


				if(count($node->field_artists_featured['und'])) {
					
				?>
					<div class="artists" >
						<?php
						$artistsNodeIdArray = $node->field_artists_featured['und'];

						foreach($artistsNodeIdArray as $artistNodeId) {
							$artistNode = node_load($artistNodeId['target_id']);

							$cvLink = file_create_url($artistNode->field_cv_resume['und'][0]['uri']);
							?>
							<div id="artistId" class="artist" artist-id="<?php echo $artistNode->nid?>">
							<a href="<?php echo url('node/' . $artistNode->nid); ?>/contemporary"><?php echo strtoupper($artistNode->title)?> PROFILE</a><br />
							<a href="<?php echo $cvLink ?>" target="_blank">DOWNLOAD BIO / CV (PDF)</a>

							</div>
							<?php
						}
						?>
					</div>
					<?php } ?>
					<div class="sharethis-wrapper"> <div class="sharethis-inline-share-buttons"></div></div>

				<div id="block-simplenews-1">
					<?php
					//$block = module_invoke('simplenews', 'block_view', '1');
					$block = module_invoke('webform', 'block_view', 'client-block-3740');
					print $block['content'];
					?>
				</div>
			</aside>
			<div class="main-content">
				<div class="art-showcase">
				<?php
				$clear = '';
				
				if($node->field_show_as['und'][0]['tid'] == '34'){
					$clear = 'yes';
					
				}
				$artShowcaseNodeIdArray = $node->field_art_showcase['und'];
				
				foreach($artShowcaseNodeIdArray as $artNodeId) {
					
					$artNode = node_load($artNodeId['target_id']);
					
					if($clear == 'yes'){
						$detail = artDetail($artNode,'',true);
					}else{
						$detail = artDetail($artNode);
					}
					
					
					?>
					<?php
						$imageUrl  = '';
						if(count($artNode->field_art_preview_image)){
							$imageUrl = file_create_url($artNode->field_art_preview_image['und'][0]['uri']);
						}else {
							if(count($artNode->field_art_image)>0){
								$imageRef = $artNode->field_art_image['und'][0]['uri'];
								$imageUrl = image_style_url('exhibition-fallback',$imageRef );
							}
						}
						//$bigImageRef = $artNode->field_art_image['und'][0]['uri'];
						//$bigImage = image_style_url('slideshow',$bigImageRef );
						
						$url = url('node/' . $artNode->nid);
								 if($clear == 'yes'){
									 $url = '#';
								 }
						
						?>
					<?php if($imageUrl !=''){?>
					<div class="art <?php echo $artNodeId['target_id'];?> <?php echo count($artNode)?>">
							<a href="<?php echo $url; ?>/exhibition">
							<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
						</a>
						 <div class='art-detail'>

							 <?php $artist = node_load($artNode->field_artist['und'][0]['nid']); ?>
							 	<span class="artist-span" ><?php echo $artist->title; ?></span><br />
							 <?php 
								 
							 ?>
							<a class='title' href='<?php echo $url; ?>/exhibition'><?php echo $artNode->title; ?></a>
							<?php
							$break_separated = implode("<br /> ", $detail);
								?>
								<?php echo $break_separated ?>
							 <?php
							 if(count($artNode->field_sale_status)){
								 if($artNode->field_sale_status['und'][0]['tid'] == '27'){?>
									 <?php if($clear == ''){?><br><span class='sold'>Sold</span> <?php }?>
									 <?php }
							 }
							 ?>

		                  </div>
						</div>
						<?php }?>
					<?php
				}
				?>
				</div>
			</div>
			<?php if(count($node->field_extra_content)) {?>
			<div class="extra-content">
				<?php echo $node->field_extra_content['und'][0]['value']; ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>

<?php print render($page['bottom']); ?>