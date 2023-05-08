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
			require $conf['path_host'].'/include/include_menu_admin.php';
		}elseif($_SESSION['tipo_usuario']==3){
			require $conf['path_host'].'/include/include_menu.php';
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?>

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 

	<!--Inicio Contenido -->
	<h2>MANIFIESTOS PENDIENTES</h2>
	<?php if(empty($resVuelo)){ ?>
		<center><h2>No hay manifiestos pendientes</h2></center>
	<?php }else{ ?>
	<table>
		<tr>
			<td>N° vuelo</td>
			<td>Master</td>
			<td>Vuelo</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($resVuelo as $key => $vuelos) {  ?>
		<tr>
			<td><?php echo $vuelos->id_vuelos; ?></td>
			<td><?php echo $vuelos->codigo_vuelo; ?></td>
			<td><?php echo $vuelos->num_vuelo; ?></td>

			<?php if($vuelos->id_status_vuelo==0){ ?>
				<td><strong>Vuelo abierto</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==1){ ?>
				<td><strong>Vuelo confirmado en chile</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==2){ ?>
				<td><strong>En vuelo a Chile</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==3){ ?>
				<td><strong>Pendiente finalizar proceso</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==4){ ?>
				<td><strong>Vuelo retrasado</strong></td>
			<?php } ?>
			
			<td><a href="mostrar_archivo_manifiesto.php?vuelo=<?php echo $vuelos->id_vuelos; ?>" class="button solid-color">VER</a></td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
	<!-- Fin de contenido -->

</body>
</html>