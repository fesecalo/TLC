<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];
	$id_vuelo=$_POST['vuelo_id'];
	$total_valijas=$_POST['total_valijas'];
	$n=0;

	for ($i=0; $i < $total_valijas; $i++) { 
		if(isset($_POST["valija".$i])){
			$db->prepare("UPDATE valijas SET id_vuelo=:vuelo, status_valija=2 WHERE id_valija=:id");
			$db->execute(array(':vuelo' => $id_vuelo, ':id' => $_POST["valija".$i]));

			$db->prepare("UPDATE paquete SET id_vuelo=:vuelo, status=3 WHERE id_valija=:id");
			$db->execute(array(':vuelo' => $id_vuelo, ':id' => $_POST["valija".$i]));

			$db->prepare("SELECT id_paquete FROM paquete WHERE id_valija=:id");
			$db->execute(array(':id' => $_POST["valija".$i]));
			$sql_paquete=$db->get_results();

			foreach ($sql_paquete as $key => $paquete) {
				$db->prepare("INSERT INTO status_log SET
					id_paquete=:id,
					id_tipo_status=13,
					id_usuario=:usuario,
					id_lugar=3,
					visible_cliente=0,
					fecha=:fecha
				",true);
				$db->execute(
					array(
						':id' => $paquete->id_paquete,
						':usuario' => $id_usu,
						':fecha' => $fecha_actual
				));
			}

			$n++;
		}
	}

	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo));
	$sql_vuelo=$db->get_results();

	$cantidad_valijas=$sql_vuelo[0]->cantidad_valijas;
	$cantidad_valijas=$cantidad_valijas+$n;

	// ststua vuelo 3 = a vuelo cerrado y en espera de envio a santiago
	$db->prepare("UPDATE vuelos SET cantidad_valijas=:valijas WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo, ':valijas' => $cantidad_valijas));

	header("location: ".$conf['path_host_url']."/miami/vuelos/editar_vuelo/editar_vuelo.php?vuelo=$id_vuelo");
		
?>