<?php
	header('Content-Type: text/html; charset=UTF-8');
    session_start();
    if(!isset($_SESSION['id_usu'])){
    	header("location: ".$conf['path_host_url']."/cerrar_sesion.php");
	}
?>