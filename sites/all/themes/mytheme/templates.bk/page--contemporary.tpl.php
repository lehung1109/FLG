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

		<aside class="sidebar">
			<?php

			//current
			$view = views_get_view('exhibitions');
			if (!$view) {
				return;
			}

			$view->set_display('current_exhibitions_small');
			$view->execute();

			print $view->render();

			//upcoming

			$view = views_get_view('exhibitions');
			if (!$view) {
				return;
			}
			$view->set_display('upcoming_exhibitions_small');
			$view->execute();

			print $view->render();

			?>
		</aside>
		<div id="content" class="column">

			<?php

			//get all exhibition artwork for the artist
			$contemporaryArtistsView = views_get_view('artist');
			$contemporaryArtistsView->set_display('contemporary_artists');
			$contemporaryArtistsView->execute();
			$contemporaryArt = $contemporaryArtistsView->result;
			$artistNids = array();
			foreach($contemporaryArt as $art) {
				$nid = $art->field_field_artist['0']['raw']['nid'];
				array_push($artistNids, $nid);
			}
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
				$surname[] = $results[3];
				array_push($artists, $artist);
			}
			array_multisort($surname,SORT_STRING,$artists);

			?>

			<div class="art-listing">
				<h2></h2>
				<?php
				foreach($artists as $artist) {
					$artistNode = node_load($artist['nid']);
					$title = $artistNode->title;
					$imageRef = $artistNode->field_artist_image['und'][0]['uri'];
					$thumbnailImage = file_create_url($imageRef);
					$title = strtoupper(implode("</br>", preg_split('/(\s)/', $title, 2)));


					?>
					<div class="art-list">
						<a href="<?php echo url('node/' . $artist['nid']) ?>/contemporary">
							<img src="<? echo $thumbnailImage ?>" alt="<?php echo $title ?>" width="110" height="57">
						</a>
						<a href="<?php echo url('node/' . $artist['nid']) ?>/contemporary" class="title"><?php echo $title ?></a>
					</div>
					<?php
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