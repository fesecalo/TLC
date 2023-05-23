<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>

<html lang="es">

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_inicio.php'; ?> 
<!--menu-->

<!--Inicio Contenido -->
	<center>
		<h2>Bienvenido al sistema de administración y tracking de paquetes de <?php echo $conf['path_company_name'] ?>.</h2>
		<br>
		<h3>Seleccione su ambiente de trabajo.</h3>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/miami/inicio.php" class="button solid-color-menu">ORIGEN</a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-operaciones/inicio.php" class="button solid-color-menu">DESTINO</a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/inicio.php" class="button solid-color-menu">SERVICIO AL CLIENTE</a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/procesa_my_btrace.php" class="button solid-color-menu">MY <?php echo $conf['path_company_name']; ?></a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<!-- <a href="<?php echo $conf['path_host_url'] ?>/administracion/inicio.php" class="button solid-color-menu">ADMINISTRADOR</a>
		<p>&nbsp;</p> -->
		<p>&nbsp;</p>
	</center>
<!-- Fin de contenido -->

</body>
</html>