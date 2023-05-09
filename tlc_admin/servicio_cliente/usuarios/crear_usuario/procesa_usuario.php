<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	// valida que todos los datos sean recibidos correctamente
	if(!isset($_POST['usuario'])) {
		die("Ocurrio un problema con el nombre de usuario ingresado");
	}else{
		$usuario=$_POST['usuario'];
	}

	if(!isset($_POST['tipo_usuario'])) {
		die("Ocurrio un problema con el tipo de usuario ingresado");
	}else{
		$tipo_usuario=$_POST['tipo_usuario'];
	}

	if(!isset($_POST['tipo_cliente'])) {
		$tipo_cliente=0;
	}else{
		$tipo_cliente=$_POST['tipo_cliente'];
	}

	if(!isset($_POST['id_usuario'])) {
		$id_usuario=0;
	}else{
		$id_usuario=$_POST['id_usuario'];
	}

	if(!isset($_POST['nombre'])) {
		die("Ocurrio un problema con el nombre ingresado");
	}else{
		$nombre=$_POST['nombre'];
	}

	if(!isset($_POST['apellido_p'])) {
		die("Ocurrio un problema con el apellido paterno");
	}else{
		$apellido_p=$_POST['apellido_p'];
	}

	if(!isset($_POST['rut'])) {
		die("Ocurrio un problema con el RUT ingresado");
	}else{
		$rut=$_POST['rut'];
	}

	if(!isset($_POST['email'])) {
		die("Ocurrio un problema con el email ingresado");
	}else{
		$email=$_POST['email'];
	}

	if(!isset($_POST['telefono'])) {
		die("Ocurrio un problema con el numero de celular ingresado");
	}else{
		$telefono=$_POST['telefono'];
	}

	if(!isset($_POST['region'])) {
		die("Ocurrio un problema con la región seleccionada");
	}else{
		$region=$_POST['region'];
	}

	if(!isset($_POST['selComuna'])) {
		die("Ocurrio un problema con la comuna seleccionada");
	}else{
		$comuna=$_POST['selComuna'];
	}

	if(!isset($_POST['direccion'])) {
		die("Ocurrio un problema con la dirección ingresada");
	}else{
		$direccion=$_POST['direccion'];
	}

	if(!isset($_POST['pass'])) {
		die("Ocurrio un problema con la contraseña ingresada");
	}else{
		$pass=$_POST['pass'];
	}
	// fin validacion de datos recibidos

	// Valida que el email ingresado no este registrado
	$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo ");
	$db->execute(array(':correo' => $email ));
	$correo = $db -> get_results();
	// fin validacion de email

	if(!empty($correo)){
		die("El email ingresado ya esta en uso, por favor ingrese otro email");
	}


	// realiza el insert en la tabla usuario
	$db->prepare("INSERT INTO gar_usuarios SET
		usuario=:usuario,
		tipo_usuario=:tipo_usuario, 
		pass=:pass_usu, 
		rut=:rut_usu, 
		email=:email_usu, 
		nombre=:nombre_usu,
		apellidos=:apellido_pa,
		telefono=:telefono_usu,
		direccion=:direccion_usu,
		id_region=:region_usu,
		id_comuna=:comuna_usu,
		fecharegistro=:fecha,
		tipo_cliente=:tipo_cliente
	");
	$db->execute(array(
		':usuario' => $usuario,
		':tipo_usuario' => $tipo_usuario,
		':pass_usu' => hash('sha256', $pass),
		':rut_usu' => $rut,
		':email_usu' => $email,
		':nombre_usu' => $nombre,
		':apellido_pa' => $apellido_p,
		':telefono_usu' => $telefono,
		':direccion_usu' => $direccion,
		':region_usu' => $region,
		':comuna_usu' => $comuna,
		':fecha' => $fecha_actual,
		':tipo_cliente' => $tipo_cliente
	));

	$id_usuario=$db->lastId();

	header("location: ".$conf['path_host_url']."/servicio_cliente/usuarios/buscar_usuario/editar_usuario/editar_usuario.php?id=$id_usuario&msg=1");
?>
