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

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->

	<center>
		<h2>REGISTRAR PROVEEDOR</h2>
		<br>
		<form id="form_proveedor" name="form_proveedor" action="procesa_proveedor_express.php" method="post">
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
				</tr>
			</table>
		</form>
	</center>

	<br><br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>
