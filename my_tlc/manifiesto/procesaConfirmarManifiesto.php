<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';
	
	set_time_limit(0);

	$id=$_GET['id_vuelo'];
	$id_usu=$_SESSION['id_usu'];

	//vuelo confirmado en chile
	$db->prepare("UPDATE vuelos SET 
		id_status_vuelo=2, 
		fecha_salida=:fecha
		WHERE id_vuelos=:id
	");
	$db->execute(array(
		':id' => $id,
		':fecha'=>$fecha_actual
	));

	$db->prepare("SELECT * FROM manifiesto WHERE id_vuelo=:id");
	$db->execute(array(':id' => $id));
	$resManifiesto=$db->get_results();

	foreach ($resManifiesto as $key => $manifiesto) {

		// se crea el numero de tracking de garve shop
        $sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=1");

        foreach ($sql_parametro as $key => $parametro) { 
            $prefijo=$parametro->prefijo_etiqueta;
            $incremento=$parametro->incremento_valor;
        }

        $incremento=$incremento+1;
        $numero_seguimiento=$prefijo.$incremento;

        // Actualiza el valor de incremento de la tabla parametro
        $db->prepare("UPDATE parametro SET incremento_valor=:incremento WHERE id_parametro=1");
        $db->execute(array(':incremento' => $incremento));

		// Ingreso de datos a la tabla principal "envios"
        $db->prepare("INSERT INTO paquete SET 
            tracking_eu=:tracking_eu,
            consignatario=:consignatario,
            pieza=:pieza,
            peso=:peso,
            descripcion_producto=:descripcion_producto,
            valor=:valor,
            proveedor=:proveedor,
            rut=:rut,
            direccion=:direccion,
            comuna=:comuna,
            flete=:flete,
            tipo_flete=:tipo_flete,
            id_usuario=:id_usuario,
            id_vuelo=:id_vuelo,
            tracking_garve=:tracking_garve,
            fecha_registro=:fecha_registro,
            status=3
        ");
        $db->execute(array(
            ':tracking_eu'=>$manifiesto->num_guia,
            ':consignatario'=>$manifiesto->cliente,
            ':pieza'=>$manifiesto->piezas,
            ':peso'=>$manifiesto->peso,
            ':descripcion_producto'=>$manifiesto->descripcion,
            ':valor'=>$manifiesto->valor,
            ':proveedor'=>$manifiesto->proveedor,
            ':rut'=>$manifiesto->rut,
            ':direccion'=>$manifiesto->direccion,
            ':comuna'=>$manifiesto->comuna,
            ':flete'=>$manifiesto->flete,
            ':tipo_flete'=>$manifiesto->tipo_flete,
            ':id_usuario'=>$id_usu,
            ':id_vuelo'=>$id,
            ':tracking_garve'=>$numero_seguimiento,
            ':fecha_registro'=>$fecha_actual
        ));

        $idPaquete=$db->lastId();

        $db->prepare("INSERT INTO status_log SET
            id_paquete=:id,
            id_tipo_status=3,
            id_usuario=:usuario,
            id_lugar=3,
            fecha=:fecha
        ");
        $db->execute(array(
            ':id' => $idPaquete,
            ':usuario' => $id_usu,
            ':fecha' => $fecha_actual
        ));
	}

	header("location: msj_manifiesto.php");
?>