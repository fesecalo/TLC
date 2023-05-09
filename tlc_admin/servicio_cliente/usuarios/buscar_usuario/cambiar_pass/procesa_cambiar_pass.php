<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_usu=$_POST['num_cliente'];
	$contra=hash('sha256', $_POST['new']);

	$db->prepare("UPDATE gar_usuarios SET pass=:pass WHERE id_usuario=:id_usuario");
	$db->execute(array(':pass' => $contra, ':id_usuario' => $id_usu));

	header("location: cambiar_contrasena.php?msg=1&id=$id_usu");
?>