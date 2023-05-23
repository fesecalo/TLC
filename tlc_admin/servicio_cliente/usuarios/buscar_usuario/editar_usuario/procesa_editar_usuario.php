<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usuario=$_POST['id_usuario'];

	// valida que todos los datos sean recibidos correctamente
	if(!isset($_POST['tipo_cliente'])) {
		die("Ocurrio un problema con el tipo de cliente");
	}else{
		$tipo_cliente=$_POST['tipo_cliente'];
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET tipo_cliente=:tipo_cliente WHERE id_usuario=:usuario");
		$db->execute(array(':tipo_cliente' => $tipo_cliente, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	// valida que todos los datos sean recibidos correctamente
	if(!isset($_POST['nombre'])) {
		die("Ocurrio un problema con el nombre ingresado");
	}else{
		$nombre=$_POST['nombre'];
		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET nombre=:nombre_usu WHERE id_usuario=:usuario");
		$db->execute(array(':nombre_usu' => $nombre, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	if(!isset($_POST['apellidos'])) {
		die("Ocurrio un problema con el apellido paterno");
	}else{
		$apellidos=$_POST['apellidos'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET apellidos=:apellidos_usu WHERE id_usuario=:usuario");
		$db->execute(array(':apellidos_usu' => $apellidos, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	if(!isset($_POST['rut'])) {
		die("Ocurrio un problema con el RUT ingresado");
	}else{
		$rut=$_POST['rut'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET rut=:rut_usu WHERE id_usuario=:usuario");
		$db->execute(array(':rut_usu' => $rut, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	if(!isset($_POST['telefono'])) {
		die("Ocurrio un problema con el numero de celular ingresado");
	}else{
		$telefono=$_POST['telefono'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET telefono=:telefono_usu WHERE id_usuario=:usuario");
		$db->execute(array(':telefono_usu' => $telefono, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	if(!isset($_POST['region'])) {
		die("Ocurrio un problema con la región seleccionada");
	}else{
		$region=$_POST['region'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET id_region=:region_usu WHERE id_usuario=:usuario");
		$db->execute(array(':region_usu' => $region, ':usuario' => $id_usuario));

	}

	if(!isset($_POST['selComuna'])) {
		die("Ocurrio un problema con la comuna seleccionada");
	}else{
		$comuna=$_POST['selComuna'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET id_comuna=:comuna_usu WHERE id_usuario=:usuario");
		$db->execute(array(':comuna_usu' => $comuna, ':usuario' => $id_usuario));

	}

	if(!isset($_POST['direccion'])) {
		die("Ocurrio un problema con la dirección ingresada");
	}else{
		$direccion=$_POST['direccion'];

		// realiza la actualizacion de datos en la tabla usuario
		$db->prepare("UPDATE gar_usuarios SET direccion=:direccion_usu WHERE id_usuario=:usuario");
		$db->execute(array(':direccion_usu' => $direccion, ':usuario' => $id_usuario));
		// fin actualizacion de datos
	}

	if(!isset($_POST['email'])) {
		die("Ocurrio un problema con el email ingresado");
	}else{
		$email=$_POST['email'];

		// Valida que el email ingresado no este registrado
		$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo AND id_usuario=:usuario ");
		$db->execute(array(':correo' => $email, ':usuario' => $id_usuario ));
		$correo = $db -> get_results();
		// fin validacion de email

		if(!empty($correo)){
			// realiza la actualizacion de datos en la tabla usuario
			$db->prepare("UPDATE gar_usuarios SET email=:email_usu WHERE id_usuario=:usuario");
			$db->execute(array(':email_usu' => $email, ':usuario' => $id_usuario));
			// fin actualizacion de datos
		}else{
			// Valida que el email ingresado no este registrado
			$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo ");
			$db->execute(array(':correo' => $email));
			$correo2 = $db -> get_results();
			// fin validacion de email

			if(empty($correo2)){
				// realiza la actualizacion de datos en la tabla usuario
				$db->prepare("UPDATE gar_usuarios SET email=:email_usu WHERE id_usuario=:usuario");
				$db->execute(array(':email_usu' => $email, ':usuario' => $id_usuario));
				// fin actualizacion de datos
			}else{
				die("El email ingresado ya esta en uso, por favor ingrese otro email");
			}
		}
	}
	// fin validacion de datos recibidos
	header("location: ".$conf['path_host_url']."/servicio_cliente/usuarios/buscar_usuario/editar_usuario/editar_usuario.php?id=$id_usuario");
?>
