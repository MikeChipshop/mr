<?php 	
	$userloc = $_GET['loc'];
	$json_url = $keytwo;
	$json = file_get_contents($json_url);
	echo($json);
?>