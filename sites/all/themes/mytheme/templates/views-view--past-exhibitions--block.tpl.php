<?php
foreach ($view->result as $key => $value) {
	$node = node_load($value->nid);
	if ($node) { ?>
	<?php
		$title = $node->title;

		$imageRef = $node->field_preview_image['und'][0]['uri'];
		$thumbnailImage = file_create_url($imageRef );
		$dateString = date('d/m/Y',strtotime($node->field_past_exhibition_date['und'][0]['value']));

		$dateString2 = '';

		if(count($node->field_past_exhibition_end_date['und'][0]['value']) == 1) {

			$dateString2 = date('d/m/Y',strtotime($node->field_past_exhibition_end_date['und'][0]['value']));

		}


		if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){
			$fileUrl = file_create_url($node->field_exhibition_pdf['und'][0]['uri']);
		}

		?>
		<div class="past-exhibition">
			<?php if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
				<a href="<?php echo $fileUrl ?>" target="_blank">
			<?php } ?>
				<img src="<?php echo $thumbnailImage ?>" alt="<?php echo $title ?>" width="110" height="57">
			<?php if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
				</a>
			<?php } ?>
			<?php if(!empty($node->field_artist_free_text['und'][0]['value'])){ ?>
			<span class="title"></span><?php echo $node->field_artist_free_text['und'][0]['value'] ?></span>
			<?php } ?>
		<?php if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
			<a href="<?php echo $fileUrl ?>" target="_blank" class="title"><?php echo $title ?></a>
			<?php }else{ ?>
			<span class="title"></span><?php echo $title ?> </span>
			<?php } ?>


			<span class="date"><?php echo $dateString ?><?php if(!empty($dateString2)){?> - <?php echo $dateString2 ?><?php } ?></span>
		</div>
	<?php
		}
	}
?>