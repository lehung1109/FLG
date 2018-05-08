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
<a class=" color <?php if($tid == $row->tid){?>active<?php }?>" ><?php echo $output?></a>
