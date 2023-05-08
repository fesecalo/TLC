<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$error="";

	// valida que todos los datos sean recibidos correctamente
	if(!isset($_POST['nombre'])) {
		$error=$error."Ocurrio un problema con el nombre ingresado";
	}else{
		$nombre=$_POST['nombre'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET nombre=:nombre_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':nombre_usu' => $nombre, ':usuario' => $_SESSION['numero_cliente']));
		// fin actualizacion de datos
	}

	if(!isset($_POST['apellidos'])) {
		$error="Ocurrio un problema con el apellido paterno";
	}else{
		$apellidos=$_POST['apellidos'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET apellidos=:apellidos_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':apellidos_usu' => $apellidos, ':usuario' => $_SESSION['numero_cliente']));
		// fin actualizacion de datos
	}

	// if(!isset($_POST['rut'])) {
	// 	$error="Ocurrio un problema con el RUT ingresado";
	// }else{
	// 	$rut=$_POST['rut'];

	// 	$error="Sus datos han sido actualizados correctamente";
	// 	// realiza la actualizacion de datos en la tabla usuario
	// 	$db->prepare("UPDATE gar_usuarios SET rut=:rut_usu WHERE id_usuario=:usuario",true);
	// 	$db->execute(array(':rut_usu' => $rut, ':usuario' => $_SESSION['numero_cliente']));
	// 	// fin actualizacion de datos
	// }

	if(!isset($_POST['telefono'])) {
		$error="Ocurrio un problema con el numero de celular ingresado";
	}else{
		$telefono=$_POST['telefono'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET telefono=:telefono_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':telefono_usu' => $telefono, ':usuario' => $_SESSION['numero_cliente']));
		// fin actualizacion de datos
	}

	if(!isset($_POST['region'])) {
		$error="Ocurrio un problema con la región seleccionada";
	}else{
		$region=$_POST['region'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET id_region=:region_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':region_usu' => $region, ':usuario' => $_SESSION['numero_cliente']));

		$_SESSION['region_usuario']=$region;
		// fin actualizacion de datos
	}

	if(!isset($_POST['comuna'])) {
		$error="Ocurrio un problema con la comuna seleccionada";
	}else{
		$comuna=$_POST['comuna'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET id_comuna=:comuna_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':comuna_usu' => $comuna, ':usuario' => $_SESSION['numero_cliente']));

		$_SESSION['comuna_usuario']=$comuna;
		// fin actualizacion de datos
	}

	if(!isset($_POST['direccion'])) {
		$error="Ocurrio un problema con la dirección ingresada";
	}else{
		$direccion=$_POST['direccion'];

		$error="Sus datos han sido actualizados correctamente";
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET direccion=:direccion_usu WHERE id_usuario=:usuario",true);
		$db->execute(array(':direccion_usu' => $direccion, ':usuario' => $_SESSION['numero_cliente']));
		// fin actualizacion de datos
	}

	if(!isset($_POST['email'])) {
		$error="Ocurrio un problema con el email ingresado";
	}else{
		$email=$_POST['email'];

		// Valida que el email ingresado no este registrado
		$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo AND id_usuario=:usuario ",true);
		$db->execute(array(':correo' => $email, ':usuario' => $_SESSION['numero_cliente'] ));
		$correo = $db -> get_results();
		// fin validacion de email

		if(!empty($correo)){
			$error="Sus datos han sido actualizados correctamente";
			// realiza la actualizacion de datos en la tabla usuario
			$db->prepare("UPDATE gar_usuarios SET email=:email_usu WHERE id_usuario=:usuario",true);
			$db->execute(array(':email_usu' => $email, ':usuario' => $_SESSION['numero_cliente']));
			// fin actualizacion de datos
		}else{
			// Valida que el email ingresado no este registrado
			$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo ",true);
			$db->execute(array(':correo' => $email));
			$correo2 = $db -> get_results();
			// fin validacion de email

			if(!empty($correo2)){
				$error="Sus datos han sido actualizados correctamente";
				// realiza la actualizacion de datos en la tabla usuario
				$db->prepare("UPDATE gar_usuarios SET email=:email_usu WHERE id_usuario=:usuario",true);
				$db->execute(array(':email_usu' => $email, ':usuario' => $_SESSION['numero_cliente']));
				// fin actualizacion de datos
			}else{
				if ($error!="") {
					$error="El email ingresado ya esta en uso, por favor ingrese otro email, ".$error;
				}
			}
		}
	}
	// fin validacion de datos recibidos
?>
<!-- Inicio html para mostrar mensaje -->

<!DOCTYPE html>

<html lang="es">


<!-- HEAD-->

	<?php require $conf['path_host'].'/include/include_head.php'; ?>	

<!--FIN HEAD-->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<style type="text/css">
	table{
		width: 100%;
	}
</style>
<!-- Fin Script -->
<body>

<!-- HEADER-->
	<?php require $conf['path_host'].'/include/include_menu.php'; ?> 
<!--FIN HEADER-->

<!--Inicio Contenido -->
		<h2>REGISTRO USUARIO</h2>
		<center>
			<table >
				<tr>
					<td><h2><?php echo $error ?></h2></td>
				</tr>
			</table>
			<a href="<?php echo $conf['path_host_url'] ?>/mi_cuenta/mi_cuenta.php" class="seguimiento-btn">REGRESAR</a>
		</center>
<!-- Fin de contenido -->

	<p>&nbsp;</p>
	
<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  

</body>

</html>
					
