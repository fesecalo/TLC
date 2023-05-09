<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['numero_cliente'];

	$id=$_GET['id_comprobante'];
	$nombre=$_GET['nombre'];
	$paquete=$_GET['paquete'];

	$db->prepare("UPDATE comprobante_compra SET eliminado=1 WHERE id_comprobante=:id");
	$db->execute(array(':id'=>$id));

	$comentario="Factura o comprobante de compra ".$nombre." eliminado";

	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=14,
		id_usuario=:usuario,
		id_lugar=1,
		visible_cliente=1,
		comentario=:comentario,
		fecha=:fecha
	");
	$db->execute(array(
		':id' => $id,
		':usuario' => $id_usu,
		':comentario' => $comentario,
		':fecha' => $fecha_actual
	));

	// fin registro tabla log
    header("location: mostrar_paquete.php?paquete=$paquete");
?>