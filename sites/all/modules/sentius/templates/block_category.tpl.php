<div class="content-wrapper">
	<div class="content-left">
		<div class="block">
			<?php
				$block = block_load('views', 'author-block');
				$block = _block_render_blocks(array($block));
				$block = _block_get_renderable_array($block);
				$output = drupal_render($block);
				print $output;
			?>
		</div>
		<div class="control">
			<p class="newFolder">New Folder</p>
			<p class="organise">Organise Folders</p>
		</div>
		<div class="form">
			<?php 
			$form = drupal_get_form('sentius_category_form');
			print drupal_render($form);
			?>
		</div>
	</div>
	<div class="content-right view-my-artworks">
		<?php if(count($data)>0){

			?> 
			<?php foreach($data as $row){?> 
			<?php $nid = $row->nid;
				$artNode = node_load($nid);
				$detail = artDetail($artNode);
			?>
			<?php 
			$imageUrl  = '';
			if(count($artNode->field_art_preview_image)){
				
				$imageUrl = image_style_url('artworks',$artNode->field_art_preview_image['und'][0]['uri'] ); 
			}else {
				if(count($artNode->field_art_image)>0){
					$imageRef = $artNode->field_art_image['und'][0]['uri'];
					$imageUrl = image_style_url('artworks',$imageRef );
				}
			}
			$url = url('node/' . $artNode->nid);
			if($clear == 'yes'){
				 $url = '#';
			}?>

			<?php if($imageUrl !=''){?>
			<div class="views-row">
				<div class="art <?php echo $artNodeId['target_id'];?> <?php echo count($artNode)?>">
						<a href="<?php echo $url; ?>/exhibition">
							<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
						</a>
					<div class='art-detail'>
						<?php $artist = node_load($artNode->field_artist['und'][0]['nid']); ?>
							<span class="artist-span" ><?php echo $artist->title; ?></span><br />
							<a class='title' href='<?php echo $url; ?>/exhibition'><?php echo $artNode->title; ?></a>
							<?php $break_separated = implode("<br /> ", $detail);?>
								<?php echo $break_separated ?>
					<?php if(count($artNode->field_sale_status)){
							if($artNode->field_sale_status['und'][0]['tid'] == '27'){?>
								<?php if($clear == ''){?><br><span class='sold'>Sold</span> <?php }?>
						<?php }
					}?>
					</div>
				</div>
			</div>
			<?php }?>
			<?php }?>
		<?php }?>
	</div>
</div>