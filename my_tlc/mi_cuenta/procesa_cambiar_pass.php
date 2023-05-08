<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_usu=$_SESSION['numero_cliente'];
	$contra=hash('sha256', $_POST['new']);

	$db->prepare("UPDATE gar_usuarios SET pass=:pass, cambio_pass=0 WHERE id_usuario=:id_usu");
	$db->execute(array(':pass' => $contra, ':id_usu' => $id_usu ));

	unset($_SESSION['cambio_pass']);

	session_start();
	$_SESSION['cambio_pass']=0;
	
	header("location: cambiar_contrasena.php?msg=1");
?>