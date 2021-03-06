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
		<div class="header-right">
			<?php
				$block =block_load('block',5);
				$output = drupal_render(_block_get_renderable_array(_block_render_blocks(array($block))));        
				print $output;
			?>

			<div id="block-simplenews-1">
				<?php
				//$block = module_invoke('simplenews', 'block_view', '1');
				$block = module_invoke('webform', 'block_view', 'client-block-3740');
				print render($block['content']);
				?>
			</div>
		</div>
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


	<div id="main" class="contemporary">


		<div class="heading">
			<h1>CONTEMPORARY ART STOCKROOM</h1>
		</div>
		
		<div id="content" class="column">
			<?php 
			$artistNids = array();	
				
				$pastarray = get_node_past();?>
			<?php //echo '<pre>';print_r($pastarray);die;?>
			<?php if(count($pastarray) > 0) {?> 
					<?php foreach($pastarray as $row){?> 
						<?php 
							$passNode = node_load($row);
							if(count($passNode->field_artists_featured)>0){
								foreach($passNode->field_artists_featured['und'] as $artirow){
									
									$target = $artirow['target_id'];
									array_push($artistNids, $target);
								}	
							}
						?>
					<?php }?>
				<?php }?>
			
			
			<?php

			//get all exhibition artwork for the artist
			
			$contemporaryArtistsView = views_get_view('artist');
			$contemporaryArtistsView->set_display('contemporary_artists');
			$contemporaryArtistsView->execute();
			$contemporaryArt = $contemporaryArtistsView->result;
			
			
			foreach($contemporaryArt as $art) {
				$nid = $art->field_field_artist['0']['raw']['nid'];
				//echo $art->nid . ' - ' .$nid;
				//echo '<br/>';
				array_push($artistNids, $nid);
			}?>
			
			<?php 
			$artistNids = array_unique($artistNids);
			$artists = array();
			foreach($artistNids as $artistNid) {
				$artistNode = node_load($artistNid);
				$results = array();
				preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $artistNode->title, $results);
				if(empty($artistNode->nid)) continue;
				$artist = array(
					'name' => $artistNode->title,
					'nid' => $artistNode->nid,
					'field_artist_image' => $artistNode->field_artist_image,
				);
				if($artistNode->nid == 940) {
					$surname[] = $results[4];
				} else {
					$surname[] = $results[3];
				}
				array_push($artists, $artist);
			}
			array_multisort($surname,SORT_STRING,$artists);
			?>
			<div class="art-listing 132">
				<h2></h2>
				<?php
				foreach($artists as $artist) {
					
					
					
					$artistNode = node_load($artist['nid']);
					if(count($artistNode->field_contemporary_stock)>0){
									if($artistNode->field_contemporary_stock['und'][0]['value'] == 0){
										continue;
									}
								}
					
					$title = $artistNode->title;
					$imageRef = $artistNode->field_artist_image['und'][0]['uri'];
					$thumbnailImage = file_create_url($imageRef);
					if($artist['nid'] == 940) {
						$title = preg_split('/(\s)/', $title);
						$title[count($title) - 1] = '<br />'.$title[count($title) - 1];
						$title = strtoupper(implode(' ', $title));
					} else {
						$title = strtoupper(implode("</br>", preg_split('/(\s)/', $title, 2)));
					}
					if(count($artistNode->field_artist_image)>0){

					?>
					<div class="art-list">
						<a nid="<?php echo $artist['nid']?> " href="<?php echo url('node/' . $artist['nid']) ?>/contemporary">
							<img src="<?php echo $thumbnailImage ?>" alt="<?php echo $title ?>" width="110" height="57">
						</a>
						<a href="<?php echo url('node/' . $artist['nid']) ?>/contemporary" class="title"><?php echo $title ?></a>
					</div>
					<?php }
				}
				?>
				
				
				
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