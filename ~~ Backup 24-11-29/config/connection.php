<?php
	$db_host = 'localhost';
	$db_user = 'mesy7597_purbadanarta2024';
	$db_password = 'arya2024';
	$db_database = 'mesy7597_purbadanarta';

	$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);

	if($mysqli->connect_errno){
		die($mysqli->connect_error);
	}
?>