<!--<div class="past-exhibitions-container">-->


<?php
foreach ($view->result as $key => $value) {
	$node = node_load($value->nid);
	if ($node) { ?>
	<?php
		$title = $node->title;
		
		$imageRef = $node->field_ex_image['und'][0]['uri'];
		$thumbnailImage = file_create_url($imageRef );
		$dateString = date('d/m/Y',strtotime($node->field_exibition_date['und'][0]['value']));

		$dateString2 = '';
		
		if(count($node->field_exibition_date['und'][0]['value2']) == 1) {

			$dateString2 = date('d/m/Y',strtotime($node->field_exibition_date['und'][0]['value2']));

		}
		
		/*
		if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){
			$fileUrl = file_create_url($node->field_exhibition_pdf['und'][0]['uri']);
		}*/
		$fileUrl = url('node/'.$node->nid);

		?>
		<div class="past-exhibition">
			
			<?php //if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
				<a href="<?php echo $fileUrl ?>" target="_blank">
			<?php //} ?>
				<img src="<? echo $thumbnailImage ?>" alt="<?php echo $title ?>" width="110" height="57">
			<?php //if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
				</a>
			<?php// } ?>
			<?php if(!empty($node->field_artist_free_text['und'][0]['value'])){ ?>
			<span class="title"></span><?php echo $node->field_artist_free_text['und'][0]['value'] ?></span>
			<?php } ?>
		<?php if(!empty($node->field_exhibition_pdf['und'][0]['uri'])){ ?>
			<a href="<?php echo $fileUrl ?>" target="_blank" class="title"><?php echo $title ?></a>
			<?php }else{ ?>
			<span class="title"></span><a href="<?php echo $fileUrl ?>" target="_blank"><?php echo $title ?></a></span>
			<?php } ?>


			<span class="date"><?php echo $dateString ?><?php if(!empty($dateString2)){?> - <?php echo $dateString2 ?><?php } ?></span>
		</div>
	<?php
		}
	}
?>
<!--</div>-->