<?php if(count($view->result)) { ?>
<div class="list">
	<h2>Current Exhibitions</h2>
	<ul class="current-exhibitions">
	<?php
		foreach ($view->result as $key => $value) {
			$node = node_load($value->nid);
			?>
			<li><a href="<?php echo url('node/' . $node->nid); ?>"><?php echo $node->title ?></a></li>
		<?php }	?>
	</ul>
</div>

<?php } ?>