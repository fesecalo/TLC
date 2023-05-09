<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$sql_proveedor=$db->get_results("SELECT * FROM data_proveedor");
?>

<!DOCTYPE html>

	<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
	<!--FIN HEAD-->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->

	<!-- Inicio Validaciones -->
	<script type="text/javascript">
		$(document).ready(function(){

			$("#guardar").click(function(){
				if($("#proveedor").val()==""){
					alert("Ingrese el nombre del proveedor.");
					$("#proveedor").focus();
					return false;
				}

				document.form_proveedor.submit();

			});

		});
	</script>
	<!-- Fin Validaciones -->

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2){
			require $conf['path_host'].'/include/include_menu_operador_externo.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<h1>REGISTRAR PROVEEDOR</h1>
	<br>

	<center>
		
		<form id="form_proveedor" name="form_proveedor" action="procesa_proveedor.php" method="post">
			<table>
				<tr align="left">
					<td>Nombre proveedor</td>
					<td><input type="text" class="form-control" id="proveedor" name="proveedor" size="70px" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Dirección</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" size="70px" maxlength="500"></td>
				</tr>
				<tr align="left">
					<td>Fono contacto</td>
					<td><input type="text" class="form-control" id="fono" name="fono" size="70px" maxlength="100" ></td>
				</tr>
			</table>
		
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="guardar" id="guardar" value="Guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/index.php" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>

	<br><br>

	<center>
		<table>
			<tr>
				<td>#</td>
				<td>Proveedor</td>
				<td>Dirección</td>
				<td>Fono</td>
				<td>Acción</td>
				<td>Editar</td>
			</tr>
			<tr>
				<td colspan="6"><hr size="1" color="#FF6600" /></td>
			</tr>
			<?php $x=1; foreach ($sql_proveedor as $key => $proveedor){ ?>
				<tr>
					<td><?php echo $x; ?></td>
					<td><?php echo $proveedor->nombre_proveedor; ?></td>
					<td><?php echo $proveedor->direccion_proveedor; ?></td>
					<td><?php echo $proveedor->fono_proveedor; ?></td>
					<?php if($proveedor->status==1){?>
						<td>
							<a href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/procesa_desactivar_proveedor.php?id_proveedor=<?php echo $proveedor->id_proveedor; ?>" class="button solid-color">DESACTIVAR</a>
						</td>
					<?php }else{ ?>
						<td>
							<a href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/procesa_activar_proveedor.php?id_proveedor=<?php echo $proveedor->id_proveedor; ?>" class="button solid-color">ACTIVAR</a>
						</td>
					<?php } ?>
					<td><a href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/editar_proveedor.php?id_proveedor=<?php echo $proveedor->id_proveedor; ?>" class="button solid-color">EDITAR</a></td>
				</tr>
				<tr>
					<td colspan="6"><hr size="1" color="#FF6600" /></td>
				</tr>
			<?php $x++; } ?>
		</table>
	</center>

	<br><br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>
