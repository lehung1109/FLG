<?php
$query = $_GET;



foreach($query as $key => $value) {
	if ($key == 'nodeId') {
		unset($query[$key]);
	}
}

$queryString = http_build_query($query, '&');

$nodeId = $_GET['nodeId'];
$node = node_load($nodeId);
$nodeIdArray = array();



if(count($view->result)) {
	$nodeIdArray = array();
	$counter = 0;
	foreach ($view->result as $key => $value) {
		array_push($nodeIdArray,$value->nid);
		if($nodeId == $value->nid) {
			$currentKey = $counter;
		}
		$counter++;

	}
}
if($_GET['nodeId'] == 'reset'){
	$nodeId = $nodeIdArray[0];
	$currentKey = 0;
	$node = node_load($nodeId);
}




$previousIndex = (($currentKey - 1) >= 0) ? ($currentKey-1) : 0;

$nextIndex = (($currentKey + 1) <= count($nodeIdArray)) ? ($currentKey+1) : count($nodeIdArray);

$prevArgumentUrl = 'search?nodeId=' . $nodeIdArray[$previousIndex] . '&' . $queryString;
$nextArgumentUrl = 'search?nodeId=' . $nodeIdArray[$nextIndex] . '&' . $queryString;



?>
<div id="main" class="artwork search-item">
	<div id="content" class="column" role="main">

		<div class="heading">
			<?php



			$title = $node->title;
			$artistNode = node_load($node->field_artist['und'][0]['nid']);
			if(count($node->field_year)) {
				$year = format_date(strtotime($node->field_year['und'][0]['value']), 'year');
			}else {
				$year = '';
			}

			?>
			<h1><a href="/search"?>SEARCH ART</a> - <span class="title"><?php echo $node->title ?></span> <?php echo $year ?> by <a href="<?php echo url('node/' . $artistNode->nid); ?>/contemporary"><?php echo $artistNode->title ?></a></h1>
		</div>

		

