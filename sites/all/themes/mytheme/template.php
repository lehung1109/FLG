<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  STARTERKIT_preprocess_html($variables, $hook);
  STARTERKIT_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // STARTERKIT_preprocess_node_page() or STARTERKIT_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */
drupal_add_library('system', 'ui.draggable');

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
function get_node_past(){
	// SELECT * FROM {field_data_field_move_art_to_artist} 
	//$query = db_query("SELECT * FROM `{field_data_field_show_as}` WHERE `bundle` = 'exhibition' AND `field_show_as_tid` = '35' ORDER BY `entity_id` DESC");
	$query = db_query("SELECT DISTINCT (
d.`entity_id` 
)
FROM {field_data_field_show_as} g
JOIN {field_data_field_exibition_date} d ON g.`entity_id` = d.`entity_id`
WHERE g.`bundle` = 'exhibition'
AND g.`field_show_as_tid` = '34'
ORDER BY d.`field_exibition_date_value2` DESC ");
	
	$data = array();
	foreach($query as $row){
		$data[] = $row->entity_id;
	}
	
	return $data;
	
}
function get_All_art($nid){
	$node = node_load($nid);
	return $node->field_art_showcase['und'];
}


function mytheme_preprocess_page(&$variables) {
	if (!empty($variables['node'])) {
		$variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
	}
}

function mytheme_preprocess_html(&$variables) {
	$local = $_SERVER['REMOTE_ADDR']=='127.0.0.1' ? true : false;
	$variables['local'] = $local;
}

