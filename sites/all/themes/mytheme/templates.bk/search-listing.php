
<div id="main" xmlns="http://www.w3.org/1999/html">
	
	<h1 class="page__title title" id="page-title">Search</h1>
	
	<aside class="sidebars">
		<section class="region region-sidebar-first column sidebar">
			<?php if ($exposed): ?>
			<?php print $exposed; ?>
			<?php endif; ?>
		</section>
	</aside>


	<div id="content" class="column" role="main">

		<?php if(count($view->result)) {
			$nodeIdArray = array();
			foreach ($view->result as $key => $value) {
				array_push($nodeIdArray,$value->nid);
			}
			foreach ($nodeIdArray as $index => $id) {
				$argumentUrl = 'search?nodeId=' . $id . '&' . $queryString;
				$node = node_load($id);
				$imageRef = $node->field_art_image['und'][0]['uri'];
				$image = image_style_url('slideshow',$imageRef );
				$thumbnailImage = image_style_url('130x75',$imageRef );
				?>
				<a href="<?php echo $argumentUrl; ?>">
					<img src="<?php echo $thumbnailImage; ?>" alt="<?php echo $node->title ?>" width="130" height="75">
				</a>
			<?php } ?>

		<?php } ?>

		<?php if ($pager){ ?>
		<?php print $pager; ?>
		<?php } ?>

	</div>
</div>