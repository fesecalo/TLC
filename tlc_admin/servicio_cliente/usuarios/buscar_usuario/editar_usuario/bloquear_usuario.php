<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_usuario=$_GET['id'];

	$db->prepare("UPDATE gar_usuarios SET bloqueado_intentos=5 WHERE id_usuario=:id_usuario");
	$db->execute(array(':id_usuario' => $id_usuario));

	header("location: ".$conf['path_host_url']."/servicio_cliente/usuarios/buscar_usuario/editar_usuario/editar_usuario.php?id=$id_usuario");
?>