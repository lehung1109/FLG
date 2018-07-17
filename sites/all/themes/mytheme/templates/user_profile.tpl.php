<?php 
global $user;
if($user->uid != 1){
	$options = array('query' => array('uid' => $user->uid));
	drupal_goto('/dashboard',$options);
}
