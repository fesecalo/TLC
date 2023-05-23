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
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2){
		require $conf['path_host'].'/include/include_menu_operador_externo.php'; 
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

<!--Inicio Contenido -->
	<h2>Modulo Configuración</h2>

	<center>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/proveedor.php">PROVEEDORES</a>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/tipo_paquete/tipo_paquete.php">TIPOS DE PAQUETES</a>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/hve/habilitar_ventana_emergente.php">Habilitar ventanas emergentes</a>
	</center>

<!-- Fin de contenido -->

</body>
</html>