<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

	// se crea el numero de tracking de garve shop
	$sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=1");

	foreach ($sql_parametro as $key => $parametro) { 
		$prefijo=$parametro->prefijo_consolidado;
		$incremento=$parametro->incremento_consolidado;
	}

	$incremento=$incremento+1;

	$numero_seguimiento=$prefijo.$incremento;

	// Actualiza el valor de incremento de la tabla parametro
	$db->prepare("UPDATE parametro SET incremento_consolidado=:incremento WHERE id_parametro=1");
	$db->execute(array(':incremento' => $incremento));
	// Fin actualizar tabla parametros

	$db->prepare("INSERT INTO consolidado SET codigo_consolidado=:codigo_consolidado, fecha=:fecha_registro, id_usuario=:usuario");
	$db->execute(array(':codigo_consolidado'=>$numero_seguimiento,':fecha_registro'=>$fecha_actual, ':usuario'=>$id_usu));

	// fin registro tabla log
    header("location: consolidado.php");
?>