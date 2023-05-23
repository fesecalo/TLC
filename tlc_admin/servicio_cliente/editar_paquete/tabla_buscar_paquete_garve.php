<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$codigo=$_GET['codigo'];
	$op=$_GET['op'];
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

		estado.nombre_status

		FROM paquete 
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario

		WHERE paquete.tracking_garve=:codigo
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
			<td>Rut</td>
			<td>Gu&iacute;a</td>
			<td>Descripci&oacute;n</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<?php foreach ($sql_paquete as $key => $paquete) { ?>
		<tr>
			<td><?php echo $c; ?></td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $paquete->id_usuario; ?></td>
			<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
			<td><?php echo $paquete->rut; ?></td>
			<?php if(!empty($paquete->tracking_garve)){ ?>
				<td><?php echo $paquete->tracking_garve; ?></td>
			<?php }else{ ?>
				<td><?php echo $paquete->numero_miami; ?></td>
			<?php } ?>
			<td><?php echo $paquete->descripcion_producto; ?></td>
			<td><?php echo $paquete->nombre_status; ?></td>
			<td><a href="editar_paquete.php?paquete=<?php echo $paquete->id_paquete; ?>" class="button solid-color">Editar paquete</a></td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $c++; } ?>
	</table>
<!-- Fin de contenido -->

</body>
</html>