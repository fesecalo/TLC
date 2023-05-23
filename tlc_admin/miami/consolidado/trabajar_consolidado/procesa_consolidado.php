<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$accion=$_POST['accion'];

	// cerrar valija
	if($accion==1){
		$id_consolidado=$_POST['id_consolidado'];

		$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id ORDER BY id_paquete");
		$db->execute(array(':id' => $id_consolidado));
		$sql_paquetes=$db->get_results();

		if (empty($sql_paquetes)) {
			die("No es posible cerrar un consolidado sin paquetes");
		}else{

            if (!isset($_POST['txtPesoConsolidado'])) {
				die("Ocurrio un problema con el peso del consolidado ingresado");
			}else{
				$pesoConsolidado=$_POST['txtPesoConsolidado'];
				$pesoConsolidado=floatval($pesoConsolidado)*(0.45);
			}
			
			if (!isset($_POST['txtNumeroPaquetes'])) {
				die("Ocurrio un problema con el numero de paquetes del consolidado ingresado");
			}else{
				$numeroPaquetesConsolidado=$_POST['txtNumeroPaquetes'];
			}
			

			if (!isset($_POST['txtAlto'])) {
				die("Ocurrio un problema con el alto del producto ingresado");
			}else{
				$alto=$_POST['txtAlto'];
				$alto=floatval($alto)*(2.54);
			}

			if (!isset($_POST['txtLargo'])) {
				die("Ocurrio un problema con el largo del producto ingresado");
			}else{
				$largo=$_POST['txtLargo'];
				$largo=floatval($largo)*(2.54);
			}

			if (!isset($_POST['txtAncho'])) {
				die("Ocurrio un problema con el ancho del producto ingresado");
			}else{
				$ancho=$_POST['txtAncho'];
				$ancho=floatval($ancho)*(2.54);
			}
			
			
			if (!isset($_POST['id_usuario_representante'])){
			    die("Ocurrio un problema con el usuario representante ingresado");
			}else{
				$id_usuario_representante=$_POST['id_usuario_representante'];
			}
			
			$pesoVolumen=($alto*$ancho*$largo)/6000;
			
			$db->prepare("UPDATE consolidado SET 
				status_consolidado=1,
				peso_kilos=:peso_kilos,
				numero_paquetes=:numero_paquetes,
				largo=:largo,
				ancho=:ancho,
				alto=:alto,
				peso_volumen=:pesoVolumen,
				fecha=:fecha,
				id_usuario_representante=:id_usuario_representante
				WHERE id_consolidado=:id
			");
			$db->execute(array(
				':id' => $id_consolidado,
				':numero_paquetes' => $numeroPaquetesConsolidado,
				':peso_kilos' => $pesoConsolidado,
				':largo' => $largo,
				':ancho' => $ancho,
				':alto' => $alto,
				':pesoVolumen'=>$pesoVolumen, 
				':fecha' => $fecha_actual,
				':id_usuario_representante' =>$id_usuario_representante
			));
			
			$db->prepare("SELECT * FROM consolidado WHERE id_consolidado=:id ORDER BY id_consolidado DESC LIMIT 1");
			$db->execute(array(':id' => $id_consolidado));
			$resConsolidado=$db->get_results();

			barcode($resConsolidado[0]->codigo_consolidado);

			?>
				<script>
					var id= "<?= $id_consolidado; ?>";
					var directorio= "<?= $conf['path_host_url']; ?>";

				    window.open(directorio+'/miami/etiqueta/etiqueta_consolidado_pdf.php?paquete='+id , '_blank');

				    window.location.href=directorio+'/miami/consolidado/trabajar_consolidado/consolidado.php';
			    </script>
			<?php
	    }
	}

	// editar valija
	if($accion==2){
		$id_consolidado=$_POST['id_consolidado'];

		$db->prepare("UPDATE consolidado SET status_consolidado='0' WHERE id_consolidado=:id");
		$db->execute(array(':id' => $id_consolidado));

		// fin registro tabla log
        header("location: editar_consolidado.php?id_consolidado=$id_consolidado");
	}

?>