function mytheme_submit_handle_form_og($form, &$form_state) {
    
   drupal_set_message('Your folders have been updated.');
    // do code here $form_state['values'] etc...
}
function mytheme_submit_handle_form_user_pass($form, &$form_state) {
    
   //$form_state['redirect'] =  "/member-login";
    // do code here $form_state['values'] etc...
}
function mytheme_form_alter(&$form, $form_state, $form_id) {

	if($form_id == 'user_login'){
		if(current_path() == 'user'){
			drupal_goto('/member-login');
		}
	}
	// if($form_id == 'user_profile_form'){
	// 	$form['text']= array(
	// 	  '#markup' => '<p>Request new password</p>',
	// 	  '#weight' => -100
	// 	);
		//unset($form['account']['pass']);
		
	// }
	if($form_id == 'user_pass'){

		//$form['actions']['submit']['#submit'][] = 'mytheme_submit_handle_form_user_pass';
	}
	if($form_id == 'user_register_form'){
		//print_r($form);
		$form['captcha_questions_answer_given']['#weight'] = 100;
	}
	if($form_id == 'views_form_author_block_1'){
		$form['actions']['submit']['#submit'][] = 'mytheme_submit_handle_form_og';
	}

	
	if(isset($form_state['view']->name)){
		if($form_state['view']->name == 'better_search'){

			$result = array();
			$resultsHTML = '<div class="results"> <a href="#" class="close">X</a>';

			if(isset($_GET['sale_status'])){ array_push($result, taxonomy_term_load($_GET['sale_status'][0])->name); };
			if(isset($_GET['category'])){
				if(isset($_GET['category'][0])){ array_push($result, taxonomy_term_load($_GET['category'][0])->name); };
				if(isset($_GET['category'][1])){ array_push($result, taxonomy_term_load($_GET['category'][1])->name); };
			};
			if(isset($_GET['medium']) && $_GET['medium'] != 'All'){
				foreach($_GET['medium'] as $object) {
					array_push($result, taxonomy_term_load($object)->name);
				}
			};
			if(isset($_GET['genre']) && $_GET['genre'] != 'All'){

				foreach($_GET['genre'] as $object) {
					array_push($result, taxonomy_term_load($object)->name);
				}
			};
			if(isset($_GET['orientation']) && $_GET['orientation'] != 'All'){
				foreach($_GET['orientation'] as $object) {
					array_push($result, taxonomy_term_load($object)->name);
				}
			};
			if(isset($_GET['cm-to-inch'])){
				if($_GET['cm-to-inch']){
					$inches = 'Width range ';
					$inches .= $_GET['width-inches-min'] . 'inches x ';
					$inches .= $_GET['width-inches-max'] . ' inches / ';
					$inches .= 'Height range ';
					$inches .= $_GET['height-inches-min'] . 'inches x ';
					$inches .= $_GET['height-inches-max'] . ' inches';
					if($_GET['width-inches-min'] != '') {
						array_push($result, $inches);
					}
				}else{

					$cm = 'Width range ';
					$cm .= $_GET['width']['min'] . 'cm x ';
					$cm .= $_GET['width']['max'] . 'cm / ';
					$cm .= 'Height range ';
					$cm .= $_GET['height']['min'] . 'cm x ';
					$cm .= $_GET['height']['max'] . 'cm';

					if($_GET['width']['min'] != '') {
						array_push($result, $cm);
					}
				}
			}

			if(isset($_GET['art_price']) && $_GET['art_price']){
				$price = 'Price range $';
				$price .= $_GET['art_price']['min'] . ' - $';
				$price .= $_GET['art_price']['max'];

				if($_GET['art_price']['min'] != '') {
					array_push($result, $price);
				}

			}

			if(isset($_GET['artist']) && $_GET['artist'] != 'All') {
				array_push($result, node_load($_GET['artist'])->title);
			}

			$resultsHTML .= 'Your Search: <br />';
			$seperated = implode(" / ", $result);
			$resultsHTML .= $seperated;

			$resultsHTML .= '</div>';


			$form['#action'] = 'search';

			$form['medium']['#options']['All'] = t('All');
			$form['genre']['#options']['All'] = t('All');
			$form['orientation']['#options']['All'] = t('All');
			$form['artist']['#options']['All'] = t('Any');
			$form['#prefix'] = '<div class="search-form">

			<div id="block-block-2" class="block block-block contextual-links-region first odd">
			      <div class="contextual-links-wrapper contextual-links-processed"><a class="contextual-links-trigger" href="#">Configure</a><ul class="contextual-links" style="display: none;"><li class="block-configure first last"><a href="/admin/structure/block/manage/block/2/configure?destination=search%3Fsale_status%5B0%5D%3D27%26category%5B0%5D%3D19%26category%5B1%5D%3D24%26medium%3D11%26genre%3D6%26orientation%3D18%26cm-to-inch%3D0%26width-inches-min%3D3.94%26width-inches-max%3D7.87%26height-inches-min%3D7.87%26height-inches-max%3D7.87%26width%5Bmin%5D%3D10%26width%5Bmax%5D%3D20%26height%5Bmin%5D%3D20%26height%5Bmax%5D%3D20%26art_price%5Bmin%5D%3D21%26art_price%5Bmax%5D%3D10%26artist%3D46">Configure block</a></li>
			</ul></div>
			  <div class="text-black hd1">BROWSE ART WORK</div><div class="text-blue hd2">REFINE RESULTS</div>
			</div>

			';


			if(count($_GET) > 1) {
				$form['#prefix'] .= $resultsHTML;
			}

			$form['#suffix'] = '</div>';

			if(isset($_REQUEST['cm-to-inch'])){
				if($_REQUEST['cm-to-inch']) {
					$checked1 = '';
					$checked2 = 'checked';
				}else{
					$checked1 = 'checked';
					$checked2 = '';
				}
			}else{
				$checked1 = 'checked';
				$checked2 = '';
			}

			$widthMin  =  isset($_REQUEST['width-inches-min'] ) ? $_REQUEST['width-inches-min']  : '';
			$heightMin =  isset($_REQUEST['height-inches-min']) ? $_REQUEST['height-inches-min'] : '';
			$widthMax  =  isset($_REQUEST['width-inches-max'] ) ? $_REQUEST['width-inches-max']  : '';
			$heightMax =  isset($_REQUEST['height-inches-max']) ? $_REQUEST['height-inches-max'] : '';

			$form['width']['#prefix'] = '
				<div class="inputs">
					<input type="radio" name="cm-to-inch" id="cm" value="0" ' . $checked1 . '/><label for="cm">cm</label>
					<input type="radio" name="cm-to-inch" id="inch" value="1" ' . $checked2 . '/><label for="inch">inches</label>
				</div>

				<div class="inches">
					<div class="form-item form-type-textfield form-item-width-min">
					<label for="edit-width-min-inches">Width Range (inch)</label>
						<input type="text" value="'. $widthMin . '" name="width-inches-min" id="edit-width-min-inches" data-sibling-input="edit-width-min" class="input-converter inches inches-width-min" placeholder="min">
					</div>
					<div class="form-item form-type-textfield form-item-width-max">
						<input type="text" value="'. $widthMax . '" name="width-inches-max" id="edit-width-max-inches" data-sibling-input="edit-width-max" class="input-converter inches inches-width-max" placeholder="max">
					</div>
					<div class="form-item form-type-textfield form-item-height-min">
					<label for="edit-height-min-inches">Height Range (inch)</label>
						<input type="text" value="'. $heightMin . '" name="height-inches-min" id="edit-height-min-inches" data-sibling-input="edit-height-min" class="input-converter inches inches-height-min" placeholder="min">
					</div>
					<div class="form-item form-type-textfield form-item-height-max">
						<input type="text" value="'. $heightMax . '" name="height-inches-max" id="edit-height-max-inches" data-sibling-input="edit-height-max" class="input-converter inches inches-height-max" placeholder="max">
					</div>
				</div>
			';



			if (empty($_GET['sale_status']))  {
				$form_state['sale_status']['#default_value'] = '27';
			}


			$form['width']['min']['#attributes']['class'][] = 'input-converter cm ';
			$form['width']['min']['#title']= 'Width Range (cm)';
			$form['width']['min']['#attributes']['data-sibling-input'][] = 'edit-width-min-inches';
			$form['width']['min']['#attributes']['placeholder'][] = 'min';

			$form['width']['max']['#attributes']['class'][] = 'input-converter cm ';
			$form['width']['max']['#title']= '';
			$form['width']['max']['#attributes']['data-sibling-input'][] = 'edit-width-max-inches';
			$form['width']['max']['#attributes']['placeholder'][] = 'max';

			$form['height']['min']['#attributes']['class'][] = 'input-converter cm ';
			$form['height']['min']['#title']= 'Height Range (cm)';
			$form['height']['min']['#attributes']['data-sibling-input'][] = 'edit-height-min-inches';
			$form['height']['min']['#attributes']['placeholder'][] = 'min';

			$form['height']['max']['#attributes']['class'][] = 'input-converter cm ';
			$form['height']['max']['#title']= '';
			$form['height']['max']['#attributes']['data-sibling-input'][] = 'edit-height-max-inches';
			$form['height']['max']['#attributes']['placeholder'][] = 'max';


			$form['art_price']['min']['#title']= 'Price Range ($AUD)';
			$form['art_price']['max']['#title']= '';
			$form['art_price']['min']['#attributes']['placeholder'][] = 'min';
			$form['art_price']['max']['#attributes']['placeholder'][] = 'max';


//			/form-submit


		}
	}

}


