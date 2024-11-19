<?php
	$db_host = 'sql204.infinityfree.com';
	$db_user = 'if0_34781171';
	$db_password = 'dCDszii0oqTb';
	$db_database = 'if0_34781171_bursakerja';

	$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);

	if($mysqli->connect_errno){
		die($mysqli->connect_error);
	}
?>