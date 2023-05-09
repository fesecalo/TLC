<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/EasyDB.php';
	
	$db = new EasyDB($conf['db_hostname'],$conf['db_username'],$conf['db_password'],$conf['db_name']);

?>