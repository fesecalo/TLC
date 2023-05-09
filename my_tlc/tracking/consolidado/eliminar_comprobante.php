<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['numero_cliente'];

	$id_comprobante_consolidado=$_GET['id_comprobante_consolidado'];
	$id_consolidado=$_GET['id_consolidado'];

	$db->prepare("UPDATE comprobante_consolidado SET eliminado=1 WHERE id_comprobante_consolidado=:id_comprobante_consolidado");
	$db->execute(array(':id_comprobante_consolidado'=>$id_comprobante_consolidado));

	//comentario="Factura o comprobante de compra ".$nombre." eliminado";

	// fin registro tabla log
    header("location: detalles_consolidado.php?id_consolidado=$id_consolidado");
?>