<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['id_usu'];
	$total_paquetes=$_POST['total_paquetes'];
	$id_cliente=$_POST['id_cliente'];

	// actualizar id de caja cuando se implemente apertura y cierre de caja
	
	// registra la transaccion generada
	$db->prepare("INSERT INTO transaccion SET
		id_tipo_transaccion=4,
		id_caja=1,
		id_usuario=:id_usuario,
		id_cliente=:id_cliente,
		tipo=1,
		fecha=:fecha
	");

	$db->execute(array(
		':id_usuario' => $id_usu,
		':id_cliente' => $id_cliente,
		':fecha' => $fecha_actual
	));
	// fin registra la transaccion generada

	$id_transaccion=$db->lastId();

	// actualiza los paquetes con el numero de transaccion
	for ($i=1; $i <= $total_paquetes; $i++) {
		if (isset($_POST['entregar'.$i])) {

			$id_paquete=$_POST['entregar'.$i];

			// actualiza el estado del id_paquete
			$db->prepare("UPDATE paquete SET id_transaccion=:id_transaccion WHERE id_paquete=:id");
			$db->execute(array(':id' => $id_paquete,':id_transaccion' => $id_transaccion));
			// fin actualiza el estado del paquete
		}
	}
	// fin actualiza los paquetes con el numero de transaccion

	// selecciona los paquetes en la transaccion para obtener el total a pagar
	$db->prepare("SELECT 
		
		sum(cargo.total) AS subtotal,
		sum(cargo.aduana) AS total_aduana

		FROM paquete 
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo

		WHERE paquete.id_transaccion=:id_transaccion
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':id_transaccion' => $id_transaccion));
	$resSub=$db->get_results();

	$subtotal=$resSub[0]->subtotal;
	$subtotalAduana=$resSub[0]->total_aduana;
	//  fin selecciona los paquetes en la transaccion para obtener el total a pagar

	// genera el numero de recibo para la transaccion
	$sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=2");

	foreach ($sql_parametro as $key => $parametro) { 
		$prefijo=$parametro->prefijo_etiqueta;
		$incremento=$parametro->incremento_valor;
	}

	$incremento=$incremento+1;
	$numero_recibo=$prefijo.$incremento;
	// fin genera el numero de recibo para la transaccion

	// actualiza el numero de recibo en la tabla parametros
	$db->prepare("UPDATE parametro SET incremento_valor=:incremento WHERE id_parametro=2");
	$db->execute(array(':incremento' => $incremento));
	// Fin actualiza el numero de recibo en la tabla parametros

	// actualiza el numero de recibo y el total de la transaccion
	$db->prepare("UPDATE transaccion SET 
		numero_recibo=:numero_recibo, 
		total=:total,
		total_aduana=:total_aduana
		WHERE id_transaccion=:id_transaccion
	");
	$db->execute(array(
		':numero_recibo' => $numero_recibo, 
		':total' => $subtotal,
		':total_aduana' => $subtotalAduana,
		':id_transaccion' => $id_transaccion
	));
	// fin actualiza el numero de recibo y el total de la transaccion

	header("location: confirmar_entrega.php?codigo=$id_transaccion");

?>