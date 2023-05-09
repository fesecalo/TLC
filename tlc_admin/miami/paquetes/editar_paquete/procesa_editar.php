<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['id_usu'];
	$error="";

	if(!isset($_POST['id_paquete'])) {
		die("Ocurrio un problema con el numero de paquete");
	}else{
		$id_paquete=$_POST['id_paquete'];
	}

	$db->prepare("SELECT
			usuario.id_usuario,
			paquete.tracking_garve,
			paquete.consignatario,
			paquete.currier,
			paquete.tracking_eu,
			paquete.id_proveedor,
			paquete.valor,
			paquete.descripcion_producto,
			paquete.pieza,
			paquete.peso,
			paquete.largo,
			paquete.ancho,
			paquete.alto,
			paquete.id_tipo_paquete
		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	",true);
	$db->execute(array(':id' => $id_paquete));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$consignatario_old=$paquete->consignatario;
		$currier_old=$paquete->currier;
		$tracking_usa_old=$paquete->tracking_eu;
		$valor_old=$paquete->valor;
		$producto_old=$paquete->descripcion_producto;
		$pieza_old=$paquete->pieza;
		$peso_kg_old=$paquete->peso;
		$largo_old=$paquete->largo;
		$ancho_old=$paquete->ancho;
		$alto_old=$paquete->alto;
		$id_proveedor_old=$paquete->id_proveedor;
		$tipo_paquete_old=$paquete->id_tipo_paquete;
	}

	if(isset($_POST['consignatario'])) {
		$consignatario_new=$_POST['consignatario'];

		if($consignatario_new!=$consignatario_old){
			$db->prepare("UPDATE paquete SET consignatario=:consignatario WHERE id_paquete=:paquete",true);
			$db->execute(array(':consignatario' => $consignatario_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['currier'])) {
		$currier_new=$_POST['currier'];

		if($currier_new!=$currier_old){
			$db->prepare("UPDATE paquete SET currier=:currier WHERE id_paquete=:paquete",true);
			$db->execute(array(':currier' => $currier_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['tracking_usa'])) {
		$tracking_usa_mew=$_POST['tracking_usa'];
		
		if($tracking_usa_mew!=$tracking_usa_old){
			$db->prepare("UPDATE paquete SET tracking_eu=:tracking_usa WHERE id_paquete=:paquete",true);
			$db->execute(array(':tracking_usa' => $tracking_usa_mew, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['proveedor'])) {
		$proveedor_new=$_POST['proveedor'];

		if($proveedor_new!=$id_proveedor_old){
			$db->prepare("UPDATE paquete SET id_proveedor=:proveedor WHERE id_paquete=:paquete",true);
			$db->execute(array(':proveedor' => $proveedor_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['valor'])) {
		$valor_new=$_POST['valor'];
		
		if($valor_new!=$valor_old){
			$db->prepare("UPDATE paquete SET valor=:valor WHERE id_paquete=:paquete",true);
			$db->execute(array(':valor' => $valor_new, ':paquete' => $id_paquete));
		}
	}

	if(!isset($_POST['tipo_paquete'])) {
		die("Ocurrio un problema con el tipo de paquete");
	}else{
		$tipo_paquete_new=$_POST['tipo_paquete'];

		if($tipo_paquete_new!=$tipo_paquete_old){
			$db->prepare("UPDATE paquete SET id_tipo_paquete=:tipo_paquete WHERE id_paquete=:paquete",true);
			$db->execute(array(':tipo_paquete' => $tipo_paquete_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['producto'])) {
		$producto_new=$_POST['producto'];
		
		if($producto_new!=$producto_old){
			$db->prepare("UPDATE paquete SET descripcion_producto=:producto WHERE id_paquete=:paquete",true);
			$db->execute(array(':producto' => $producto_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['numero_piezas'])) {
		$numero_piezas_new=$_POST['numero_piezas'];
		
		if($numero_piezas_new!=$pieza_old){
			$db->prepare("UPDATE paquete SET pieza=:numero_piezas WHERE id_paquete=:paquete",true);
			$db->execute(array(':numero_piezas' => $numero_piezas_new, ':paquete' => $id_paquete));
		}
	}

	if(isset($_POST['peso_kg'])) {
		$peso_lb_new=$_POST['peso_kg'];
		$peso_kg_new=floatval($peso_lb_new)*(0.45);

		if($peso_kg_new!=$peso_kg_old){
			$db->prepare("UPDATE paquete SET peso=:peso_kg WHERE id_paquete=:paquete",true);
			$db->execute(array(':peso_kg' => $peso_kg_new, ':paquete' => $id_paquete));
		}
	}

	if (isset($_POST['largo'])) {
		$largo_new=$_POST['largo'];
		$largo_new=$largo_new*2.54;
		
		if($largo_new!=$largo_old){
			$db->prepare("UPDATE paquete SET largo=:largo WHERE id_paquete=:paquete",true);
			$db->execute(array(':largo' => $largo_new, ':paquete' => $id_paquete));
		}
	}

	if (isset($_POST['ancho'])) {
		$ancho_new=$_POST['ancho'];
		$ancho_new=$ancho_new*2.54;
		
		if($ancho_new!=$ancho_old){
			$db->prepare("UPDATE paquete SET ancho=:ancho WHERE id_paquete=:paquete",true);
			$db->execute(array(':ancho' => $ancho_new, ':paquete' => $id_paquete));
		}
	}

	if (isset($_POST['alto'])) {
		$alto_new=$_POST['alto'];
		$alto_new=$alto_new*2.54;
		
		if($alto_new!=$alto_old){
			$db->prepare("UPDATE paquete SET alto=:alto WHERE id_paquete=:paquete",true);
			$db->execute(array(':alto' => $alto_new, ':paquete' => $id_paquete));
		}
	}

	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=14,
		id_usuario=:usuario,
		id_lugar= 2,
		visible_cliente=0,
		fecha=:fecha
	",true);
	$db->execute(
		array(
			':id' => $id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
	));
	// fin ingreso de datos de envio

	barcode($tracking_garve);
	
	?>
		<script>
			var id= "<?php echo $id_paquete; ?>";
			var directorio= "<?php echo $conf['path_host_url']; ?>";

		    window.location.href=directorio+'/miami/paquetes/editar_paquete/editar_paquete.php?paquete='+id;
	    </script>
	<?php
?>