function mytheme_html_head_alter(&$head_elements) {

unset($head_elements['system_meta_generator']);
foreach ($head_elements as $key => $element) {
	if (isset($element['#attributes']['rel']) && $element['#attributes']['rel'] == 'canonical') {
		unset($head_elements[$key]);
	}
	if (isset($element['#attributes']['rel']) && $element['#attributes']['rel'] == 'shortlink') {
		unset($head_elements[$key]);
	}
}
}

function renderRadios($options) {

	$html = '<div class="select-to-radio">';
	$radioId = 'radio_' . generateRandomString();
	foreach($options as $option) {

		if($option == 'All'){
			$id = 'input_' . generateRandomString();
			$html .= '<div class="form-item"><input type="radio" value="" id="' . $id  . '" name="' . $radioId . '" ><label class="option" for="' . $id. '">All</label></div>';

		}else {
			$optionArray = $option->option;
			$key = key($optionArray);
			$title = array_shift($optionArray);
			$id = 'input_' . generateRandomString();
			$html .= '<div class="form-item"><input type="radio" value="' . $key .'" id="' . $id  . '" name="' . $radioId . '" ><label class="option" for="' . $id. '">' . $title . '</label></div>';
		}

	}


	$html .= '</div>';
	return $html;
}

function generateRandomString($length = 4) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}
function getTaxaboriginal() {
	$sql = "SELECT taxonomy_term_data.tid AS tid, taxonomy_term_data.name AS taxonomy_term_data_name, taxonomy_term_data.vid AS taxonomy_term_data_vid, taxonomy_vocabulary.machine_name AS taxonomy_vocabulary_machine_name, 'taxonomy_term' AS field_data_field_community_image_taxonomy_term_entity_type
FROM 
{taxonomy_term_data} taxonomy_term_data
LEFT JOIN {taxonomy_vocabulary} taxonomy_vocabulary ON taxonomy_term_data.vid = taxonomy_vocabulary.vid
WHERE (( (taxonomy_term_data.vid IN  ('8')) ))
LIMIT 12 OFFSET 0";
	$query = db_query($sql);
	$data = array();
	foreach($query as $row){
		$data[] = $row;
		
	}
	return $data;

}


