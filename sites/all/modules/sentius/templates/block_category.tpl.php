<?php 
	$tid = 42;
	if(isset($_GET['tid'])){
		 $tid = $_GET['tid'];
	}
	$share = 'no';
	if(isset($_GET['share'])){
		$share = $_GET['share'];
	}


	$name = taxonomy_term_load($tid)->name;
?>
<div class="content-wrapper">
	<?php if( $share == 'no'){?> 
	<div class="content-left">

		<div class="block">
			
			<?php 
			global $user;
			$uid = $user->uid;
		      if(isset($_GET['uid'])){
		        $uid = $_GET['uid'];
		      }
			print views_embed_view('author', 'block', $uid);
			?>

		</div>
		<div class="control-og">
			<?php 
			global $user;
			$uid = $user->uid;
		     if(isset($_GET['uid'])){
		        $uid = $_GET['uid'];
		      }
			print views_embed_view('author', 'block_1', $uid);
			?>
		</div>
		<?php if($user->uid == $_GET['uid']){?> 
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
		<?php }?>
		<?php 
			global $base_url;
			$urltoShare = $base_url."/share?tid=42&uid=".$uid."&share=yes";
			if(isset($_GET['tid'])){
				$urltoShare = $base_url."/share?tid=".$_GET['tid']."&share=yes";
			}
			
			?>


		<div class="sharethis-custom"> 
			<p>Share Folder</p>
			<a id="sharemail">&nbsp;</a>
			<?php
				$options = array(
				  'target_id' => 'my_printable_div',
				  'button_id' => 'pdf',
				  'value' => t('Print'),
				  'type' => 'link',

				  'custom_css' => drupal_get_path('module','sentius').'/css/print.css',
				  );
				//echo drupal_get_path('module','sentius').'/css/print.css';
				print area_print_form($options);
				?>
			<div class="result-send">
				
			</div>
		</div>
		<div class="form-sharemail">

			<div class="form-item">
				<label>E-Mail to share</label>
				<input type="text" class="form-text" required="true" id="mailsend" />
				<input type="hidden" value="<?php echo $tid?>" id="tid" />
			</div>
			<input type="button" value="Send" class="form-submit" id="mailsendSubmit" />

		</div>



	</div>
	<?php }?>
	
	<div class="content-right view-right art-<?php echo $tid?>">
		<div class="title">
			<?php echo $name ?>
		</div>
	</div>
	<div class="content-right view-my-artworks art-<?php echo $tid?>" id="my_printable_div">
			<ul id="dragthis">
					

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
			<li class="views-row favorites-<?php echo $artNode->nid?>" id="<?php echo $artNode->nid?>">
			<div class="views-row favorites-<?php echo $artNode->nid?>" id="<?php echo $artNode->nid?>">
				<div class="art <?php echo $artNodeId['target_id'];?> <?php echo count($artNode)?>">
						<a href="<?php echo $url; ?>/exhibition">
							<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
						</a>
					<div class='art-detail'>
						<?php if($user->uid == $_GET['uid']){?> <div class="heart-wrapper"><div class="heart <?php echo $classGray?>" tid="<?php echo $_GET['tid']?>"  nid="<?php echo $artNode->nid?>" title="Click to remove"></div></div><?php }?>
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
			</li>
			<?php }?>
			<?php }?>
		</ul>
		<?php }else{?>
		<script type="text/javascript">
			(jQuery)(function(){

				(jQuery)('.page-share #block-sentius-block-category .block-title').hide();
				(jQuery)('.page-share #block-sentius-block-category .view-my-artworks').html("<p>Artwork not found</p>");
			});

		</script>
	

		 <?php }?>
	</div>
</div>
