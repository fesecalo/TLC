<?php
	header('Content-Type: text/html; charset=UTF-8');
    session_start();

    if(!isset($_SESSION['numero_cliente'])){
    	header("location:".$conf['path_host_url']."/cerrar_sesion.php");
	}elseif ($_SESSION['cambio_pass']==1) {
		// Direccion a la pagina de cambio de contraseña
		header("location:".$conf['path_host_url']."/mi_cuenta/cambiar_contrasena.php");
		// Fin redireccionamiento
	}
?>