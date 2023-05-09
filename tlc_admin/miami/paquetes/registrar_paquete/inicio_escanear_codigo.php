<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
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
		$("#codigo").focus();
		// accion al presionar enter en el campo contraseña
		$('#codigo').keyup(function(e) {
			if(e.keyCode == 13) {
				validar();
			}
		});
		// FIN accion al presionar enter en el campo contraseña
	});

	// FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
	function validar(){
		if($("#codigo").val()==''){
			alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
			$("#codigo").select();
			return false;
		}
		document.seleccion_paquete.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
</script>

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

<!--Inicio Contenido -->

	<h2>PAQUETES</h2>

	<form action="procesa_seleccion_paquete.php" id="seleccion_paquete" name="seleccion_paquete" method="POST" >
		<center>
		<table >
			<tr>
				<td>
					<h2>INGRESE O ESCANEE CODIGO</h2>
					<input class="form-control" type="text" id="codigo" name="codigo">
				</td>
			</tr>
		</table>
		</center>
	</form>

	<br>
	<br>
<!-- Fin de contenido -->
	<br>
	<br>
</body>
</html>