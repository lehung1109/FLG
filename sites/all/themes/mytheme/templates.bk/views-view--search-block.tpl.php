<?php
$query = $_GET;
$singleView = false;
foreach($query as $key => $value) {
	if ($key == 'nodeId') {
		$singleView = true;
		unset($query[$key]);
	}
}

$queryString = http_build_query($query, '&');

if(!$singleView) {

	include('search-listing.php');

}else{
	include('search-item.php');
} ?>
