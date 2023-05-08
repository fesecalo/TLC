<?php
	// DEBAJO DE UN SESION_STAR()
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	include $conf['path_host'].'/funciones/csrf.class.php';
	include $conf['path_host'].'/funciones/obtener_ip.php';


	if(isset($_GET['token'])){
		$token=$_GET['token'];
	}else{
		$token=$_POST['_token'];
	}
	
	$csrf = new csrf();

	$ip=getRealIP();

	$accion=$_SERVER["HTTP_REFERER"];
	$accion2=$_SERVER['REQUEST_URI'];

	if(($csrf->check_valid($token))==2){
    	header("location:".$conf['path_host_url']."/errores/error_csrf.php?accion=$accion&accion2=$accion2&accion3=$ip");
    	die;
    }
?>