<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
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

	<!--<div id="navigation">

     <?php if ($main_menu): ?>
        <nav id="main-menu" role="navigation" tabindex="-1">
          <?php
		// This code snippet is hard to modify. We recommend turning off the
		// "Main menu" on your sub-theme's settings form, deleting this PHP
		// code block, and, instead, using the "Menu block" module.
		// @see https://drupal.org/project/menu_block
		print theme('links__system_main_menu', array(
			'links' => $main_menu,
			'attributes' => array(
				'class' => array('links', 'inline', 'clearfix'),
			),
			'heading' => array(
				'text' => t('Main menu'),
				'level' => 'h2',
				'class' => array('element-invisible'),
			),
		)); ?>
        </nav>
      <?php endif; ?>

      <?php //print render($page['navigation']); ?>

    </div>-->

	<div id="main">

		<?php print render($title_prefix); ?>
		<?php if ($title): ?>

		<?php

		// need a hack for the communities page since I am not touching the way this area works.
		$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);



		if($segments[1] == 'communities' && isset($segments[2])){ ?>

			<h1 class="page__title title" id="page-title"><a href="/aboriginal"><?php print $title; ?></a> <?php echo $segments[2] ?></h1>

			<?php }else{ ?>
			<h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
			<?php } ?>


		<?php endif; ?>
		<?php print render($title_suffix); ?>


		<?php
		// Render the sidebars to see if there's anything in them.
		$sidebar_first  = render($page['sidebar_first']);
		?>




		<div id="content" class="column  basic-2-col" role="main">
			<?php print render($page['highlighted']); ?>
			<?php //print $breadcrumb; ?>
			<a id="main-content"></a>

			<?php print $messages; ?>
			<?php print render($tabs); ?>
			<?php print render($page['help']); ?>
			<?php if ($action_links): ?>
			<ul class="action-links"><?php print render($action_links); ?></ul>
			<?php endif; ?>

			<div class="column first">
				<?php print $node->body['und'][0]['value'] ?>
				<?php print $sidebar_first ?>

			</div>
			<div class="column">
				<?php print $node->field_right_column['und'][0]['value'] ?>
			</div>


			<?php print $feed_icons; ?>
		</div>



	</div>



</div>
<div class="clearnew"></div>
<div class="footer-main">
	<?php print render($page['footer']); ?>
</div>
<div class="clearnew"></div>

<?php print render($page['bottom']); ?>
