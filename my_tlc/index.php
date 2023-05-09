<?php
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	if (isset($_SESSION['numero_cliente'])) {
		// Direccion a la pagina de inicio
		header("location:".$conf['path_host_url']."/tracking/tracking.php");
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
	// Formato de email
	var er_correo = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;

	// funcion que valida los campos vacios y envia formulario
	function sesion(){
		if($("#email").val()==''){
			alert("Ingrese email");
			$("#email").focus();	
			return false;
		}else if($("#email").val().match(er_correo)==null){
			alert("Email no valido");
			$("#email").focus();	
			return false;
		}

		if($("#pass").val()==''){
			alert("Contrase\u00f1a no v\u00e1lida.");
			$("#pass").select();
			return false;
		}

		document.inicio.submit();
	}
	// fin funcion

	$(document).ready(function(){
		$("#email").select();
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
		$('#email').keyup(function(e) {
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

	<?php require $conf['path_host'].'/include/include_menu.php'; ?> 

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
					<td>Email</td>
					<td><input type="text" class="form-control" name="email" id="email"/></td>
				</tr>
				<tr>
					<td>Contrase&ntilde;a</td>
					<td><input type="password" class="form-control" name="pass" id="pass"/></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><input type="button" class="button solid-color" id="entrar" value="Iniciar sesi&oacute;n"/></td>
				</tr>
			</table>
			<a href="usuario_registro/recuperar.php">Recuperar Contrase&ntilde;a</a>
		</form>
		</center>
<!-- Fin de contenido -->

<!-- INCLUDE FOOTER-->

	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 

<!--FIN FOOTER-->  

</body>

</html>
<!-- cierre else -->
<?php } ?>
<!-- fin cierre else -->