function artDetail($artNode, $cm = true,$hidePrice = false) {
	$detailArray = array();
	//year
	if(count($artNode->field_year)) {
		$year = format_date(strtotime($artNode->field_year['und'][0]['value']), 'year');
		array_push($detailArray, $year);
	}
	//medium
	$medium = $artNode->field_art_type['und'][0]['value'];
	array_push($detailArray, $medium);

	//dimensions
	$width = $artNode->field_width['und'][0]['value'];
	$height = $artNode->field_height['und'][0]['value'];
	$depth = $artNode->field_depth['und'][0]['value'];

	if($cm){
		$size =   $height . 'cm x ' . $width . 'cm';
	}else{
		//$size = round((0.393700787 * $height),2) . 'cm x ' . round((0.393700787 * $width), 2) . 'cm';
		$size =   $height . 'cm x ' . $width . 'cm';
	}
	
	if(isset($depth)) {
		$size .= ' ' . $depth;
	}
	array_push($detailArray, $size);
	if($hidePrice == false){
		//price
		if(count($artNode->field_art_price )){
			
			
			if(count($artNode->field_sale_status) == 0) {
				$price = '$' . number_format($artNode->field_art_price['und'][0]['value']) . ' AUD';
				array_push($detailArray, $price);
			}else{
				
				if($artNode->field_sale_status['und'][0]['tid'] == '27') {
					$price = 'Sold';
					array_push($detailArray, $price);
				}
				if($artNode->field_sale_status['und'][0]['tid'] == '29') {
					$price = 'NFS';
					array_push($detailArray, $price);
				}
				if($artNode->field_sale_status['und'][0]['tid'] == '28') {
					$price = 'POA';
					array_push($detailArray, $price);
				}
				if($artNode->field_sale_status['und'][0]['tid'] == '32') {
					$price = '$' . number_format($artNode->field_art_price['und'][0]['value']) . ' AUD';
					array_push($detailArray, $price);
				}	
			}	
	}
	
		
		
		
	}
	return $detailArray;
}




