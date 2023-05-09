<?php
	// se inicia sesion
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	//VARIABLES
	$contra=hash('sha256', $_POST['pass']);
	$usuario=$_POST['usuario'];
	$ip=getRealIP();

	$db->prepare('SELECT * FROM gar_usuarios WHERE usuario=:usuario AND status=1');
	$db->execute(array(':usuario' => $usuario));

	$res = $db -> get_results();

	$id_usuario=$res[0]->id_usuario;
	$intentos=$res[0]->bloqueado_intentos;

	$intentos=$intentos+1;

	if(empty($res)){
		// USUARIO NO EXISTE
		header("location: ".$conf['path_host_url']."/index.php?error=1");
	}else{
		// USUARIO EXISTE, VERIFICAR SI EL USUARIO ESTA BLOQUEADO POR REINTENTOS
		if($res[0]->bloqueado_intentos==5){
			// USUARIO BLOQUEADO POR REINTENTOS
			header("location: ".$conf['path_host_url']."/index.php?error=3");
		}else{
			// SI NO ESTA BLOQUEDO VERIFICAR SI LA CONTRASEÑA ES LA CORRECTA
			$db->prepare('SELECT * FROM gar_usuarios WHERE id_usuario=:usuario AND pass=:pass AND status=1');
			$db->execute(array(
				':usuario' => $id_usuario,
				':pass' => $contra
			));

			$res_login = $db -> get_results();

			if(empty($res_login)){
				// BLOQUEO DE INICIO DE SESION
				$db->prepare("UPDATE gar_usuarios SET bloqueado_intentos=:intentos WHERE id_usuario=:id ");
				$db->execute(array(
					':id' => $id_usuario,
					':intentos' => $intentos
				));
				// FIN BLOQUEO DE INICIO DE SESION

				// CONTRASEÑA ES EQUIVOCADA
				header("location: ".$conf['path_host_url']."/index.php?error=2");
			}else{
				// SI LA CONTRASEÑA ES CORRECTA VERIFICA LA ULTIMA SESION
				$db->prepare('SELECT * FROM sesion WHERE id_usuario=:usuario ORDER BY ultima_sesion DESC LIMIT 1 ');
				$db->execute(array(':usuario' => $id_usuario));

				$sql_sesion = $db -> get_results();

				if(empty($sql_sesion)){
					// SI LA ULTIMA SECION NO ESTA ACTIVA INICIA SESION
					$db->prepare('SELECT * from gar_usuarios where id_usuario=:usuario AND pass=:pass AND status=1');
					$db->execute(array(':usuario' => $id_usuario, ':pass' => $contra));

					$sql_inicio_sesion = $db -> get_results();

					// VARIABLES BD
					foreach ($sql_inicio_sesion as $key => $login) { 
						$id_usu=$login->id_usuario;
						$usuario=$login->usuario;
						$tipo_usu=$login->tipo_usuario;
						$rut=$login->rut;
						$email=$login->email;
						$nombre=$login->nombre;
						$apellidos=$login->apellidos;
						$telefono=$login->telefono;
						$direccion=$login->direccion;
						$region=$login->id_region;
						$comuna=$login->id_comuna;
						$cambio_pass=$login->cambio_pass;
						$tipo_cliente=$login->tipo_cliente;
					}
					// FIN VARIABLES BD

					// VARIABLES DE SESION
					$_SESSION['id_usu']=$id_usu;
					$_SESSION['usuario']=$usuario;
					$_SESSION['tipo_usuario']=$tipo_usu;
					$_SESSION['rut_usuario']=$rut;
					$_SESSION['email']=$email;
					$_SESSION['nombre']=$nombre;
					$_SESSION['apellidos']=$apellidos;
					$_SESSION['telefono_usuario']=$telefono;
					$_SESSION['direccion_usuario']=$direccion;
					$_SESSION['region_usuario']=$region;
					$_SESSION['comuna_usuario']=$comuna;
					$_SESSION['tipo_cliente']=$tipo_cliente;
					// FIN VARIABLES DE SESION

					// VARIABLES DE SESION CLIENTE MY GARVE
					$_SESSION['numero_cliente']=$id_usu;
					$_SESSION['cambio_pass']=$cambio_pass;
					// FIN VARIABLES DE SESION CLIENTE MY GARVE

					// REGISTRO EN LA TABLA LOG DEL SISTEMA
					$db->prepare("INSERT INTO log SET 
						id_usuario=:usuario,
						accion=:accion,
						ip=:ip,
						fecha=:fecha
					");

					$db->execute(array(
						':usuario' => $id_usuario,
						':accion' => 'inicio_sesion',
						':ip' => $ip,
						':fecha' => $fecha_actual
					));
					// FIN REGISTRO TABLA LOG

					// REGISTRO TABLA SESIONES ACTIVAS
					$db->prepare("INSERT INTO sesion SET 
						id_usuario=:usuario,
						ultima_sesion=:fecha
					");

					$db->execute(array(
						':usuario' => $id_usuario,
						':fecha' => $fecha_actual
					));
					// FIN REGISTRO TABLA SESIONES ACTIVAS

					// REGISTRO ULTIMO INICIO DE SESION DEL USUARIO
					$db->prepare("UPDATE gar_usuarios SET ultima_sesion=:fecha WHERE id_usuario=:id ");
					$db->execute(array(
						':id' => $id_usuario,
						':fecha' => $fecha_actual
					));
					// FIN REGISTRO ULTIMO INICIO DE SESION DEL USUARIO

					// DESBLOQUEO DE INICIO DE SESION
					$db->prepare("UPDATE gar_usuarios SET bloqueado_intentos=0 WHERE id_usuario=:id ");
					$db->execute(array(
						':id' => $id_usuario
					));
					// FIN DESBLOQUEO DE INICIO DE SESION

					// ELIMINACIO DE COOKIES EN INICIO DE SESION
					ini_set('session.cookie_httponly', 1);
					ini_set('session.use_only_cookies', 1);
					ini_set('session.cookie_secure', 1);
					// FIN ELIMINACIO DE COOKIES EN INICIO DE SESION

					// DIRECCIONA A LA PAGINA PRINCIPAL
					header("location: ".$conf['path_host_url']."/inicio.php");

					// header("location: ".$conf['path_host_url']."/santiago/santiago-eshopex/inicio.php");

				}else{

					// SI TIENE REGISTRO DE SESIONES ANTERIORES CALCULA QUE LA SESION NO ESTE ACTIVA ACTUALMENTE
					$nuevafecha=strtotime('-3 minute',strtotime($fecha_actual));
					$dateNow=date('Y-m-d H:i:s',$nuevafecha);

					$db->prepare("SELECT * FROM sesion WHERE id_usuario=:usuario ORDER BY ultima_sesion DESC LIMIT 1 ");
					$db->execute(array(':usuario' => $id_usuario));

					$res_hora = $db -> get_results();

					$dateSql=$res_hora[0]->ultima_sesion;

					if($dateNow>$dateSql){
						// CONSULTA TABLA USUARIO
						$db->prepare('SELECT * from gar_usuarios where id_usuario=:usuario AND pass=:pass AND status=1');
						$db->execute(array(':usuario' => $id_usuario, ':pass' => $contra));

						$sql_inicio_sesion = $db -> get_results();

						// VARIABLES BD
						foreach ($sql_inicio_sesion as $key => $login) { 
							$id_usu=$login->id_usuario;
							$usuario=$login->usuario;
							$tipo_usu=$login->tipo_usuario;
							$rut=$login->rut;
							$email=$login->email;
							$nombre=$login->nombre;
							$apellidos=$login->apellidos;
							$telefono=$login->telefono;
							$direccion=$login->direccion;
							$region=$login->id_region;
							$comuna=$login->id_comuna;
							$cambio_pass=$login->cambio_pass;
							$tipo_cliente=$login->tipo_cliente;
						}
						// FIN VARIABLES BD

						// VARIABLES DE SESION
						$_SESSION['id_usu']=$id_usu;
						$_SESSION['usuario']=$usuario;
						$_SESSION['tipo_usuario']=$tipo_usu;
						$_SESSION['rut_usuario']=$rut;
						$_SESSION['email']=$email;
						$_SESSION['nombre']=$nombre;
						$_SESSION['apellidos']=$apellidos;
						$_SESSION['telefono_usuario']=$telefono;
						$_SESSION['direccion_usuario']=$direccion;
						$_SESSION['region_usuario']=$region;
						$_SESSION['comuna_usuario']=$comuna;
						$_SESSION['tipo_cliente']=$tipo_cliente;
						// FIN VARIABLES DE SESION

						// VARIABLES DE SESION CLIENTE MY GARVE
						$_SESSION['numero_cliente']=$id_usu;
						$_SESSION['cambio_pass']=$cambio_pass;
						// FIN VARIABLES DE SESION CLIENTE MY GARVE

						// REGISTRO EN LA TABLA LOG DEL SISTEMA
						$db->prepare("INSERT INTO log SET 
							id_usuario=:usuario,
							accion=:accion,
							ip=:ip,
							fecha=:fecha
						");

						$db->execute(array(
							':usuario' => $id_usuario,
							':accion' => 'inicio_sesion',
							':ip' => $ip,
							':fecha' => $fecha_actual
						));
						// FIN REGISTRO TABLA LOG

						// ACTUALIZACION TABLA SESIONES ACTIVAS
						$db->prepare("UPDATE sesion SET ultima_sesion=:fecha WHERE id_usuario=:id ");
						$db->execute(array(
							':id' => $id_usuario,
							':fecha' => $fecha_actual
						));
						// FIN ACTUALIZACION TABLA SESIONES ACTIVAS

						// REGISTRO ULTIMO INICIO DE SESION DEL USUARIO
						$db->prepare("UPDATE gar_usuarios SET ultima_sesion=:fecha WHERE id_usuario=:id ");
						$db->execute(array(
							':id' => $id_usuario,
							':fecha' => $fecha_actual
						));
						// FIN REGISTRO ULTIMO INICIO DE SESION DEL USUARIO

						// DESBLOQUEO DE INICIO DE SESION
						$db->prepare("UPDATE gar_usuarios SET bloqueado_intentos=0 WHERE id_usuario=:id ");
						$db->execute(array(
							':id' => $id_usuario
						));
						// FIN DESBLOQUEO DE INICIO DE SESION

						// ELIMINACIO DE COOKIES EN INICIO DE SESION
						ini_set('session.cookie_httponly', 1);
						ini_set('session.use_only_cookies', 1);
						ini_set('session.cookie_secure', 1);
						// FIN ELIMINACIO DE COOKIES EN INICIO DE SESION

						// DIRECCIONA A LA PAGINA PRINCIPAL
						header("location: ".$conf['path_host_url']."/inicio.php");
						// header("location: ".$conf['path_host_url']."/santiago/santiago-eshopex/inicio.php");

					}else{
						// ERROR DE SESION ACTIVA
						header("location: ".$conf['path_host_url']."/index.php?error=4");
					}
				}
			}
		}
	}
	
?>