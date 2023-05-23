<?php
	// DATABASE FIDELITY GROUP
	//$conf['db_hostname'] = "dbcp05";
	// $conf['db_hostname'] = "dbcp05";
	// $conf['db_name'] = "tlccourier_bd";
	// $conf['db_username'] = "tlccourier_user";
	// $conf['db_password'] = "TLCCourrier001!";

	// DATABASE LOCALHOST
	$conf['db_hostname'] = "localhost";
	$conf['db_name'] = "tlccouri_sistema_db_local";
	$conf['db_username'] = "root";
	$conf['db_password'] = "";

	//path Nombre Empresa
	$conf['path_company_name'] = "TLC Courier";

	// path Logo
	//$conf['path_logo'] = "logo-tlc-blanco.png";
	$conf['path_logo'] = "Logo-TLC.jpg";

	// path que carga el tema a mostrar. btrace, tlc, garve
	$conf['path_theme_styles'] = "styles-tlc.css";
	$conf['path_theme_bootstrap'] = "bootstrap-tlc.min.css";
	
	$conf['path_host'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/my_tlc'; //se utiliza para los include y requiere
	$conf['path_host_url_btrace_admin'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/tlc_admin'; //se utiliza para direccionar en los href y src
	$conf['path_host_url'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/my_tlc'; //se utiliza para direccionar en los href y src
	$conf['path_host_img'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/my_tlc/img';//se utiliza para importar imagenes

	//path_files administrador
	$conf['path_files'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/my_tlc/archivos_prealerta/";
	$conf['path_files_consolidado'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/my_tlc/archivos_consolidado/";
	
	$conf['path_host_url_consolidado'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/my_tlc/archivos_consolidado'; //se utiliza para direccionar en los href y src
	

?>