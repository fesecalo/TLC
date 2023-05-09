<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_proveedor=$_GET['id_proveedor'];

	$db->prepare("SELECT * FROM data_proveedor WHERE id_proveedor=:id_proveedor");
	$db->execute(array(':id_proveedor' => $id_proveedor));
	$sql_proveedor=$db->get_results();

	foreach ($sql_proveedor as $key => $proveedor) {
		$nombre_proveedor=$proveedor->nombre_proveedor;
		$direccion_proveedor=$proveedor->direccion_proveedor;
		$fono_proveedor=$proveedor->fono_proveedor;
	}
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
		
		<form id="form_proveedor" name="form_proveedor" action="procesa_editar_proveedor.php" method="post">
			<input type="hidden" id="id_proveedor" name="id_proveedor" value="<?php echo $id_proveedor; ?>">
			<table>
				<tr align="left">
					<td>Nombre proveedor</td>
					<td><input type="text" class="form-control" id="proveedor" name="proveedor" size="70px" maxlength="100" value="<?php echo $nombre_proveedor; ?>"></td>
				</tr>
				<tr align="left">
					<td>Dirección</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" size="70px" maxlength="500" value="<?php echo $direccion_proveedor; ?>"></td>
				</tr>
				<tr align="left">
					<td>Fono contacto</td>
					<td><input type="text" class="form-control" id="fono" name="fono" size="70px" maxlength="100" value="<?php echo $fono_proveedor; ?>"></td>
				</tr>
			</table>
		
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="guardar" id="guardar" value="Guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/proveedor.php" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>

	<br><br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>
