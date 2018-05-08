<?php 
global $user;
$term = taxonomy_term_load($row->tid);

$uid = $user->uid;
if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
}
$tid = 42;
	if(isset($_GET['tid'])){
		 $tid = $_GET['tid'];
	}
?>
<a class=" color <?php if($tid == $row->tid){?>active<?php }?>" href="/node/4175?uid=<?php echo $uid?>&tid=<?php echo $row->tid?>"><?php echo $output?></a>
<?php if($term->field_author['und'][0]['value'] == $user->uid){?> 
<span class="remove" tid="<?php echo $row->tid?>">X</span>
<?php }?>