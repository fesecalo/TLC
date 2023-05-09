<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_tipo_paquete=$_GET['id_tipo_paquete'];

	$db->prepare("SELECT * FROM data_tipo_paquete WHERE id_tipo_paquete=:id_tipo_paquete");
	$db->execute(array(':id_tipo_paquete' => $id_tipo_paquete));
	$sql_tipo_paquete=$db->get_results();

	foreach ($sql_tipo_paquete as $key => $tipo_paquete) {
		$nombre_tipo_paquete=$tipo_paquete->nombre_tipo_paquete;
		$descripcion_tipo_paquete=$tipo_paquete->descripcion_tipo_paquete;
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
				if($("#tipo_paquete").val()==""){
					alert("Ingrese el tipo de paquete.");
					$("#tipo_paquete").focus();
					return false;
				}

				document.form_tipo_paquete.submit();

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
		<form id="form_tipo_paquete" name="form_tipo_paquete" action="procesa_editar_tipo_paquete.php" method="post">
			<input type="hidden" id="id_tipo_paquete" name="id_tipo_paquete" value="<?php echo $id_tipo_paquete; ?>">
			<table>
				<tr align="left">
					<td>Tipo de paquete</td>
					<td><input type="text" class="form-control" id="tipo_paquete" name="tipo_paquete" size="70px" maxlength="100" value="<?php echo $nombre_tipo_paquete; ?>"></td>
				</tr>
				<tr align="left">
					<td>Descripción</td>
					<td><input type="text" class="form-control" id="descripcion" name="descripcion" size="70px" maxlength="500" value="<?php echo $descripcion_tipo_paquete; ?>"></td>
				</tr>
			</table>
		
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="guardar" id="guardar" value="Guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/miami/mantenedores/tipo_paquete/tipo_paquete.php" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>

	<br><br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>
