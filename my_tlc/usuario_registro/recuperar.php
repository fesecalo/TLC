<?php
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	if (isset($_SESSION['numero_cliente'])) {
		// Direccion a la pagina de inicio
		header("location:".$conf['path_host_url']."/tracking.php");
		// Fin redireccionamiento
	}else{
?>
<!DOCTYPE html>

<html lang="es">

<!-- HEAD-->
<?php require $conf['path_host'].'/include/include_head.php'; ?>	
<!--FIN HEAD-->

<!-- Titulo de la hoja -->
<title>LOGIN</title>
<!-- Fin titulo -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- Fin Script -->
<script type="text/javascript">
	$(document).ready(function(){
	 	var er_correo = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;

	 	$("#cuenta").focus().select();
	 	
	 	$("#cancelar").click(function(){
	 		document.form1.form_opcion.value=2;
				document.form1.submit();
	 	});

	 	$("#restablecer").click(function(){	
			if($("#cuenta").val()=='')
			{
				alert("Ingrese su numero de cliente");
				$("#cuenta").focus().select();	
				return false;
			}
			document.form1.form_opcion.value=1;
			document.form1.submit();
		});
	});
</script>
<!-- Fin Validaciones -->

<body>

<!-- HEADER-->

	<?php require $conf['path_host'].'/include/include_menu.php'; ?> 

<!--FIN HEADER-->

<!--Inicio Contenido -->

		<?php if (isset($_GET['sa7fe789823qass90'])==1) { ?>
			<div id="aviso">Su contrase&ntilde;a ha sido cambiada exitosamente.<br>
							Recibir&aacute; un email a su correo con su nueva clave de acceso.<br>
							No olvide revisar su carpeta de SPAM o CORREO NO DESEADO y cambiar su contrase&ntilde;a al ingresar a My B-Trace<br>
			</div>
			<br>
		<?php } ?>

		<?php if (isset($_GET['sad87asdhj'])==1) { ?>
			<div id="aviso">Los datos ingresados no son v&aacute;lidos.<br>
							No existe un perfil asociado a los datos ingresados.<br>
							Favor de verificar y volver a intentar.<br>
			</div>
			<br>
		<?php } ?>

		<?php if (isset($_GET['sa7fe789823qass90'])==1) { ?>
			<center>
				<a href="<?php echo $conf['path_host_url'] ?>/index.php" class="seguimiento-btn">INGRESAR</a>
			</center>
		<?php }else{ ?>
			<form name="form1" method="post" action="procesa_clave.php">
				<input type="hidden" name="_token" value="<?php echo $token_value; ?>" />
				<table>
					<tr>
						<th colspan="2">Ingrese su numero de cuenta de cliente</th>
					</tr>
					<tr>
						<td>N° cuenta*</td>
						<td><input type="text" class="form-control" name="cuenta" id="cuenta"></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						  <input type="button" name="restablecer" id="restablecer" value="Restablecer" class="button solid-color">
						  <!-- campo oculto que envia el valor del boton presionado -->
						  <input type="hidden" name="form_opcion" id="form_opcion" />
						</td>
					</tr>
				</table>
			</form>
		<?php } ?>

			<br>
<!-- Fin de contenido -->

<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  
</body>
</html>
<!-- cierre else -->
<?php } ?>
<!-- fin cierre else -->