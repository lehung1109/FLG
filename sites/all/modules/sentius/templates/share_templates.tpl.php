<?php 
	$name = $data['name'];
	$note = $data['note'];
global $base_url;

	?>
<?php if(!empty($note)): ?>
	<p>Note: <?php echo $note; ?></p>
<?php endif; ?>
<div class="content-right view-right art-<?php echo $tid?>">
		<div class="title">
			<?php echo $name ?>
		</div>
	</div>
<?php if(count($data)>0){?> 
			<?php foreach($data as $row){?> 
			<?php $nid = $row->nid;
				$artNode = node_load($nid);
				$detail = artDetail($artNode);
				$classGray = '';
				
				

			?>
			<?php 
			$imageUrl  = '';
			if(count($artNode->field_art_preview_image)){
				
				// $imageUrl = image_style_url('artworks',$artNode->field_art_preview_image['und'][0]['uri'] ); 
				$imageUrl = file_create_url($artNode->field_art_preview_image['und'][0]['uri']);
			}else {
				if(count($artNode->field_art_image)>0){
					$imageRef = $artNode->field_art_image['und'][0]['uri'];
					// $imageUrl = image_style_url('artworks',$imageRef );
					$imageUrl = file_create_url($imageRef);
				}
			}
			$url = url('node/' . $artNode->nid);
			if($clear == 'yes'){
				 $url = '#';
			}?>

				<?php if($imageUrl !=''){?>
				<div class="views-row favorites-<?php echo $artNode->nid?>">
					<div class="art <?php echo $artNodeId['target_id'];?> <?php echo count($artNode)?>">
							
						<a href="<?php echo $base_url?><?php echo $url?>"><img style="max-width: 200px;" src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>"></a>
						
						<div class='art-detail'>
							<?php if($user->uid == $_GET['uid']){?> <div class="heart-wrapper"><div class="heart <?php echo $classGray?>" tid="<?php echo $_GET['tid']?>"  nid="<?php echo $artNode->nid?>" title="Click to remove"></div></div><?php }?>
							<?php $artist = node_load($artNode->field_artist['und'][0]['nid']); ?>
								<span class="artist-span" ><?php echo $artist->title; ?></span><br />
								<a href="<?php echo $base_url?><?php echo $url?>"><?php echo $artNode->title; ?></a>
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
		<?php } ?>