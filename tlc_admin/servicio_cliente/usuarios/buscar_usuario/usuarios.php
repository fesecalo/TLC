<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

	$sql_usuarios=$db->get_results("
		SELECT 
		usuario.usuario,
		usuario.id_usuario,
		tipo.nombre_tipo,
		usuario.tipo_usuario,
		usuario.nombre,
		usuario.apellidos,
		usuario.rut,
		usuario.email,
		usuario.fecharegistro,
		usuario.bloqueado_intentos
		FROM gar_usuarios As usuario
		INNER JOIN data_tipo_usuario AS tipo ON usuario.tipo_usuario=tipo.id_tipo_usuario
		WHERE usuario.tipo_usuario!=3
		ORDER BY usuario.tipo_usuario
	");
?>
<!DOCTYPE html>

<html lang="es">

<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable();
	});
</script>

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<br><br><br><br>

	<!-- tabla de datos -->
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<table class="table table-bordered table-hover dt-responsive">
					<thead>
						<tr>
							<td>usuario</td>
							<td>Tipo de usuario</td>
							<td>Nombre</td>
							<td>Apellido</td>
							<td>Rut</td>
							<td>Email</td>
							<td>Fecha de registro</td>
							<td>Acción</td>
							<?php if($msg_tabla==1 || $navegador==7){ ?>
								<td></td>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($sql_usuarios as $key => $usuario) { ?>
							<tr>
								<td><?php echo $usuario->usuario; ?></td>
								<td><?php echo $usuario->nombre_tipo; ?></td>
								<td><?php echo $usuario->nombre; ?></td>
								<td><?php echo $usuario->apellidos; ?></td>
								<td><?php echo $usuario->rut; ?></td>
								<td><?php echo $usuario->email; ?></td>
								<td><?php echo date("d/m/Y H:m:s",strtotime($usuario->fecharegistro)); ?></td>
								<td>
									<a href="editar_usuario/editar_usuario.php?id=<?php echo $usuario->id_usuario; ?>" class="button solid-color">EDITAR</a>
								</td>
								<?php if($msg_tabla==1 || $navegador==7){ ?>
									<td></td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- fin tabla de datos -->

	<br><br><br><br>

</body>
</html>