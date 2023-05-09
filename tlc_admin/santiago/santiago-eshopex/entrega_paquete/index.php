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
    <?php 
        if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
            require $conf['path_host'].'/include/include_menu_operador_eshopex.php'; 
        }else{
            die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
        }
    ?> 
    <!--menu-->

	<!--Inicio Contenido -->
	<h2>Modulo Despacho</h2>
	<center>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-eshopex/entrega_paquete/entregar_paquete/escanear_codigo.php">ENTREGAR PAQUETE</a>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-eshopex/entrega_paquete/buscar_paquete/index.php">BUSCAR PAQUETE ENTREGADO</a>
		<br><br><br><br>
		<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-eshopex/entrega_paquete/reportes/index.php">REPORTES</a>
		<br><br><br><br>
	</center>
	<!-- Fin de contenido -->

</body>
</html>