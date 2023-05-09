<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$codigo_buscar=$_GET["codigo"];
	$id_paquete=$_GET["id_paquete"];

	$db->prepare("SELECT 
		id_usuario,
		nombre,
		apellidos,
		email,
		telefono 
		FROM gar_usuarios 
		WHERE id_usuario LIKE :usuario
		ORDER BY id_usuario ASC
	");

    $db->execute(array(":usuario" => '%'.$codigo_buscar.'%' ));
    $resCliente=$db->get_results();
?>

<table>
	<tr>
		<td>N&deg; cliente</td>
		<td>Nombre</td>
		<td>Apellidos</td>
		<td>E-mail</td>
		<td>Telefono</td>
		<td>Acci&oacute;n</td>
	</tr>
	<?php foreach ($resCliente as $key => $cliente) {  ?>
		<tr>
			<td><?php echo $cliente->id_usuario; ?></td>
			<td><?php echo $cliente->nombre; ?></td>
			<td><?php echo $cliente->apellidos; ?></td>
			<td><?php echo $cliente->email; ?></td>
			<td><?php echo $cliente->telefono; ?></td>
			<td><a href="editar_cliente.php?id=<?php echo $cliente->id_usuario; ?>&id_paquete=<?php echo $id_paquete; ?>">Seleccionar</a></td>
		</tr>
	<?php } ?>
</table>