<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
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
	 	$(".t4").hide()

	 	// funcion que muestar el mensaje al hacer clic en el boton importar y envia los valores del formulario
	 	$("#Importar1").click(function(){
	 		
	 		if($("#txtManifiesto").val()==""){
				alert("Ingrese numero de manifiesto");
				$("#txtManifiesto").focus().select();
				return false;
			}

	 		if($("#archivo").val()==""){
				alert("Seleccione un archivo");
				$("#archivo").focus().select();
				return false;
			}

			$(".t1").show()
	 		$(".t2").hide()
	 		$(".t3").hide()
	 		$(".t4").hide()
	 		$("#Importar1").attr("disabled",true)
	 		$( "#form1" ).submit();
	 	});

	 	//funcion que muestar el mensaje de guardado con exito cuando el valor es 1
	 	if($("#mensaje1").val()=='1'){
	 		$(".t2").show()
	 		$(".t3").hide()
	 		$(".t4").hide()
	 	}
	 	// funcion que muestar el mensaj error en archivo cuando el valor del id es 2
	 	if($("#mensaje1").val()=='2'){
	 		$(".t2").hide()
	 		$(".t3").show()
	 		$(".t4").hide()
	 	}

	 	if($("#mensaje1").val()=='3'){
	 		$(".t2").hide()
	 		$(".t3").hide()
	 		$(".t4").show()
	 	}

	 });
	</script>
<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
			require $conf['path_host'].'/include/include_menu_operador_eshopex.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

<!--Inicio Contenido -->
	<div id="logo"><h1>Manifiesto Eshopex</h1></div>

		<form id="form1" action='procesaManifiesto.php' method='post' enctype="multipart/form-data">
		<table>
			<tr>
				<th colspan="2"><center>Importar Archivo</center></th>
			</tr>
			<tr>
				<!-- campo que registra el nombre del problema -->
				<td id="subtitulo">Ingrese numero de manifiesto madre</td>
				<td><input type='text' id='txtManifiesto' name='txtManifiesto'></td>
			</tr>
			<tr>
				<!-- campo que registra el nombre del problema -->
				<td id="subtitulo">Seleccione archivo CSV</td>
				<td><input type='file' id='archivo' name='archivo' size='20'></td>
			</tr>
			<tr>
				<th colspan="2"><center><input type="button" name="Importar1" id="Importar1" value="Importar" style="height: 40px;"></center></th>
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
				<td bgcolor="E60A0A" class="t4">Ya existe el numero de vuelo ingresado</td>
			</tr>
		</table>
		<p>&nbsp;</p>

		<!-- campo que guarda el id enviado por get para mostrar el mensaje segun el valor -->
		<input type="hidden" name="mensaje1" id="mensaje1" value="<?php echo $_GET["id"];?>">
<!-- Fin de contenido -->

</body>
</html>