<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$codigo=$_GET['codigo'];
	$c=1;

	$db->prepare("SELECT 
		paquete.id_paquete,
		paquete.id_usuario,

		usuario.nombre,
		usuario.apellidos,
		usuario.rut,

		paquete.numero_miami,
		paquete.tracking_eu,
		paquete.tracking_garve,
		paquete.descripcion_producto,
		tipo.nombre_tipo_paquete,

		estado.nombre_status

		FROM paquete 
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		LEFT JOIN data_tipo_paquete AS tipo ON tipo.id_tipo_paquete=paquete.id_tipo_paquete

		WHERE paquete.id_usuario=:codigo 
		AND paquete.status!=6 
		AND paquete.cancelado=0
		ORDER BY id_paquete DESC
	");
	
	$db->execute(array(':codigo' => $codigo ));
	$sql_paquete=$db->get_results();
?>

<!DOCTYPE html>
<html lang="es">

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<body>

<!--Inicio Contenido -->
	<table>
		<tr>
			<td>N &deg;</td>
			<td>N &deg; cuenta</td>
			<td>Cliente</td>
			<td>Guia USA</td>
			<td>Gu&iacute;a</td>
			<td>Descripci&oacute;n</td>
			<td>Tipo Paquete</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<?php foreach ($sql_paquete as $key => $paquete) { ?>
		<tr>
			<td><?php echo $c; ?></td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $paquete->id_usuario; ?></td>
			<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
			<td><?php echo $paquete->tracking_eu; ?></td>
			<?php if(!empty($paquete->tracking_garve)){ ?>
				<td><?php echo $paquete->tracking_garve; ?></td>
			<?php }else{ ?>
				<td><?php echo $paquete->numero_miami; ?></td>
			<?php } ?>
			<td><?php echo $paquete->descripcion_producto; ?></td>
			<td><?php echo $paquete->nombre_tipo_paquete; ?></td>
			<td><?php echo $paquete->nombre_status; ?></td>
			<td><a href="mostrar_paquete.php?paquete=<?php echo $paquete->id_paquete; ?>" class="button solid-color">VER</a></td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $c++; } ?>
	</table>

	<br>
	<br>

	<center><a href="<?php echo $conf['path_host_url'] ?>/santiago/buscar_paquete/buscar_paquete.php" class="button solid-color">VOLVER</a></center>

	<br>
	<br>
<!-- Fin de contenido -->

</body>
</html>