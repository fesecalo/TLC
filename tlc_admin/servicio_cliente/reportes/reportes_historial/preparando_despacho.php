<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
	
	$db->prepare("SELECT 
			paquete.id_usuario,
			paquete.tracking_garve,
            usuario.nombre,
			usuario.apellidos,
            paquete.peso,
            paquete.descripcion_producto,
            tipo.nombre_tipo_paquete,
            estado.nombre_status,
            historial.fecha

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON (historial.id_paquete=paquete.id_paquete AND historial.id_tipo_status=28)
		INNER JOIN data_tipo_paquete AS tipo ON tipo.id_tipo_paquete=paquete.id_tipo_paquete

        INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		WHERE date(historial.fecha) BETWEEN :inicio AND :fin
        GROUP BY paquete.id_paquete
		ORDER BY historial.fecha ASC
	");
	$db->execute(array( 
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_paquete=$db->get_results();

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

	<!--Inicio Contenido -->
	<center>
		<div id="sesion">
			<p>Muestra todos los paquetes que estuvieron en preparando despacho entre un periodo de fechas</p>
		</div>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>#</td>
			<td>Cuenta</td>
			<td>Guia</td>
			<td>Cliente</td>
			<td>Peso</td>
			<td>Descripci&oacute;n</td>
			<td>Tipo paquete</td>
			<td>Estado</td>
			<td>Fecha</td>
			<td>Detalle</td>
		</tr>
		<tr>
			<td colspan="14"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sql_paquete as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $paquete->id_usuario; ?></td>
				<td><?php echo $paquete->tracking_garve; ?></td>
				<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
				<td><?php echo $paquete->peso; ?></td>
				<td><?php echo $paquete->descripcion_producto; ?></td>
				<td><?php echo $paquete->nombre_tipo_paquete; ?></td>
				<td><?php echo $paquete->nombre_status; ?></td>
				<td><?php echo date("d/m/Y H:i:s",strtotime($paquete->fecha)); ?></td>
				<td>
					<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/reportes/reportes_actuales/mostrar_paquete.php?paquete=<?php echo $paquete->id_paquete; ?>&op=1" class="button solid-color">VER</a>
				</td>

			</tr>
			<tr>
				<td colspan="14"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>

	<br/>
	<br/>
	Exportar
	<br/>
	<a href="reportes_excel/preparando_despacho.php?fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&fecha_termino=<?php echo $_GET['fecha_termino']; ?>"><img src="<?php echo $conf['path_host_url'] ?>/img/excel.jpg" width="30" height="30"> Excel</a>

	<!-- Fin de contenido -->

</body>
</html>