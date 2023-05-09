<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// $id=$_GET['id'];

	// $db->prepare("SELECT * FROM data_caja WHERE id_caja=:id ORDER BY id_caja LIMIT 1");
	// $db->execute(array(':id' => $id));
	// $resCaja=$db->get_results();

?>
<!DOCTYPE html>

<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>
	
	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<h2>Modulo Caja/ Pagos</h2>

	<center>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/realizar_pago/pago/entregar_paquete.php" title='Opcion que permite realizar pagos de paquetes despachados o entregados sin pago'>PAGO DE PAQUETES</a>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/realizar_pago/pago_sin_entrega/entregar_paquete.php" title='Opcion que permite realzar un pago sin entregar el paquete. Estos paquetes deben ser entregados con la opcion "Entregar" del modulo "Entregar Paquetes"'>PAGO SIN ENTREGA</a>
		<br><br><br><br>
	</center>
<!-- Fin de contenido -->

	<br>
	<br>
	<br>
</body>
</html>