<?php
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	if (isset($_SESSION['id_usu'])) {
		// Direccion a la pagina de inicio
		header("Location: ".$conf['path_host_url']."/inicio.php");
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

<!-- Inicio Validaciones -->
<script type="text/javascript">
	// funcion que valida los campos vacios y envia formulario
	function sesion(){
		if($("#usuario").val()=='')
			{
				alert("Usuario no v\u00e1lido.");
				$("#usuario").select();
				return false;
			}
			if($("#pass").val()=='')
			{
				alert("Contrase\u00f1a no v\u00e1lida.");
				$("#pass").select();
				return false;
			}
			document.inicio.submit();
	}
	// fin funcion

	$(document).ready(function(){
		//accion al hacer clic en boton enviar
		$("#entrar").click(function(){
			sesion();
		});
		// fin clic boton

		// accion al presionar enter en el campo contraseña
		$('#pass').keyup(function(e) {
			if(e.keyCode == 13) {
				sesion();
			}
		});
		// Fin enter campo contraseña

		// accion al presionar enter en el campo numero usuario
		$('#usuario').keyup(function(e) {
			if(e.keyCode == 13) {
				sesion();
			}
		});
		// fin enter campo numero usuario

	});
</script>
<!-- Fin Validaciones -->

<body>

<!-- HEADER-->
	<?php require $conf['path_host'].'/include/include_menu_login_backoffice.php'; ?>
<!--FIN HEADER-->

<!--Inicio Contenido -->

<!-- Mensajes de error en inicio de sesion -->
		<?php if(isset($_GET['error'])){ ?>
	      <div style="text-align: center;">
	        <?php if($_GET['error']==1 || $_GET['error']==2){ ?>
	          <span style="font-size: 18px; color: red;">Usuario o contraseña no coinciden</span>
	        <?php }elseif($_GET['error']==3){ ?>
	          <span style="font-size: 18px; color: red;">Usuario bloqueado por multiples intentos</span>
	        <?php }elseif($_GET['error']==4){ ?>
	          <span style="font-size: 18px; color: red;">Sesión Activa</span>
	        <?php } ?>
	      </div>
	    <?php } ?>
<!-- fin mensajes de error -->

		<center>
		<form id="inicio" action="validar_sesion.php" name="inicio" method="POST" autocomplete="off">
		<input type="hidden" name="_token" value="<?php echo $token_value; ?>" />
			<table>
				<tr>
					<th colspan="2">Iniciar Sesi&oacute;n</th>
				</tr>
				<tr>
					<td>Usuario</td>
					<td><input type="text" name="usuario" id="usuario"/></td>
				</tr>
				<tr>
					<td>Contrase&ntilde;a</td>
					<td><input type="password" name="pass" id="pass"/></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><input type="button" class="button solid-color" id="entrar" value="Iniciar sesi&oacute;n"/></td>
				</tr>
			</table>
		</form>
		</center>
<!-- Fin de contenido -->
</body>
</html>
<!-- cierre else -->
<?php } ?>
<!-- fin cierre else -->