function renderArtList($nids, $individualGallery = false, $context = '', $minLimit = 4, $append_uri = '') {

	global $base_url;

	$randomId = 'id_' . generateRandomString();

		if(count($nids) > $minLimit) { 
			$searchWidth = (count($nids)  ) * 161;
			
		?>
		
		<div class="scroll-pane">
			<div class="search-items" style="width:<?php echo $searchWidth ?>px">
				
				<?php
					$count = 0;
				foreach($nids as $row_nid) {
					$searchNode = node_load($row_nid['target_id']);
					$activeClass = ($count == 0) ? ' active' : '';
					$itemUrl = url('node/'.$row_nid['target_id']) . '/' . $append_uri ;
					$imageRef = $searchNode->field_art_image['und'][0]['uri'];
					$imageUrl = image_style_url('art-thumbnail-slider',$imageRef);
					?>
					<a href="<?php echo $itemUrl  ?>" class="search-item<?php echo $activeClass ?>">
						<img src="<?php echo $imageUrl ?>" alt="">
					</a>
				<?php 
					$count ++;
					}?>
				
			</div>
		</div>
		
		
		<?php } else { ?>
		<ul class="list" data-id="<?php echo $randomId ?>">
			<?php
			foreach($nids as $nid){
				$artNode = node_load($nid['target_id']);
				$artImageUri = $artNode->field_art_image['und'][0]['uri'];
				$imageUrl = image_style_url('art-thumbnail-slider',$artImageUri);
				$bigImage = image_style_url('slideshow',$artImageUri );
				$detail = artDetail($artNode);
				?>

				<li class="item">
					<a class="art" href="<?php echo url('node/' . $artNode->nid) . '/' . $context . '/' . $append_uri ?>">

						<img src="<?php echo $imageUrl ?>" alt="<?php echo $artNode->title ?>">
					</a>
				</li>

				<?php } ?>
		</ul>

		<?php }
}


function get_associatedExibitionUrl($node, $activeKey){
	// Return all nids of nodes of type "exhibition".
	$exhibitionNids = db_select('node', 'n')
		->fields('n', array('nid'))
		->fields('n', array('type'))
		->condition('n.type', 'exhibition')
		->condition('n.status', '1')
		->execute()
		->fetchCol(); // returns an indexed array

	// Now return the node objects.
	$exhibitionNodes = node_load_multiple($exhibitionNids);
	foreach($exhibitionNodes as $exhibition) {

		//art pieces in exhibition
		$exhibitionArtPiecesNids = $exhibition->field_art_showcase['und'];
		foreach($exhibitionArtPiecesNids as $nid){

			//get the specific exhibition this art piece belongs to
			if($nid['target_id'] == $node->nid){
				$associatedExhibition = $exhibition;
			}
		}
	}
	//display only if there is an associated exhibition
	if(isset($associatedExhibition)) {
		$associatedExhibitionArtPiecesNids = $associatedExhibition->field_art_showcase['und'];
		//remove the current artwork from the list
		foreach($associatedExhibitionArtPiecesNids as $key => $nid){
			//get the specific exhibition this art piece belongs to
			if($nid['target_id'] == $node->nid){
				$activeKey = $key;
			}
		}
		unset($associatedExhibitionArtPiecesNids[$activeKey]);
		$associatedExhibitionUrl = url('node/' . $associatedExhibition->nid);
	}

	return $associatedExhibitionUrl;
}

function homepage_module($collection, $className) {


	foreach ($collection['und'] as $key => $value) {
		$collections = entity_load('field_collection_item', array($value['value']));
	}

	if(count($collection['und']) > 1) {
		$className .= ' module-slideshow';
	}

	?>
	<div class="module <?php echo $className ?>">
	<ul>
	<?php

	foreach ($collection['und'] as $key => $value) {
		$collections = entity_load('field_collection_item', array($value['value']));
		foreach ($collections as $collectionItem) {
			$title = $collectionItem->field_short_description['und'][0]['value'];
			$linkUrl = $collectionItem->field_link_and_title['und'][0]['url'];
			$title = $collectionItem->field_link_and_title['und'][0]['title'];
			$description = $collectionItem->field_short_description['und'][0]['value'];
			$imageUri = $collectionItem->field_slide_image['und'][0]['uri'];

			$imageUrl = image_style_url('homepage300x210',$imageUri );
			?>
			<li>
				<a class="image-container" href="<?php echo $linkUrl ?>">
					<span class="title"><?php echo $title ?></span>
					<img src="<?php echo $imageUrl ?>" alt="<?php echo $title ?>">
				</a>
				<div class="description">
					<?php echo $description ?>
				</div>


			</li>
			<?php

			//field_slide_image
			//field_link_and_title
			//field_short_description

			//homepage300x210
			?>

		<?php

		}
	}

	?>
	</ul>
	</div>
	<?php
}