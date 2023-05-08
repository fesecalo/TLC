<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';

    $id_usu=$_SESSION['numero_cliente'];

    $db->prepare("SELECT * FROM vuelos WHERE id_usuario_creacion=:id_usu AND id_status_vuelo=3 AND tipo_vuelo=1");
	$db->execute(array(':id_usu'=>$id_usu));
	$resVuelo=$db->get_results();
?>
<!DOCTYPE html>

<html lang="es">

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>

<body>
	<!-- header con css -->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_admin.php';
		}elseif($_SESSION['tipo_usuario']==3){
			require $conf['path_host'].'/include/include_menu.php';
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?>

	<!--Inicio Contenido -->
	<center>
		<br><br>
		<a href="<?php echo $conf['path_host_url'] ?>/manifiesto/manifiesto.php" class="button solid-color-menu">SUBIR MANIFIESTO</a>
		<br><br><br><br>

		<?php if(!empty($resVuelo)){ ?>
			<a href="<?php echo $conf['path_host_url'] ?>/manifiesto/vuelosPendientes.php" class="button btn-danger solid-color-menu">MANIFIESTOS PENDIENTES</a>
			<br><br><br><br>
		<?php } ?>

		
		<!-- <a href="<?php echo $conf['path_host_url'] ?>/manifiesto/inicio.php" class="button solid-color-menu">BUSCAR MANIFIESTO</a>
		<br><br><br><br> -->
		<br><br>
	</center>


</body>
</html>