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


	<div id="main" class="exhibitions">


		<div class="heading">

			<h1>Exhibitions Calendar</h1>
		</div>

		<aside class="sidebar">
			<?php include('includes/past-exhibitions-block.php'); ?>
		</aside>
		<div id="content" class="column">
			
			<?php

			//Current Exhibitions
			$view = views_get_view('exhibitions');
			if (!$view) {
				return;
			}

			$view->set_display('current_exhibitions');
			$view->execute();
			print $view->render();


			//Upcoming Exhibitions
			$view = views_get_view('exhibitions');
			if (!$view) {
				return;
			}

			$view->set_display('upcoming_exhibitions');
			$view->execute();

			print $view->render();

			?>
		</div>
	</div>
</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>

<?php print render($page['bottom']); ?>