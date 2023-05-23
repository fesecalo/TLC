<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];

	$db->prepare("SELECT 
		consolidado.id_consolidado,
	    consolidado.codigo_consolidado,
	    consolidado.peso_kilos,
	    consolidado.numero_paquetes,
		valija.id_valija,
		consolidado.fecha,
		consolidado.status_consolidado,
	    
	    valija.cincho,
	    valija.status_valija,
	    consolidado.eliminado
	    
		FROM consolidado AS consolidado
		LEFT JOIN valijas AS valija ON valija.id_valija=consolidado.id_valija
		WHERE date(consolidado.fecha) BETWEEN :inicio AND :fin
		AND consolidado.status_consolidado=1
	    AND consolidado.eliminado=0
		ORDER BY consolidado.id_consolidado DESC
	");

	$db->execute(array(':inicio' => $fecha_inicio, ':fin' => $fecha_fin));
	$sql_consolidado_cerrada=$db->get_results();
?>

<!DOCTYPE html>
<html lang="es">

	<!-- header con css -->
	<?php require $conf['path_host'].'/include/include_head.php'; ?> 
	<!-- fin header y css -->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->
	
	<script>
	    function confirmDelete(idConsolidado){
	       var urlEliminar = "../editar_consolidado/eliminar_consolidado.php?id_consolidado=" + idConsolidado
	       var answer = window.confirm("¿Estás seguro de eliminar el consolidado?");
            if (answer) {
                window.location.href =  urlEliminar;
            }
	    }
	</script>

	<body>

		<br><br><br><br>

		<!--Inicio Contenido -->

		<?php if(empty($sql_consolidado_cerrada)){ ?>

			<center><h2>No hay consolidados cerrados</h2></center>

		<?php }else{ ?>
			<table>
				<tr>
				    <td>ID</td>
					<td>TLC Tracking Consolidado</td>
					<td>Peso total(Lb)</td>
					<td>Paquetes</td>
					<td>Fecha</td>
					<td>Estado</td>
					<td>Acci&oacute;n</td>
					<td>Etiqueta</td>
				</tr>

				<tr>
					<td colspan="8"><hr size="1" color="#FF6600" /></td>
				</tr>

				<?php foreach ($sql_consolidado_cerrada as $key => $consolidado) {  ?>
					<tr>
						<td><?php echo $consolidado->id_consolidado; ?></td>
						<td><?php echo $consolidado->codigo_consolidado; ?></td>
						<td><?php echo $consolidado->peso_kilos/0.45; ?></td>
						<td><?php echo $consolidado->numero_paquetes; ?></td>
						<td><?php echo date("d/m/Y H:i:s",strtotime($consolidado->fecha)); ?></td>
						<td>Cerrado</td>
						<td>
							<a href="editar_consolidado.php?id_consolidado=<?php echo $consolidado->id_consolidado; ?>" class="button solid-color">Editar</a>
						</td>
						<td>
							<a href="../../etiqueta/etiqueta_consolidado_pdf.php?paquete=<?php echo $consolidado->id_consolidado; ?>" class="button solid-color">Ver</a>
						</td>
						<td>
							<button id="eleminar" onclick="confirmDelete(<?php echo $consolidado->id_consolidado; ?>)" class="button solid-color">Eliminar</button>
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