<div class="right-follow">
				<?php 
				
				if(count($node->field_artist['und'])) {

						$follow = $node->field_artist['und'][0]['nid'];
					
					}
					?>	
					<div class="follow">
					
						<?php print flag_create_link('artist',$follow); ?>
					</div>
			</div>
		<div class="controls">
			<?php
				$prevClass = ($currentKey == 0) ? ' class="disabled" ' : '';
				$nextClass = ($currentKey == count($nodeIdArray)-1) ? ' class="disabled" ' : '';
			?>

			<a <?php echo $prevClass ?> href="<?php echo $prevArgumentUrl ?>">&lt;</a>
			<a <?php echo $nextClass ?> href="<?php echo $nextArgumentUrl ?>">&gt;</a>
		</div>


		<div class="art-image">

			<?php

			$detail = artDetail($node);
			$comma_separated = implode(", ", $detail);

			$artImageUri = $node->field_art_image['und'][0]['uri'];

			$imageClass = 'horizontal';
			$bigImage = image_style_url('big-image',$artImageUri );

			$width = $node->field_art_image['und'][0]['width'];
			$height = $node->field_art_image['und'][0]['height'];

			?>
			<a class="<?php echo $imageClass ?> view-full-size" target="_blank" href="<?php echo file_create_url($artImageUri); ?>" title="<?php echo $node->title; ?>" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>">
				<img src="<?php echo $bigImage?>" alt="<?php echo $node->title ?>">
			</a>

			<div class='art-detail'>
				<?php
				if(count($node->field_sale_status)){
					if($node->field_sale_status['und'][0]['tid'] == '27'){?>
						<span class='sold'>Sold</span>
						<?php }
				}
				?>
				<a class='title' href='<?php echo url('node/' . $node->nid); ?>'><?php echo $node->title; ?></a>
				<?php echo $comma_separated ?>
			</div>
			<?php

			$title = $node->title;
			$artist = $artistNode->title;
			$artUrl = url('node/' . $node->nid);
			$mailToUrl = 'mailto:info@flg.com.au?Subject=Enquiry%20about%20' . $title . '%20' . $year . '%20by%20' . $artist . '&Body=';

			$associatedExhibitionUrl = get_associatedExibitionUrl($node, $activeKey);

			?>

			<div class="search-cta">
				<a href="<?php echo $mailToUrl ?>">Enquire about this artwork</a>
				<div class="share-add">
			
			<a class="link-title share-control" >Share</a>
		
		</div>
				<?php if(!empty($associatedExhibitionUrl)) { ?>
				<a href="<?php echo $associatedExhibitionUrl ?>">View Current Exhibition</a>
				<?php } ?>
				<a href="<?php echo url('node/' . $artistNode->nid); ?>/contemporary">Link to artist profile</a>
				<?php
				if(count($node->field_art_in_situ)){
					$artInSituUri = $node->field_art_in_situ['und'][0]['uri'];
					$imageUrl = file_create_url($artInSituUri);
					?>
					<a class="art-in-situ-link" href="#">View In Situ Image<img class="hidden" src="<?php echo $imageUrl ?>" alt="Artwork In Situ" width="281" height="250"></a>
					<?php }	?>

			</div>
			<div class="share-add-wrapper">
				<div class="share">
					<div class="sharethis-wrapper"> <div class="sharethis-inline-share-buttons"></div></div>
				</div>
			</div>
			<?php if($user->uid > 0){$list = sentius_getTaxonomy();?> 
			<div class="favourite">
				<p>Add this art to folder : <select id="tid"><?php foreach($list as $row){?><option value="<?php echo $row->tid?>"><?php echo $row->taxonomy_term_data_name?></option><?php }?></select><input type="button" value="Add" id="buttonAdd" nid="<?php echo $_GET['nodeId']?>" /><p>
			</div>
		<?php }?>

		</div>

		<?php

		?>
		<?php
			$total = $view->total_rows;
			$pageNumber = (isset($_GET['page'])) ? $_GET['page'] : 0;
			$totalPages = ceil($total/55);


			$nextPage = (($pageNumber + 1) > $totalPages-1)? $totalPages : $pageNumber + 1;
			$nextClass = (($pageNumber + 1) > $totalPages-1)? 'disabled' : '';

			$prevPage = (($pageNumber - 1) < 0)? 0 : $pageNumber - 1;
			$prevClass = (($pageNumber - 1) < 0)? 'disabled' : '';

			$arr = array();
			parse_str($queryString, $arr);
			unset($arr['page']);
			$pageQueryString = http_build_query($arr, '&');

			$nextPageUrl = 'search?page=' . $nextPage . '&nodeId=reset&' . $pageQueryString;
			$prevPageUrl = 'search?page=' . $prevPage . '&nodeId=reset&' . $pageQueryString;

			$searchNodes = node_load_multiple($nodeIdArray);

		$num = 2;
		if($prevClass == 'disabled'){
			$num--;
		}
		if($nextClass == 'disabled'){
			$num--;
		}

			$searchWidth = (count($searchNodes) + $num) * 100;

		?>
		<div class="scroll-pane">
			<div class="search-items" style="width:<?php echo $searchWidth ?>px">
				<a class="previous-page page-link search-item <?php echo $prevClass ?>" href="<?php echo $prevPageUrl ?>"><span>< previous </span></a>
				<?php
				foreach($searchNodes as $searchNode) {
					$activeClass = ($searchNode->nid == $nodeId) ? ' active' : '';
					$itemUrl = 'search?nodeId=' . $searchNode->nid . '&' . $queryString;
					$imageRef = $searchNode->field_art_image['und'][0]['uri'];

					$thumbnailImage = image_style_url('search-thumb',$imageRef );
					?>
					<a href="<?php echo $itemUrl  ?>" class="search-item<?php echo $activeClass ?>">
						<img src="<?php echo $thumbnailImage ?>" alt="">
					</a>
				<?php }
				?>
				<a class="previous-page page-link search-item <?php echo $nextClass ?>" href="<?php echo $nextPageUrl ?>"><span>next ></span></a>
			</div>
		</div>




	</div>
</div>
