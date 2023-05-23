<!-- conexion a la bd -->
<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	include $conf['path_host'].'/include/include_validar_rut.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$sql_tipo_usuario=$db->get_results("SELECT * FROM data_tipo_usuario");
	$sql_tipo_cliente=$db->get_results("SELECT * FROM data_tipo_cliente");
	$sql_region=$db->get_results("SELECT * FROM region ORDER BY id_region");
?>
<!-- fin conexion bd -->

<!DOCTYPE html>

<html lang="es">

<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
<!--FIN HEAD-->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- Script de validaciones -->
<script type="text/javascript">
	$(document).ready(function(){
		// Formato de email
		var er_correo = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
		// Fin formato email

		// formato de contraseña ... mayuscula, letras y numeros
		var er_pass = /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		// fin formato contraseña

		// Setea la lista de comunas segun el valor de la region
		$('#region').val();
		recargarLista();

		// carga la lista de comunas segun la region seleccionada
		$('#region').change(function(){
			recargarLista();
		});

		// inicia los input en hidde para que no se visualicen
		$(".tipo_cliente").hide();
		// fin inicia los input para que no se visualicen

		$("#tipo_usuario").change(function(){
			if($("#tipo_usuario").val()==3){
				$(".tipo_cliente").show();
				$(".nombreUsuario").hide();
			}else{
				$(".tipo_cliente").hide();
				$(".nombreUsuario").show();
			}
		});

		// validacion de datos al presionar el botonregistrar
		$("#registrar").click(function(){
			if($("#tipo_usuario").val()==0)
			{
				alert("Seleccione un tipo de usuario.");
				$("#tipo_usuario").focus();
				return false;
			}

			if($("#tipo_usuario").val()!=3){
				if($("#usuario").val()=="")
				{
					alert("Ingrese un nombre de usuario.");
					$("#usuario").focus();
					return false;
				}
			}

			if($("#email").val().match(er_correo)==null)
			{
				alert("Email no valido");
				$("#email").focus().select();	
				return false;
			}
			if($("#telefono").val()=="")
			{
				alert("Ingrese su numero de celular.");
				$("#telefono").focus();
				return false;
			}
			if($("#region").val()==0)
			{
				alert("Seleccione una región.");
				$("#region").focus();
				return false;
			}
			if($("#selComuna").val()==0)
			{
				alert("Seleccione una comuna.");
				$("#selComuna").focus();
				return false;
			}

			if($("#pass").val()=="")
			{
				alert("Ingrese contraseña.");
				$("#pass").focus();
				return false;
			}
			if($("#pass2").val()=="")
			{
				alert("Debe repetir la contraseña.");
				$("#pass2").focus();
				return false;
			}
			if($("#pass").val()!=$("#pass2").val())
			{
				alert("Contrase\u00f1as no coinciden");
				$("#pass").val("");
				$("#pass2").val("");
				$("#pass").focus().select();	
				return false;
			}else
			{
				if($("#pass").val().match(er_pass)==null)
				{
					alert("Contrase\u00f1a no v\u00e1lida, debe contener m\u00ednimo 8 caracteres, una letra may\u00fascula, una m\u00faniscula y un n\u00famero.");
					$("#pass").val("");
					$("#pass2").val("");
					$("#pass").focus().select();	
					return false;
				}
			}

		    document.registro.submit();	
		});	
		// Fin boton registrar
	});
</script>

<!-- script que realiza el volcado de datos en el select comuna segun la region seleccionada -->
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"comunas.php",
			data:"idRegion=" + $('#region').val(),
			success:function(r){
				$('#selComuna').html(r);
			}
		});
	}
</script>

<!-- Fin script de validaciones -->

<!DOCTYPE html>

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
<!-- Fin datos cliente -->

<!--Inicio Contenido -->
<div class="container">	
		

		<!-- formulario de regitro de usuario -->
		<form name="registro" id="registro" action="procesa_usuario.php" method="POST">
			<table>
				<tr>
					<td colspan="2"><h2>CREAR USUARIO</h2></td>
				</tr>
				<tr align="left">
					<td>Tipo de usuario</td>
					<td>
						<select class="form-control" id="tipo_usuario" name="tipo_usuario">
							<option value="0">Seleccione una tipo de usuario</option>
							<?php foreach ($sql_tipo_usuario as $key => $tipo_usuario) { ?>
								<option value="<?php echo $tipo_usuario->id_tipo_usuario; ?>"><?php echo $tipo_usuario->nombre_tipo; ?></option>
							<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left" class="tipo_cliente">
					<td>Tipo de cliente</td>
					<td>
						<select class="form-control" id="tipo_cliente" name="tipo_cliente">
							<option value="0">Seleccione una tipo de cliente</option>
							<?php foreach ($sql_tipo_cliente as $key => $tipo_cliente) { ?>
								<option value="<?php echo $tipo_cliente->id_tipo_cliente; ?>"><?php echo $tipo_cliente->nombre_tipo; ?></option>
							<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left" class="nombreUsuario">
					<td>Usuario</td>
					<td><input type="text" class="form-control" id="usuario" name="usuario" maxlength="100"  placeholder="Usuario"></td>
				</tr>
				<tr align="left">
					<td>Nombre</td>
					<td><input type="text" class="form-control" id="nombre" name="nombre" maxlength="100"  placeholder="Nombre"></td>
				</tr>
				<tr align="left">
					<td>Apellidos</td>
					<td><input type="text" class="form-control" id="apellido_p" name="apellido_p" maxlength="100"  placeholder="Apellido paterno"></td>
				</tr>
				<tr align="left">
					<td>Rut</td>
					<td><input type="text" class="form-control" id="rut" name="rut" maxlength="100"  placeholder="12345678-9"></td>
				</tr>
				<tr align="left">
					<td>Email</td>
					<td><input type="text" class="form-control" id="email" name="email" maxlength="100"  placeholder="ejemplo@ejemplo.com"></td>
				</tr>
				<tr align="left">
					<td>Numero Celular</td>
					<td><input type="text" class="form-control" id="telefono" name="telefono" maxlength="100"  placeholder="+56912345678"></td>
				</tr>
				<tr align="left">
					<td>Regi&oacute;n</td>
					<td>
						<select class="form-control" id="region" name="region">
							<option value="0">Seleccione una regi&oacute;n</option>
							<?php foreach ($sql_region as $key => $region) { ?>
								<option value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
							<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Comuna</td>
					<td>
						<select class="form-control" id="selComuna" name="selComuna">
							<option value="0">Seleccione una regi&oacute;n</option>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Direcci&oacute;n</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" maxlength="100"  placeholder="Direccion"></td>
				</tr>
				<tr align="left">
					<td>Contrase&ntilde;a</td>
					<td><input type="password" class="form-control" id="pass" name="pass" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Repetir Contrase&ntilde;a</td>
					<td><input type="password" class="form-control" id="pass2" name="pass2" maxlength="100"></td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" id="registrar" name="registrar" value="Registrar"></center></td>
				</tr>
			</table>
		</form>

		<!-- Fin formulario de registro -->
</div>
<!-- Fin de contenido -->

	<p>&nbsp;</p> 

</body>

</html>