<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$sql_vuelo=$db->get_results("SELECT * FROM vuelos WHERE (id_status_vuelo=2 OR id_status_vuelo=4) AND eliminado=0 ORDER BY id_vuelos DESC");
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
			require $conf['path_host'].'/include/include_menu_operador_local.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<h2>VUELOS EN CURSO</h2>
	<?php if(empty($sql_vuelo)){ ?>
		<center><h2>No hay vuelos en direcci&oacute;n a Santiago de Chile</h2></center>
	<?php }else{ ?>
	<table>
		<tr>
			<td>N° vuelo</td>
			<td>Codigo vuelo</td>
			<td>N&uacute;mero de valijas</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_vuelo as $key => $vuelos) {  ?>
		<tr>
			<td><?php echo $vuelos->id_vuelos; ?></td>
			<td><?php echo $vuelos->codigo_vuelo; ?></td>
			<td><?php echo $vuelos->cantidad_valijas; ?></td>

			<?php if($vuelos->id_status_vuelo==0){ ?>
				<td><strong>Vuelo abierto</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==1){ ?>
				<td><strong>Vuelo confirmado en chile</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==2){ ?>
				<td><strong>En vuelo a Chile</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==3){ ?>
				<td><strong>Vuelo cerrado</strong></td>
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