<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	include $conf['path_host'].'/conexion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_validar_rut.php';
	require $conf['path_host'].'/include/include_sesion.php';

	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	$id=$_GET['id'];

	$db->prepare("SELECT
			usu.nombre,
			usu.apellidos,
			usu.rut,
			usu.email,
			usu.telefono,
			usu.id_region,
			usu.id_comuna,
			usu.direccion,
			usu.bloqueado_intentos,
			usu.tipo_cliente

		FROM gar_usuarios AS usu
		WHERE usu.id_usuario=:cliente 
		ORDER BY usu.id_usuario DESC 
	");
	$db->execute(array(':cliente' => $id ));

	$sql_cliente=$db->get_results();

	$id_region_usu=$sql_cliente[0]->id_region;
	$id_comuna_usu=$sql_cliente[0]->id_comuna;

	$sql_region=$db->get_results("SELECT * FROM region ORDER BY id_region");
	$sql_tipo_cliente=$db->get_results("SELECT * FROM data_tipo_cliente");

	$db->prepare("SELECT * FROM comunas WHERE id_region=:region");
	$db->execute(array(':region' => $id_region_usu ));
	$sql_comuna=$db->get_results();

	if (empty($sql_cliente)) {
		die("Error con el numero de usuario");
	}
?>

<!DOCTYPE html>
<html lang="es">
<!-- HEAD-->
	<?php require_once $conf['path_host'].'/include/include_head.php'; ?>	
<!--FIN HEAD-->

<!-- java scripts -->
<?php require_once $conf['path_host'].'/include/java_scripts.php'; ?>   
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
			$('#comunaActual').val(0);
			recargarLista();
		});

		// Boton mostrar y ocultar terminos y condiciones
		$("#guardar").hide();

		$("#editar").click(function(){
			$("#nombre").attr("disabled",false);
			$("#apellidos").attr("disabled",false);
			$("#rut").attr("disabled",false);
			$("#email").attr("disabled",false);
			$("#telefono").attr("disabled",false);
			$("#region").attr("disabled",false);
			$("#selComuna").attr("disabled",false);
			$("#direccion").attr("disabled",false);
			$("#tipo_cliente").attr("disabled",false);
			$("#guardar").show();
			$("#editar").hide();
		});
		// fin botones terminos y condiciones

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
			if($("#selComuna").val()==0)
			{
				alert("Seleccione una comuna.");
				$("#selComuna").focus();
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

<!-- script que realiza el volcado de datos en el select comuna segun la region seleccionada -->
<script type="text/javascript">
	function recargarLista(){
		var idRegion=$('#region').val();
		var idComuna=$('#comunaActual').val();;

		var datos = {
			"idRegion" : idRegion,
			"idComuna" : idComuna
		}

		$.ajax({
			type:"POST",
			url:"comunas.php",
			data:datos,
			success:function(r){
				$('#selComuna').html(r);
			}
		});
	}
</script>

<!-- Fin script de validaciones -->

<body>
	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require_once $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

<!--Inicio Contenido -->

		<!-- inicio datos cliente -->
		<?php require_once $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
		<!-- Fin datos cliente -->

		<h2>MI CUENTA</h2>	

		<?php if(isset($_GET['msg'])){ ?>
			<div id="aviso"><center>Usuario registrado correctamente.</center></div>
		<?php } ?>

		<!-- formulario de regitro de usuario -->
		<?php foreach ($sql_cliente as $key => $cliente) { ?>
		<form name="registro" id="registro" action="procesa_editar_usuario.php" method="POST">
		<input type="hidden" name="_token" value="<?php echo $token_value; ?>" />
		<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id; ?>">
		<input type="hidden" id="comunaActual" name="comunaActual" value="<?php echo $id_comuna_usu; ?>">
			<table>
				<tr align="left" class="tipo_cliente">
					<td>Tipo de cliente</td>
					<td>
						<select class="form-control" id="tipo_cliente" name="tipo_cliente" disabled="true">
							<option value="0">Seleccione una tipo de cliente</option>
							<?php foreach ($sql_tipo_cliente as $key => $tipo_cliente) { ?>
								<option value="<?php echo $tipo_cliente->id_tipo_cliente; ?>" <?php if($cliente->tipo_cliente==($tipo_cliente->id_tipo_cliente)) {?> selected="selected" <?php }?> ><?php echo $tipo_cliente->nombre_tipo; ?></option>
							<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Nombre</td>
					<td><input type="text" class="form-control" id="nombre" name="nombre" maxlength="100"  placeholder="Nombre" value="<?php echo $cliente->nombre; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Apellidos</td>
					<td><input type="text" class="form-control" id="apellidos" name="apellidos" maxlength="100"  placeholder="Apellidos" value="<?php echo $cliente->apellidos; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Rut</td>
					<td><input type="text" class="form-control" id="rut" name="rut" maxlength="100"  placeholder="12345678-9" value="<?php echo $cliente->rut; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Email</td>
					<td><input type="text" class="form-control" id="email" name="email" maxlength="100"  placeholder="ejemplo@ejemplo.com" value="<?php echo $cliente->email; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Numero Celular</td>
					<td><input type="text" class="form-control" id="telefono" name="telefono" maxlength="100"  placeholder="+56912345678" value="<?php echo $cliente->telefono; ?>" disabled="true"></td>
				</tr>
				<tr align="left">
					<td>Regi&oacute;n</td>
					<td>
						<select class="form-control" id="region" name="region" disabled="true">
						<option value="0">Seleccione una opci&oacute;n</option>
						<?php foreach ($sql_region as $key => $region) { ?>
							<option value="<?php echo $region->id_region; ?>" <?php if($id_region_usu==($region->id_region)) {?> selected="selected" <?php }?> ><?php echo $region->nombre_region; ?></option>
						<?php } ?>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Comuna</td>
					<td>
						<select class="form-control" id="selComuna" name="selComuna" disabled="true" >
							<option value="0" <?php if($id_comuna_usu==($comuna['id_comuna'])) {?> selected="selected" <?php }?> >Seleccione una regi&oacute;n</option>
					 	</select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Direcci&oacute;n</td>
					<td><input type="text" class="form-control" id="direccion" name="direccion" maxlength="100"  placeholder="Direccion" value="<?php echo $cliente->direccion; ?>" disabled="true"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" class="button solid-color" id="editar" name="editar" value="Editar"><input type="button" class="button solid-color" id="guardar" name="guardar" value="Guardar">
						<?php if($cliente->bloqueado_intentos==5) { ?>
							<a href="desbloquear_usuario.php?id=<?php echo $id; ?>" class="button solid-color">DESBLOQUEAR</a>			
						<?php }else{ ?>
							<a href="bloquear_usuario.php?id=<?php echo $id; ?>" class="button solid-color">BLOQUEAR</a>		
						<?php } ?>
					</td>
				</tr>
			</table>
			<center><a href="../cambiar_pass/cambiar_contrasena.php?id=<?php echo $id; ?>">CAMBIAR CONTRASEÑA</a></center>
		</form>
		<br>
		<br>
		<br>
		<br>
		<?php } ?>
		<!-- Fin formulario de registro -->

<!-- Fin de contenido -->

</body>

</html>