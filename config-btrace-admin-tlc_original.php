<?php
	// DATABASE LOCALHOST
	$conf['db_hostname'] = "dbcp05";
	$conf['db_name'] = "tlccourier_bd";
	$conf['db_username'] = "tlccourier_user";
	$conf['db_password'] = "TLCCourrier001!";

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
	$conf['path_host_url_my_btrace'] = 'https://'.$_SERVER['SERVER_NAME'].'/my_tlc';

	//se utiliza para direccionar en los href y src al modulo admin
	$conf['path_host_url'] = 'https://'.$_SERVER['SERVER_NAME'].'/tlc_admin';

	//se utiliza para importar imagenes
	$conf['path_host_img'] = 'https://'.$_SERVER['SERVER_NAME'].'/tlc_admin/img';

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
?>