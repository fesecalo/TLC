<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$barcode=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
	$id_usu=$_SESSION['id_usu'];
	$x=1;

	$db->prepare("SELECT 
			id_paquete,
			id_usuario,
		    tracking_garve,
		    numero_miami,
		    peso,
		    descripcion_producto
		FROM paquete 
		WHERE tracking_eu=:codigo
		ORDER BY id_paquete DESC LIMIT 1
	");
	
	$db->execute(array(':codigo' => $barcode));
	$sql_paquete=$db->get_results();

	if(empty($sql_paquete)){
		die("No existen paquetes con este codigo o ya fue procesado");
	}else{

		$id_paquete=$sql_paquete[0]->id_paquete;
		$id_usuario=$sql_paquete[0]->id_usuario;
		$tracking_garve=$sql_paquete[0]->tracking_garve;
		$numero_miami=$sql_paquete[0]->numero_miami;
		$peso=$sql_paquete[0]->peso;
		$descripcion_producto=$sql_paquete[0]->descripcion_producto;

		if($tracking_garve==''){
			$db->prepare("SELECT * FROM cargos WHERE guia=:id AND eliminado=0 ORDER BY id_cargo DESC LIMIT 1");
			$db->execute(array(':id' => $numero_miami));
			$sql_cargos=$db->get_results();
		}else{
			$db->prepare("SELECT * FROM cargos WHERE guia=:id AND eliminado=0 ORDER BY id_cargo DESC LIMIT 1");
			$db->execute(array(':id' => $tracking_garve));
			$sql_cargos=$db->get_results();
		}

		if(!empty($sql_cargos)){

			// cargos que se incluyen en el mail
			$flete=$sql_cargos[0]->flete;
			$proteccion=$sql_cargos[0]->proteccion;
			$manejo=$sql_cargos[0]->manejo;
			$aduana=$sql_cargos[0]->aduana;
			// fin cargos que se incluyen en el mail

			$db->prepare("UPDATE paquete SET status=5, en_counter=1 WHERE id_paquete=:id");
			$db->execute(array(':id' => $id_paquete));

			$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=5,
				id_usuario=:usuario,
				id_lugar=5,
				visible_cliente=1,
				fecha=:fecha
			");
			$db->execute(array(
				':id' => $id_paquete,
				':usuario' => $id_usu,
				':fecha' => $fecha_actual
			));

            header("location: counter_gs.php?id_paquete=$id_paquete");
            exit;
		}else{
			// campo en_counter sirve para determinar lo paquetes en counter que aun o se han subido los cargos
			$db->prepare("UPDATE paquete SET status=19, en_counter=1 WHERE id_paquete=:id");
			$db->execute(array(':id' => $id_paquete));

			$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=19,
				id_usuario=:usuario,
				id_lugar=4,
				visible_cliente=1,
				fecha=:fecha
			");
			$db->execute(array(
				':id' => $id_paquete,
				':usuario' => $id_usu,
				':fecha' => $fecha_actual
			));

			header("location: counter_gs.php?id_paquete=$id_paquete");
			exit;
		}
	}
?>