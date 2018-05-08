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


	<div id="main" class="exhibitions">


		<div class="heading">
			<h1>Exhibitions Calendar</h1>
		</div>

		<aside class="sidebar">
			<?php include('includes/past-exhibitions-block.php'); ?>
		</aside>
		<div id="content" class="column">



			
			<?php 
			
			if((basename($_SERVER['REQUEST_URI']) != 'past-exhibitions')) {
				$year = basename($_SERVER['REQUEST_URI']);
				//$view_top->set_arguments(array($year));
			}else{
				$year = '';
			}
			
			if($year == '') { ?>
				<h2>ALL PAST EXHIBITIONS</h2>
				<?php }else { 	?>
				<h2><?php echo $year ?></h2>
				<?php
			}?>
			<?php

			// get view
			$view_top = views_get_view('exhibitions');
			$view_top->set_display('past_exhibitions');
			
			
			if((basename($_SERVER['REQUEST_URI']) != 'past-exhibitions')) {
				$year = basename($_SERVER['REQUEST_URI']);
				$view_top->set_arguments(array($year));
			}else{
				$year = '';
			}
			
			

			$view_top->execute();
			print $view_top->render();
			?>
			
			<?php

			// get view
			$view = views_get_view('past_exhibitions');
			$view->set_display('block_1');
			
			
			if((basename($_SERVER['REQUEST_URI']) != 'past-exhibitions')) {
				$year = basename($_SERVER['REQUEST_URI']);
				$view->set_arguments(array($year));
			}else{
				$year = '';
			}
			
			

			$view->execute();
			?>
			<?php print $view->render();?>
			
			
			
		</div>
	</div>
</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>

<?php print render($page['bottom']); ?>