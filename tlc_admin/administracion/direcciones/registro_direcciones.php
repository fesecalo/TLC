<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$resDirecciones=$db->get_results("SELECT * FROM data_direccion");
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
				if($("#direccion").val()==""){
					alert("Ingrese direccion.");
					$("#direccion").focus();
					return false;
				}

				if($("#ciudad").val()==""){
					alert("Ingrese ciudad.");
					$("#ciudad").focus();
					return false;
				}

				if($("#pais").val()==""){
					alert("Ingrese pais.");
					$("#pais").focus();
					return false;
				}

				document.form_registro_direcciones.submit();

			});

		});
	</script>
	<!-- Fin Validaciones -->

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1){
			require $conf['path_host'].'/include/include_menu_admin.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<h1>REGISTRAR DIRECCIONES</h1>
	<br>

	<center>
		<form id="form_registro_direcciones" name="form_registro_direcciones" action="procesa_registro_direcciones.php" method="post">
			<table>
				<tr align="left">
					<td>Dirección</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" size="70px" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Ciudad</td>
					<td><input type="text" class="form-control" id="ciudad" name="ciudad" size="70px" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Pais</td>
					<td><input type="text" class="form-control" id="pais" name="pais" size="70px" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Phone</td>
					<td><input type="text" class="form-control" id="phone" name="phone" size="70px" maxlength="100"></td>
				</tr>
			</table>
		
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="guardar" id="guardar" value="Guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/administracion/inicio.php" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>

	<br><br>

	<center>
		<table>
			<tr>
				<td>#</td>
				<td>Dirección</td>
				<td>Ciudad</td>
				<td>Pais</td>
				<td>Phone</td>
				<td colspan="2">Acción</td>
			</tr>
			<tr>
				<td colspan="7"><hr size="1" color="#FF6600" /></td>
			</tr>
			<?php $x=1; foreach ($resDirecciones as $key => $direcciones){ ?>
				<tr>
					<td><?php echo $x; ?></td>
					<td><?php echo $direcciones->direccion; ?></td>
					<td><?php echo $direcciones->ciudad; ?></td>
					<td><?php echo $direcciones->pais; ?></td>
					<td><?php echo $direcciones->phone; ?></td>
					<?php if($direcciones->status==1){?>
						<td>
							<a href="<?php echo $conf['path_host_url'] ?>/administracion/direcciones/procesa_desactivar_direccion.php?id_direccion=<?php echo $direcciones->id_direccion; ?>" class="button solid-color">DESACTIVAR</a>
						</td>
					<?php }else{ ?>
						<td>
							<a href="<?php echo $conf['path_host_url'] ?>/administracion/direcciones/procesa_activar_direccion.php?id_direccion=<?php echo $direcciones->id_direccion; ?>" class="button solid-color">ACTIVAR</a>
						</td>
					<?php } ?>
					<!-- <td><a href="<?php echo $conf['path_host_url'] ?>/miami/mantenedores/tipo_paquete/editar_tipo_paquete.php?id_direccion=<?php echo $tipo_paquete->id_direccion; ?>" class="button solid-color">EDITAR</a></td> -->
				</tr>
				<tr>
					<td colspan="7"><hr size="1" color="#FF6600" /></td>
				</tr>
			<?php $x++; } ?>
		</table>
	</center>

	<br><br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>
