<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

    $id_consolidado=$_GET['id_consolidado'];

    $db->prepare("SELECT codigo_consolidado, peso_kilos, numero_paquetes FROM consolidado WHERE id_consolidado=:id_consolidado limit 1");
	$db->execute(array(':id_consolidado' => $id_consolidado));
	$sql_consolidado=$db->get_results();

    echo json_encode(array('consolidado'=>$sql_consolidado[0]));
	
?>