<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];

	$db->prepare("SELECT * FROM vuelos 
		WHERE (id_status_vuelo=0 OR id_status_vuelo=3) 
		AND date(fecha_creacion) BETWEEN :inicio AND :fin
		AND eliminado=0
		ORDER BY id_vuelos DESC
	");
	$db->execute(array(
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_vuelo_cerrado=$db->get_results();

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
	<br><br><br><br>
	<!--Inicio Contenido -->
	<?php if(empty($sql_vuelo_cerrado)){ ?>
		<center><h2>No hay vuelos cerrados</h2></center>
	<?php }else{ ?>
	<table>
		<tr>
			<td>Codigo vuelo</td>
			<td>MAWB</td>
			<td>N&uacute;mero de valijas</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_vuelo_cerrado as $key => $vuelos) {  ?>
		<tr>
			<td><?php echo $vuelos->codigo_vuelo; ?></td>
			<td><?php echo $vuelos->num_vuelo; ?></td>
			<td><?php echo $vuelos->cantidad_valijas; ?></td>

			<?php if($vuelos->id_status_vuelo==0){ ?>
				<td><strong>Vuelo abierto</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==1){ ?>
				<td><strong>Vuelo confirmado en chile</strong></td>
			<?php }elseif($vuelos->id_status_vuelo==2){ ?>
				<td><strong>En vuelo a Chile</strong></td>
			<?php }else{ ?>
				<td><strong>Vuelo Cerrado</strong></td>
			<?php } ?>
			
			<td><a href="editar_vuelo.php?vuelo=<?php echo $vuelos->id_vuelos; ?>" class="button solid-color">Editar</a></td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>	


	<br>
	<br>

	<!-- Fin de contenido -->

</body>
</html>