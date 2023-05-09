<?php
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';

	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion que envia el email
	require $conf['path_host'].'/funciones/enviar_correo.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$cuenta=$_POST['cuenta'];

	// consulta que comprueba la existencia del usuario
	$db->prepare("SELECT email,id_usuario FROM gar_usuarios WHERE id_usuario=:cuenta AND status=1 order by id_usuario LIMIT 1");
	$db->execute(array(':cuenta' => $cuenta));

	$usuario_select=$db->get_results();
	// fin consulta al usuario

	// si el usuario no existe direcciona con error 1
	if (empty($usuario_select)) {
		header("location: recuperar.php?sad87asdhj=1");		
	}else{
		// guiarda los datos del usuario en variables
		$id_usuario="";
		$email_usuario="";
		foreach ($usuario_select as $key => $datos) {
			$id_usuario=$datos->id_usuario;
			$email_usuario=$datos->email;
		}
		// fin datos usuario

		// genera la nueva clave de usuario
		$str1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$str2 = "abcdefghijklmnopqrstuvwxyz";
		$str3 = "1234567890";
		$cad = "";
		for($i=0;$i<3;$i++) {
		$cad .= substr($str1,rand(0,26),1);
		}
		for($i=0;$i<3;$i++) {
		$cad .= substr($str2,rand(0,26),1);
		}
		for($i=0;$i<2;$i++) {
		$cad .= substr($str3,rand(0,10),1);
		}
		// Fin genera clave

		// actualiza la clave del usuario
		$db->prepare("UPDATE gar_usuarios SET pass=:contra,cambio_pass=1 WHERE id_usuario=:id AND status=1");
		$db->execute(array(':contra' => hash('sha256', $cad),':id' => $id_usuario));
		// fin actualizacion de clave

		// ingreso de registro a la tabla log que guiarda el historial de todo lo que sucede en la bd
		$db->prepare("INSERT INTO log SET 
			id_usuario=:usu,
			accion=18,
			tabla='usuario',
			fecha=:fecha_registro

		");
		$db->execute(array(
			':usu' => $id_usuario,
			':fecha_registro' => $fecha_actual
		));
		// fin registro tabla log

		// email de comprobacion de cambio de clave
		$Email= $email_usuario;
		$mensaje   ="
						Se ha solicitado un cambio de clave de acceso.<br>
						Sus nuevos datos son:<br><br>
						Cuenta de usuario: <strong>".$id_usuario."</strong><br>
						Correo: <strong>".$email_usuario."</strong><br>
						Contrase&ntilde;a: <strong>".$cad."</strong><br>
						Ya puede ingresar a My TLC Tracking.<br>
						Saludos.<br>
						";
		
		enviarCorreo($Email,'Cambio de clave de acceso de My TLC courier',$mensaje);
		// Fin email

		// direcciona con mensaje
		header("location: recuperar.php?sa7fe789823qass90=1");
		// fin direccionamiento
	}
?>