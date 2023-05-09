<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$codigo=$_GET['codigo'];
	$c=1;

	$db->prepare("SELECT 

		id_usuario,
		nombre,
		apellidos,
		rut,
		email,
		telefono

		FROM gar_usuarios
		WHERE id_usuario=:codigo 
		ORDER BY id_usuario DESC
	");
	
	$db->execute(array(':codigo' => $codigo));
	$sql_usuario=$db->get_results();

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
	<input type="hidden" name="total_paquetes" id="total_paquetes" value="<?php echo $total_paquetes;?>">
	<input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $sql_paquete[0]->id_usuario;?>">
	<table>
		<tr>
			<td>Item</td>
			<td>Cuenta</td>
			<td>Cliente</td>
			<td>Rut</td>
			<td>Email</td>
			<td>Telefono</td>
			<td>Acción</td>
		</tr>
		<?php foreach ($sql_usuario as $key => $usuario) { ?>
		<tr>
			<td><?php echo $c; ?></td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $usuario->id_usuario; ?></td>
			<td><?php echo $usuario->nombre.' '.$usuario->apellidos; ?></td>
			<td><?php echo $usuario->rut; ?></td>
			<td><?php echo $usuario->email; ?></td>
			<td><?php echo $usuario->telefono; ?></td>
			<td>
				<a class="button solid-color" href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/buscar_paquete/tabla_buscar_paquete.php?codigo=<?php echo $usuario->id_usuario; ?>">Ver paquetes</a>
			</td>
		</tr>
		<tr>
			<td colspan="12"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $c++; } ?>
	</table>
	<!-- Fin de contenido -->

</body>
</html>