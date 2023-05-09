<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['cliente'])) {
		die("Ocurrio un problema con el numero de cliente");
	}else{
		$id_cliente=$_POST['cliente'];
	}

	if(!isset($_POST['id_paquete'])) {
		die("Ocurrio un problema con el numero de paquete");
	}else{
		$id_paquete=$_POST['id_paquete'];
	}

	if(!isset($_POST['tracking_garve'])) {
		die("Ocurrio un problema con el numero de tracking");
	}else{
		$tracking_garve=$_POST['tracking_garve'];

		$db->prepare("UPDATE paquete SET tracking_garve=:tracking_garve WHERE id_paquete=:paquete");
		$db->execute(array(':tracking_garve' => $tracking_garve, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['consignatario'])) {
		die("Ocurrio un problema con el consignatario");
	}else{
		$consignatario=$_POST['consignatario'];

		$db->prepare("UPDATE paquete SET consignatario=:consignatario WHERE id_paquete=:paquete");
		$db->execute(array(':consignatario' => $consignatario, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['currier'])) {
		die("Ocurrio un problema con la empresa de currier");
	}else{
		$currier=$_POST['currier'];

		$db->prepare("UPDATE paquete SET currier=:currier WHERE id_paquete=:paquete");
		$db->execute(array(':currier' => $currier, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['tracking_usa'])) {
		die("Ocurrio un problema con el numero de tracking de USA");
	}else{
		$tracking_usa=$_POST['tracking_usa'];

		$db->prepare("UPDATE paquete SET tracking_eu=:tracking_usa WHERE id_paquete=:paquete");
		$db->execute(array(':tracking_usa' => $tracking_usa, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['proveedor'])) {
		die("Ocurrio un problema con la tienda proveedor");
	}else{
		$proveedor=$_POST['proveedor'];

		$db->prepare("UPDATE paquete SET id_proveedor=:proveedor WHERE id_paquete=:paquete");
		$db->execute(array(':proveedor' => $proveedor, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['valor'])) {
		die("Ocurrio un problema con el valor del producto");
	}else{
		$valor=$_POST['valor'];

		$db->prepare("UPDATE paquete SET valor=:valor WHERE id_paquete=:paquete");
		$db->execute(array(':valor' => $valor, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['tipo_paquete'])) {
		die("Ocurrio un problema con el tipo de paquete");
	}else{
		$tipo_paquete=$_POST['tipo_paquete'];

		$db->prepare("UPDATE paquete SET id_tipo_paquete=:tipo_paquete WHERE id_paquete=:paquete");
		$db->execute(array(':tipo_paquete' => $tipo_paquete, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['producto'])) {
		die("Ocurrio un problema con la descripcion del producto");
	}else{
		$producto=$_POST['producto'];

		$db->prepare("UPDATE paquete SET descripcion_producto=:producto WHERE id_paquete=:paquete");
		$db->execute(array(':producto' => $producto, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['numero_piezas'])) {
		die("Ocurrio un problema con el numero de piezas");
	}else{
		$numero_piezas=$_POST['numero_piezas'];

		$db->prepare("UPDATE paquete SET pieza=:numero_piezas WHERE id_paquete=:paquete");
		$db->execute(array(':numero_piezas' => $numero_piezas, ':paquete' => $id_paquete));
	}

	if(!isset($_POST['peso_kg'])) {
		die("Ocurrio un problema con el peso del producto");
	}else{
		$peso_kg=$_POST['peso_kg'];
		$peso_kg=floatval($peso_kg)*(0.45);

		$db->prepare("UPDATE paquete SET peso=:peso_kg WHERE id_paquete=:paquete");
		$db->execute(array(':peso_kg' => $peso_kg, ':paquete' => $id_paquete));
	}

	if (!isset($_POST['largo'])) {
		die("Ocurrio un problema con el largo del producto ingresado");
	}else{
		$largo=$_POST['largo'];
		$largo=floatval($largo)*(2.54);

		$db->prepare("UPDATE paquete SET largo=:largo WHERE id_paquete=:paquete");
		$db->execute(array(':largo' => $largo, ':paquete' => $id_paquete));
	}

	if (!isset($_POST['ancho'])) {
		die("Ocurrio un problema con el ancho del producto ingresado");
	}else{
		$ancho=$_POST['ancho'];
		$ancho=floatval($ancho)*(2.54);

		$db->prepare("UPDATE paquete SET ancho=:ancho WHERE id_paquete=:paquete");
		$db->execute(array(':ancho' => $ancho, ':paquete' => $id_paquete));
	}

	if (!isset($_POST['alto'])) {
		die("Ocurrio un problema con el alto del producto ingresado");
	}else{
		$alto=$_POST['alto'];
		$alto=floatval($alto)*(2.54);

		$db->prepare("UPDATE paquete SET alto=:alto WHERE id_paquete=:paquete");
		$db->execute(array(':alto' => $alto, ':paquete' => $id_paquete));
	}

	$pesoVolumen=($alto*$ancho*$largo)/6000;

	$db->prepare("UPDATE paquete SET 
		id_usuario_miami=:usuario,
		fecha_procesado_miami=:fecha,
		peso_volumen=:pesoVolumen
		WHERE id_paquete=:paquete
	");
	$db->execute(array(
		':usuario' => $id_usu,
		':fecha' => $fecha_actual,
		':pesoVolumen' =>$pesoVolumen,
		':paquete' => $id_paquete
	));

	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=2,
		id_usuario=:usuario,
		id_lugar= 2,
		fecha=:fecha
	");
	$db->execute(
		array(
			':id' => $id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
	));
	// fin ingreso de datos de envio

	// cambia el estado del envio
		$db->prepare("UPDATE paquete SET status=2 WHERE id_paquete=:paquete");
		$db->execute(array(':paquete' => $id_paquete));
	// fin cambio estado

	barcode($tracking_garve);
	
	?>
		<script>
			var id= "<?php echo $id_paquete; ?>";
			var numero_piezas= "<?php echo $numero_piezas; ?>";
			var directorio= "<?php echo $conf['path_host_url']; ?>";
			
		    window.open(directorio+'/miami/etiqueta/etiqueta_pdf.php?paquete='+id+'&total='+numero_piezas , '_blank');

		    window.location.href=directorio+'/miami/paquetes/registrar_paquete/inicio_escanear_codigo.php';
	    </script>
	<?php

?>