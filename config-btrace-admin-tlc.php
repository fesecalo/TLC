<?php
	// DATABASE LOCALHOST
	$conf['db_hostname'] = "localhost";
	$conf['db_name'] = "tlccouri_sistema_db_local";
	$conf['db_username'] = "root";
	$conf['db_password'] = "";

    // $conf['db_hostname'] = 'localhost';
    // $conf['db_name'] = 'tlccouri_sistema_db';
    // $conf['db_username'] = 'tlccouri_tlccourier_user';
    // $conf['db_password'] = 'Kl%y*aui7dRreCUr@23u#44$o';

	// DATABASE LOCALHOST
	// $conf['db_hostname'] = "localhost";
	// $conf['db_name'] = "tlccouriercl_web";
	// $conf['db_username'] = "root";
	// $conf['db_password'] = "";

	//path Nombre Empresa
	$conf['path_company_name'] = "TLC Courier";

	// path Logo
	$conf['path_logo'] = "logo-tlc-blanco.png";

	// path que carga el tema a mostrar. btrace, tlc, garve
	$conf['path_theme_styles'] = "styles-tlc.css";
	$conf['path_theme_bootstrap'] = "bootstrap-tlc.min.css";

	//path direccion en etiqueta
	$conf['path_direccion'] = "8256 N.W. 30th. TERRACE";
	$conf['path_ciudad'] = "MIAMI, FLORIDA 33122-1914";
	$conf['path_pais'] = "UNITED STATES OF AMERICA";
	// $conf['path_phono'] = "Phone: 786-6158656";
	$conf['path_phono'] = "Phone: 305-5921771";

	$conf['path_cuenta'] = "TLC-";

	//se utiliza para los include y requiere
	$conf['path_host'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/tlc_admin';

	//se utiliza para direccionar en los href y src al modulo de clientes
	$conf['path_host_url_my_btrace'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/my_tlc';

	//se utiliza para direccionar en los href y src al modulo admin
	$conf['path_host_url'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/tlc_admin';

	//se utiliza para importar imagenes
	$conf['path_host_img'] = 'https://'.$_SERVER['SERVER_NAME'].'/TLC/tlc_admin/img';

	//path_files administrador
	$conf['path_files_factura'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/my_tlc/archivos_prealerta";

	// path_files con ruta para comprobantes de pagos
	$conf['path_files_caja'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/tlc_admin/servicio_cliente/caja/archivos_comprobantes/";

	// path_files con ruta para recibos de dinero
	$conf['path_files_comprobante'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/tlc_admin/servicio_cliente/caja/recibo_dinero";

	//path_files facturas para generar zip
	$conf['path_files_factura_zip'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/tlc_admin/santiago/santiago-operaciones/manifiesto/manifiesto/facturas";
	
	//path_files facturas para generar zip eshopex
	$conf['path_files_factura_zip_eshopex'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/tlc_admin/santiago/santiago-eshopex/manifiesto/manifiesto/facturas";
	
	// Configuracion de datos de acceso a Siipo
	//Ambiente Test
	/*$conf['url']='http://apicert.siipodte.cl/';
	$conf['email']="ruben@tlccourrier.cl";
    $conf['password']="Rm1137";
    $conf['imei']="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9";*/
    
    //Ambiente produccion
    /*$conf['url']='https://api.siipodte.cl/';
    $conf['email']="ruben@tlccourrier.cl";
    $conf['password']="Rm1595";
    $conf['imei']="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9";*/
    
    //Ambiente produccion Ultimo.
    $conf['url']="https://api.siipodte.cl/";
    $conf['email']="jossenino@gmail.com";
    $conf['password']="TLCCourier2023.*";
    $conf['imei']="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9";
    
    //Ambiente Espejo.
    //$conf['url']="http://preapi.siipodte.cl/";
    //$conf['email']="jossenino@gmail.com";
    //$conf['password']="TLCCourier2023.*";
    //$conf['imei']="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9";

	
	// path_files dominio con ruta para boletas
	$conf['path_files_boletas_dominio'] = $conf['path_host_url']."/santiago/santiago-operaciones/boletas/boletasFiles/";
	
	// path_files dominio con ruta para boletas
	$conf['path_files_boletas_absoluto'] = $_SERVER['DOCUMENT_ROOT'].'/TLC'."/tlc_admin/santiago/santiago-operaciones/boletas/boletasFiles/";
	
	
?>