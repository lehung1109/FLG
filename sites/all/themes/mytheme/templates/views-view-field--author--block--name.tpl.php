<?php 
global $user;

$uid = $user->uid;
if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
}?>
<a href="/node/4175?uid=<?php echo $uid?>&tid=<?php echo $row->tid?>"><?php echo $output?></a>
<span class="remove" tid="<?php echo $row->tid?>">X</span>