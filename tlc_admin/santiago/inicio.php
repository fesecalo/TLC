<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
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
	<?php require $conf['path_host'].'/include/include_menu_inicio.php'; ?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<center>
		<h3>Seleccione su ambiente de trabajo.</h3>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-operaciones/inicio.php" class="button solid-color-menu">SANTIAGO OPERACIONES</a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<a href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-eshopex/inicio.php" class="button solid-color-menu">SANTIAGO ESHOPEX</a>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
	</center>
<!-- Fin de contenido -->

</body>
</html>