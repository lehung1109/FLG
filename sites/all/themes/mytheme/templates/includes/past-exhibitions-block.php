
<?php
global $base_url;
$activeYear = (basename($_SERVER['REQUEST_URI']) != 'past-exhibitions') ? basename($_SERVER['REQUEST_URI']) : '';

$pastExhibitionNids = db_select('node', 'n')
	->fields('n', array('nid'))
	->fields('n', array('type'))
	//->innerJoin('field_data_field_show_as', 'oos', 'oos.revision_id = n.vid')
	->condition('n.type', 'exhibition')
	->condition('n.status', '1')
	//->condition('oos.field_show_as_tid', '35')
	->execute()
	->fetchCol(); // returns an indexed array

$sql = "SELECT node.created AS node_created, node.nid AS nid
FROM 
{node} node
INNER JOIN {field_data_field_show_as} field_data_field_show_as ON node.nid = field_data_field_show_as.entity_id AND (field_data_field_show_as.entity_type = 'node' AND field_data_field_show_as.deleted = '0')
WHERE (( (node.status = '1') AND (node.type IN  ('exhibition')) AND (field_data_field_show_as.field_show_as_tid = '34') ))
ORDER BY node_created DESC";
$query = db_query($sql);
$data = array();

foreach($query as $row){
	$data[] = $row->nid;
	
}




// Now return the node objects.
$pastExhibitionNodes = node_load_multiple($data);


$years = array();

foreach($pastExhibitionNodes as $pastExhibitionNode) {
	
	$year = date('Y',strtotime($pastExhibitionNode->field_exibition_date['und'][0]['value']));
	array_push($years, $year);
}

$pastExhibitionNids = db_select('node', 'n')
	->fields('n', array('nid'))
	->fields('n', array('type'))
	->condition('n.type', 'past_exhibition')
	->condition('n.status', '1')
	->execute()
	->fetchCol(); // returns an indexed array

// Now return the node objects.
$pastExhibitionNodes = node_load_multiple($pastExhibitionNids);


foreach($pastExhibitionNodes as $pastExhibitionNode) {
	$year = date('Y',strtotime($pastExhibitionNode->field_past_exhibition_date['und'][0]['value']));
	array_push($years, $year);
}



$years = array_unique($years);





rsort($years);


?>


<div class="past-exhibitions-block">
	<h2 <?php if($node->nid == 259){ ?> class="active"<?php } ?>><a href="<?php echo url('node/259')?>">Current Exhibitions</a></h2>
	<h2 <?php if($node->nid == 261){ ?> class="active"<?php } ?>><a href="<?php echo url('node/261')?>">Past Exhibitions</a></h2>
	<ul class="hidden-mobile">
		<?php
		foreach($years as $year) {
			?><li<?php if($year == $activeYear){ ?> class="active"<?php } ?>>
				<a href="<?php echo url('node/261') . '/' .$year?>"><?php echo $year ?></a>
			</li>
		<?php } ?>
		
		
	</ul>
</div>
<div class="past-exhibitions-block show-mobile">
	<select id="exhibitions-pass" onchange="javascript:return gotoUrlex()">
		<option value="<?php echo $base_url?>/past-exhibitions">Select Years</option>
		<?php foreach($years as $year) {?>
			<option<?php if($year == $activeYear){ ?> selected="selected" <?php } ?> value="<?php echo $base_url?>/past-exhibitions/<?php echo $year?>"><?php echo $year ?></option>
		<?php } ?>
	</select>
	
</div>

	<div id="block-simplenews-1">
	
		<?php
		//$block = module_invoke('simplenews', 'block_view', '1');
		//print $block['content'];
		$block = module_invoke('webform', 'block_view', 'client-block-3740');
		print $block['content'];
		
		?>
	</div>
