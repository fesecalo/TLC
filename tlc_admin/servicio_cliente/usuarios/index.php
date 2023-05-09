<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
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
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<h2>Modulo Paquetes</h2>
	<center>
		<a class="button solid-color-menu" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/usuarios/crear_usuario/crear_usuario.php">CREAR USUARIO</a>
		<br><br><br><br>
		<a class="button solid-color-menu" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/usuarios/buscar_usuario/usuarios.php">BUSCAR USUARIO</a>
		<br><br><br><br>
		<a class="button solid-color-menu" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/usuarios/buscar_usuario/clientes.php">BUSCAR CLIENTE</a>
		<br><br><br><br>
	</center>
	<!-- Fin de contenido -->

</body>
</html>