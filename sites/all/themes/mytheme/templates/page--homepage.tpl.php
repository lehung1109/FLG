<?php

global $base_url;

$homeNode = $node;

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


	<div id="main" class="homepage">
		<a id="main-content"></a>
		<?php print render($tabs); ?>
		<?php print render($page['help']); ?>
		<?php if ($action_links): ?>
		<ul class="action-links"><?php print render($action_links); ?></ul>
		<?php endif; ?>


		<div id="content" role="main">
			<?php print $messages; ?>
			<div class="channel-selector">
				<ul>
					<?php

					//<span class="title">Current Exhibitions</span>

					$view = views_get_view('homepage');
					$view->set_display('exhibitions');
					$view->execute();
					$results = $view->result;
					foreach ($results as $key => $value) {
						$node = node_load($value->nid);

						$imageUri = $node->field_ex_image['und'][0]['uri'];
						$imageUrl = image_style_url('homeslider900x465',$imageUri );
						$description = $node->field_description['und'][0]['value'];
						if (strlen($description) > 150) {
							// truncate string
							$stringCut = substr($description, 0, 150);
							// make sure it ends in a word so assassinate doesn't become ass...
							$description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
						}
						$title = $node->title;
						$link = url('node/' .$node->nid);

						$date1 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value']));
						$date2 = date('jS F Y',strtotime($node->field_exibition_date['und'][0]['value2']));
						?>


						<li>
							<div class="image-container">
								<span class="title">NOW EXHIBITING</span>
								<div class="text"><a href="<?php echo $link ?>"><?php echo $node->field_artist_free_text['und'][0]['value'] ?></a> <?php echo $date1 ?> - <?php echo $date2 ?></div>
								<a href="<?php echo $link ?>" class="image-link-container">
									<img src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>">
								</a>
							</div>
						</li>
						<?php


					}
					?>
				</ul>
			</div>


			<div class="modules">
				<div class="title-moble title-1" onclick="javascipt:return showBoxFron('module-3')"><h3>UPCOMING</h3></div>
				<div class="module module-3<?php if(count($homeNode->field_home_channel_selector['und']) > 1) {?> module-slideshow<?php } ?>">

					<ul>
						<?php


						foreach ($homeNode->field_home_channel_selector['und'] as $key => $value) {
							$collections = entity_load('field_collection_item', array($value['value']));
							foreach ($collections as $collectionItem) {



								$imageUri = $collectionItem->field_slide_image['und'][0]['uri'];
								$imageUrl = image_style_url('homepage300x210',$imageUri );


								$title = $collectionItem->field_title['und'][0]['value'];
								$subTitle = $collectionItem->field_subtitle['und'][0]['value'];
								$link = $collectionItem->field_link['und'][0]['url'];

								$description = $collectionItem->field_short_description['und'][0]['value'];

								?>

								<li>
									<a class="image-container" href="<?php echo $link ?>">
										<span class="title"><?php echo $title ?></span>
										<img src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>">
									</a>
									<div class="description">
										<p><?php echo $description ?></p>
									</div>

								</li>

								<?php }
						}
						?>
					</ul>
				</div>
				<div class="title-moble title-1" ><h3><a href="<?php echo $base_url?>/search">SEARCH</a></h3></div>
				
				<?php
				homepage_module($homeNode->field_module_1,'module-1');



				$view = views_get_view('homepage');
				$view->set_display('news');
				$view->execute();
				$results = $view->result;

				
				?>
				<div class="title-moble title-1" ><h3><a href="<?php echo $base_url?>/news">NEWS</a></h3></div>
				<div class="module module-2 module-slideshow">
					<ul>
						<?php

						foreach ($results as $key => $value) {
							$node = node_load($value->nid);
							$imageUri = $node->field_news_image['und'][0]['uri'];
							$imageUrl = image_style_url('homepage300x210',$imageUri );
							$description = strip_tags($node->body['und'][0]['value']);
							if (strlen($description) > 150) {
								// truncate string
								$stringCut = substr($description, 0, 150);
								// make sure it ends in a word so assassinate doesn't become ass...
								$description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
							}
							$title = $node->title;
							?>

							<li>
								<a class="image-container" href="/news">
									<span class="title">NEWS</span>
									<img src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>">
								</a>
								<div class="description">
									<?php echo $description ?>
								</div>
							</li>

							<?php } ?>
					</ul>
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


<script type="text/javascript">
	(jQuery)(function(){
		var width = (jQuery)(window).width();
		
		if(width < 1052){
			showBoxFron('module-3');		
		}
	});
	
	
	
</script>



<?php print render($page['bottom']); ?>