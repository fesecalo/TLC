<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$resEstado=$db->get_results("SELECT * FROM data_status WHERE status=1");
	$resLugar=$db->get_results("SELECT * FROM data_lugar WHERE status=1");
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
	 	// oculta los mensajes
	 	$(".t1").hide()
	 	$(".t2").hide()
	 	$(".t3").hide()

	 	$("#id_estado").change(function(){
			if ($("#id_estado").val()==1 || $("#id_estado").val()==8) {
				$("#id_lugar").val('1');
			}

			if ($("#id_estado").val()==2) {
				$("#id_lugar").val('2');
			}

			if ($("#id_estado").val()==3 || $("#id_estado").val()==13) {
				$("#id_lugar").val('3');
			}

			if ($("#id_estado").val()==4 || $("#id_estado").val()==7 || $("#id_estado").val()==10 || $("#id_estado").val()==11 || $("#id_estado").val()==12 || $("#id_estado").val()==25 || $("#id_estado").val()==26 || $("#id_estado").val()==27) {
				$("#id_lugar").val('4');
			}

			if ($("#id_estado").val()==5 || $("#id_estado").val()==6 || $("#id_estado").val()==9 || $("#id_estado").val()==14 || $("#id_estado").val()==15 || $("#id_estado").val()==16 || $("#id_estado").val()==17 || $("#id_estado").val()==18 || $("#id_estado").val()==19 || $("#id_estado").val()==20 || $("#id_estado").val()==28) {
				$("#id_lugar").val('5');
			}
		});

	 	// funcion que muestar el mensaje al hacer clic en el boton importar y envia los valores del formulario
	 	$("#Importar1").click(function(){
	 		
	 		if($("#archivo").val()==""){
				alert("Seleccione un archivo");
				$("#archivo").focus().select();
				return false;
			}

			$("#id_lugar_enviar").val($("#id_lugar").val());

			$(".t1").show()
	 		$(".t2").hide()
	 		$(".t3").hide()
	 		$("#Importar1").attr("disabled",true)
	 		$( "#form1" ).submit();
	 	});

	 	$("#generar").click(function(){
			$("#Importar1").attr("disabled",true)
	 		$("#generar").attr("disabled",true)
	 		$( "#form2" ).submit();
	 	});

	 	//funcion que muestar el mensaje de guardado con exito cuando el valor es 1
	 	if($("#mensaje1").val()=='1'){
	 		$(".t2").show()
	 		$(".t3").hide()
	 		$(".facturacion_ano").show()
	 		$(".facturacion_mes").show()
	 	}
	 	// funcion que muestar el mensaj error en archivo cuando el valor del id es 2
	 	if($("#mensaje1").val()=='2'){
	 		$(".t2").hide()
	 		$(".t3").show()
	 	}

	 });
	</script>
<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
			require $conf['path_host'].'/include/include_menu_operador_local.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

<!--Inicio Contenido -->
	<div id="logo"><h1>Cambio masivo de estado</h1></div>

		<form id="form1" action='procesaCambiarEstado.php' method='post' enctype="multipart/form-data">
		<input type="hidden" id="id_lugar_enviar" name="id_lugar_enviar">
		<table>
			<tr>
				<th colspan="2"><center>Importar Archivo</center></th>
			</tr>
			<tr>
				<td id="subtitulo">Seleccione estado</td>
				<td>
					<select class="form-control" id="id_estado" name="id_estado">
						<option value="0">Seleccione estado</option>
						<?php foreach ($resEstado as $key => $estado) { ?>
							<option value="<?php echo $estado->id_status; ?>"><?php echo $estado->nombre_status; ?></option>
						<?php } ?>
				 	</select>
				</td>
			</tr>
			<tr>
				<td id="subtitulo">Seleccione lugar</td>
				<td>
					<select class="form-control" id="id_lugar" name="id_lugar" disabled="true">
						<option value="0">Seleccione lugar</option>
						<?php foreach ($resLugar as $key => $lugar) { ?>
							<option value="<?php echo $lugar->id_lugar; ?>"><?php echo $lugar->nombre_lugar; ?></option>
						<?php } ?>
				 	</select>
				</td>
			</tr>
			<tr>
				<td id="subtitulo">Estado visible para el cliente</td>
				<td>
					<select class="form-control" id="visibleCliente" name="visibleCliente">
						<option value="0">Seleccione opcion</option>
						<option value="1">Si</option>
						<option value="2">No</option>
				 	</select>
				</td>
			</tr>
			<tr>
				<td id="subtitulo">Descargar formato de archivo CSV</td>
				<td>
					<a target="_blanck" href="gestor_archivos.php">Descargar Formato cambio de estado</a>
				</td>
			</tr>
			<tr>
				<td id="subtitulo">Seleccione archivo CSV</td>
				<td><input type='file' id='archivo' name='archivo' size='20'></td>
			</tr>
			<tr>
				<th colspan="2"><center><input type="button" name="Importar1" id="Importar1" value="Cambiar" style="height: 40px;"></center></th>
			</tr>
		</table>
		</form>

		<p>&nbsp;</p>
		<!-- tabla que contiene los mensajes o estados del archivo -->
		<table>
			<tr>
				<td bgcolor="E6DE0A" class="t1">Espere mientras se cargan los datos...</td>
				<td bgcolor="15E60A" class="t2">Datos cargados exitosamente</td>
				<td bgcolor="E60A0A" class="t3">Error en el tipo de archivo</td>
			</tr>
		</table>
		<p>&nbsp;</p>

		<!-- campo que guarda el id enviado por get para mostrar el mensaje segun el valor -->
		<input type="hidden" name="mensaje1" id="mensaje1" value="<?php echo $_GET["id"];?>">
<!-- Fin de contenido -->
	<br><br><br><br><br>
</body>
</html>