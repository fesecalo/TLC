<!-- conexion a la bd -->
<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	include $conf['path_host'].'/conexion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_validar_rut.php';
	require $conf['path_host'].'/include/include_sesion.php';

	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	$db->prepare("SELECT * 
				FROM gar_usuarios AS usu
				LEFT JOIN region AS region ON region.id_region=usu.id_region
				LEFT JOIN comunas AS comuna ON comuna.id_comuna=usu.id_comuna
				WHERE usu.id_usuario=:cliente 
				ORDER BY usu.id_usuario DESC 
	");
	$db->execute(array(':cliente' => $_SESSION['numero_cliente'] ));
	$sql_cliente=$db->get_results();


	$regionUsu=$sql_cliente[0]->id_region;
	$comunaUsu=$sql_cliente[0]->id_comuna;


	$db->prepare("SELECT * FROM comunas WHERE id_region=:regionUsu ORDER BY nombre_comuna");
	$db->execute(array(':regionUsu' => $regionUsu ));
	$sql_comuna=$db->get_results();

	$sql_region=$db->get_results("SELECT * FROM region ORDER BY id_region");
	
?>

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

		// Boton mostrar y ocultar terminos y condiciones
		$("#guardar").hide();

		$("#editar").click(function(){
			$("#nombre").attr("disabled",false);
			$("#apellidos").attr("disabled",false);
			$("#email").attr("disabled",false);
			$("#telefono").attr("disabled",false);
			$("#region").attr("disabled",false);
			$("#comuna").attr("disabled",false);
			$("#direccion").attr("disabled",false);
			$("#guardar").show();
			$("#editar").hide();
		});
		// fin botones terminos y condiciones

		// Setea la lista de comunas segun el valor de la region
		$('#region').val();
		recargarLista();

		// carga la lista de comunas segun la region seleccionada
		$('#region').change(function(){
			recargarLista();
		});

		// validacion de datos al presionar el botonregistrar
		$("#guardar").click(function(){
			if($("#nombre").val()=="")
			{
				alert("Ingrese su nombre.");
				$("#nombre").focus();
				return false;
			}
			if($("#apellido_p").val()=="")
			{
				alert("Ingrese au apellido paterno.");
				$("#apellido_p").focus();
				return false;
			}
			if($("#apellido_m").val()=="")
			{
				alert("Ingrese su apellido materno.");
				$("#apellido_m").focus();
				return false;
			}
			if($("#rut").val()=="")
			{
				alert("Ingrese su rut.");
				$("#rut").focus();
				return false;
			}else
			{
				if (validacion_rut($("#rut").val())==2) 
				{
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
			if($("#comuna").val()==0)
			{
				alert("Seleccione una comuna.");
				$("#comuna").focus();
				return false;
			}
			if($("#direccion").val()=="")
			{
				alert("Ingrese una direccion de entrega.");
				$("#direccion").focus();
				return false;
			}
	        document.registro.submit();
		});	
		// Fin boton registrar
	});
</script>
<!-- Fin script de validaciones -->

<!-- script que realiza el volcado de datos en el select comuna segun la region seleccionada -->
<script type="text/javascript">
	function recargarLista(){
	    console.log($('#region').val());
	    
	    var formData = {
            idRegion: $('#region').val(),
            idComunaSelected: $('#comuna').val()
        };
	    
	    $.ajax({
			type:"POST",
			url: "comunas.php",
			data: formData,
			success: function(r){
				$('#comuna').html(r);
			}
		});
	}
</script>

<!-- Fin script de validaciones -->
<body>
<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
		require $conf['path_host'].'/include/include_menu_admin.php';
	}elseif($_SESSION['tipo_usuario']==3){
		require $conf['path_host'].'/include/include_menu.php';
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

<!--Inicio Contenido -->

		<!-- registro de prealertas -->	
		<center>
			<h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3>
			<a href="<?= $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a>
		</center>
		<!-- Fin prealerta -->

		<br><br>

		<!-- inicio datos cliente -->
		<p>&nbsp;</p>
		<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
		<p>&nbsp;</p>
		<!-- Fin datos cliente -->
		<h2>MI CUENTA</h2>	
		<!-- formulario de regitro de usuario -->
		<?php foreach ($sql_cliente as $key => $cliente) { ?>
		<form name="registro" id="registro" action="editar_usuario.php" method="POST">
		<input type="hidden" name="_token" value="<?= $token_value; ?>" />
			<table>
				<tr align="left">
					<td>Nombre</td>
					<td><input type="text" class="form-control" id="nombre" name="nombre" maxlength="100"  placeholder="Nombre" value="<?= $cliente->nombre; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Apellidos</td>
					<td><input type="text" class="form-control" id="apellidos" name="apellidos" maxlength="100"  placeholder="Apellidos" value="<?= $cliente->apellidos; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Rut</td>
					<td><input type="text" class="form-control" id="rut" name="rut" maxlength="100"  placeholder="12345678-9" value="<?= $cliente->rut; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Email</td>
					<td><input type="text" class="form-control" id="email" name="email" maxlength="100"  placeholder="ejemplo@ejemplo.com" value="<?= $cliente->email; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Numero Celular</td>
					<td><input type="text" class="form-control" id="telefono" name="telefono" maxlength="100"  placeholder="+56912345678" value="<?= $cliente->telefono; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Regi&oacute;n</td>
					<td>
						<select class="form-control" id="region" name="region" disabled="true">
						<option value="0">Seleccione una opci&oacute;n</option>
						<?php foreach ($sql_region as $key => $region) { ?>
							<option value="<?= $region->id_region; ?>" <?php if($_SESSION['region_usuario']==($region->id_region)) {?> selected="selected" <?php }?> ><?= $region->nombre_region; ?></option>
						<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Comuna</td>
					<td>
						<select class="form-control" id="comuna" name="comuna" disabled="true">
							<option value="0">Seleccione una comuna</option>
							<?php foreach ($sql_comuna as $key => $comuna) { ?>
								<option value="<?= $comuna->id_comuna; ?>" <?php if($comunaUsu==($comuna->id_comuna)) {?> selected="selected" <?php }?> ><?= $comuna->nombre_comuna; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr align="left">
					<td>Direcci&oacute;n</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" maxlength="100"  placeholder="Direccion" value="<?= $cliente->direccion; ?>" disabled="true"></td>
				</tr>
				<tr>
					<td colspan="2">
					<center>
						<input type="button" class="button solid-color" id="editar" name="editar" value="Editar"><input type="button" class="button solid-color" id="guardar" name="guardar" value="Guardar">

					</center>
					</td>
				</tr>
			</table>
			<center><a href="cambiar_contrasena.php">CAMBIAR CONTRASEÑA</a></center>
		</form>
		<?php } ?>
		<!-- Fin formulario de registro -->

<!-- Fin de contenido -->
	<p>&nbsp;</p>
<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  

</body>

</html>