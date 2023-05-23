<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$accion=$_GET['accion'];

	// eliminar paquete
	$id_paquete=$_GET['id_paquete'];
	$id_consolidado=$_GET['id_consolidado'];

	$db->prepare("UPDATE paquete SET id_consolidado=0 where id_paquete=:id");
	$db->execute(array(':id' => $id_paquete));

	$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
	$db->execute(array(':id_consolidado' => $id_consolidado));
	$sql_paquete_consolidado=$db->get_results();

	$numero_paquetes=count($sql_paquete_consolidado);

	foreach ($sql_paquete_consolidado as $key => $paquete) {
		$peso_consolidado=$peso_valija+$paquete->peso;
	}

	$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
	$db->execute(array(':kilos' => $peso_consolidado, ':numero' =>$numero_paquetes, ':id' => $id_consolidado));

	// fin registro tabla log
    header("location:trabajar_consolidado.php?id_cons=$id_consolidado");
?>