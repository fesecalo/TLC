<?php
	// DEBAJO DE UN SESION_STAR()
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	include $conf['path_host'].'/funciones/csrf.class.php';
 
	$csrf = new csrf();

	// Genera un identificador y lo valida
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	// AGREGAR INPUT TYPE HIDDEN CON LA VARIABLE TOKEN_VALUE. NOMBRE DE INPUT _token
?>