<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];

	$db->prepare("SELECT 
		valija.id_valija,
	    valija.cincho,
	    valija.peso_kilos,
	    valija.numero_paquetes,
		vuelo.id_vuelos,
		valija.fecha,
	    
	    vuelo.codigo_vuelo,
	    vuelo.id_status_vuelo,
	    valija.eliminado
	    
		FROM valijas AS valija
		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=valija.id_vuelo
		WHERE date(fecha) BETWEEN :inicio AND :fin
	    AND (id_status_vuelo is null OR id_status_vuelo=3 OR id_status_vuelo=0)
	    AND valija.eliminado=0
		ORDER BY id_valija DESC
	");

	$db->execute(array(':inicio' => $fecha_inicio, ':fin' => $fecha_fin));
	$sql_valija_cerrada=$db->get_results();

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

		<?php if(empty($sql_valija_cerrada)){ ?>

			<center><h2>No hay valijas cerradas</h2></center>

		<?php }else{ ?>
			<table>
				<tr>
					<td>Cincho</td>
					<td>Peso total(Lb)</td>
					<td>Paquetes</td>
					<td>Fecha</td>
					<td>Estado</td>
					<td>Acci&oacute;n</td>
				</tr>

				<tr>
					<td colspan="8"><hr size="1" color="#FF6600" /></td>
				</tr>

				<?php foreach ($sql_valija_cerrada as $key => $valijas) {  ?>
					<tr>
						<td><?php echo $valijas->cincho; ?></td>
						<td><?php echo $valijas->peso_kilos/0.45; ?></td>
						<td><?php echo $valijas->numero_paquetes; ?></td>
						<td><?php echo date("d/m/Y H:i:s",strtotime($valijas->fecha)); ?></td>
						<td>Cerrado</td>
						<td>
							<a href="editar_valija.php?valija=<?php echo $valijas->id_valija; ?>" class="button solid-color">Editar</a>
						</td>
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