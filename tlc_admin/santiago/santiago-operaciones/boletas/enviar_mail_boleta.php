<?php

	session_start();
	set_time_limit(3600);
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	
	// validacion con csrf tiene que ir despues de la funcion session_start()
	//require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion que envia el email
	require $conf['path_host'].'/funciones/enviar_correo.php';
    //require $conf['path_host'].'/../tlc_admin/archivos_prueba/composer-phpmailer/enviarEmail.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	// Buscar el lote mas viejo que no se ha ejecutado su ejecucion de envio de email
	$db->prepare("
        SELECT
        min(lote) as id_lote
    	FROM boletas_paquete_consolidado
    	WHERE pdf_mail_enviado=:pdf_mail_enviado and lote=3
    	LIMIT 1
    ",true);
	$db->execute(array(
	    ':pdf_mail_enviado' => 0
	));
	$lote = $db->get_results();
	$lote = $lote[0]->id_lote;

    // Registrar en base de datos el inicio de la ejecucion del Cron.
	$db->prepare(
	    "INSERT INTO cron_send_mail_boleta_pdf SET 
    	lote=:lote"
	);
	$db->execute(array(
		':lote' => $lote
	));
	
	// Buscar los codigos de lo paquetes a procesar del lote
	$db->prepare("
        SELECT
        paquete_consolidado,
        tipo_paquete_consolidado,
        folio,
        tipo_dte,
        id as id_boleta
    	FROM boletas_paquete_consolidado
    	WHERE pdf_mail_enviado=:pdf_mail_enviado and
    	lote=:lote
    ",true);
	$db->execute(array(
	    ':pdf_mail_enviado' => 0,
	    ':lote' => $lote
	));
	$paquetes = $db->get_results();

    $i=0;
	foreach($paquetes as $guiaPaquete){

        $tipoPaqueteConsolidado = $guiaPaquete->tipo_paquete_consolidado;

	    // Primero descargar PDF.
    	if($guiaPaquete->id_boleta==""){
    	    echo "<h1>Ha ocurrido un error al loguearse con SIIPO</h1>";
    	    die();
    	}

    	$folio = $guiaPaquete->folio;
    	$tipoDte = $guiaPaquete->tipo_dte;
    	$guia = $guiaPaquete->paquete_consolidado;
    	$tipoPaqueteConsolidado = $guiaPaquete->tipo_paquete_consolidado;
    
        $data = array(
            'Email' => $conf['email'],
            'Password' => $conf['password'],
            'Imei' => $conf['imei']
        );
        
        $tokenObj = login($data, $conf['url']); 
    
        if($tokenObj->Message=="An error has occurred."){
            ?>
            <h1>Ha ocurrido un error al loguearse con SIIPO</h1>
            <?php die();
        }
        
        $boletaPdf=obtenerPdfBoleta($tokenObj->Token, $folio ,$tokenObj->EmpresaId, $tipoDte, $conf['url']);
        
        // Guarda la response del servicio
    	$db->prepare("UPDATE boletas_paquete_consolidado SET pdfBase64=:pdfBase64, json_response_pdf=:json_response_pdf WHERE id=:id");
    	$db->execute(array(
    	    ':pdfBase64' => $boletaPdf->DocBase64 ,
    	    ':json_response_pdf' => json_encode($boletaPdf) ,
    	    ':id' => $guiaPaquete->id_boleta
    	));
        
        if($boletaPdf->DocBase64 != null){

        	$pdfBase64 = base64_decode($boletaPdf->DocBase64);
        	$file = fopen( $conf['path_files_boletas_absoluto'].$guia.'.pdf', "wb");
            fwrite($file, $pdfBase64);
            fclose($file);
    	    // FIN Primero descargar PDF.

    	    // Segundo Buscar datos de Emails a enviar
    	    if($tipoPaqueteConsolidado == 1){ // Paquetes
        	    $db->prepare("
        	        SELECT
                        usuario.email,
                        paquete.tracking_garve,    
                        boletas_paquete_consolidado.tipo_paquete_consolidado,
                        boletas_paquete_consolidado.tipo_dte,
                        boletas_paquete_consolidado.pdfBase64
                    FROM paquete as paquete
                    INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
                    JOIN boletas_paquete_consolidado ON boletas_paquete_consolidado.paquete_consolidado=paquete.tracking_garve
                    WHERE paquete.tracking_garve=:tracking_garve
        	    ",true);
            	$db->execute(array(':tracking_garve' => $guia));
        	    $datosEnvioEmail = $db->get_results();
        	    $datosEnvioEmail[0]->paquete_consolidado = $datosEnvioEmail[0]->tracking_garve;
        	    
    	    }elseif($tipoPaqueteConsolidado == 2){ // Consolidados
    	        $db->prepare("
        	        SELECT
                        consolidado.codigo_consolidado,
                        gar_usuarios.email,
                        gar_usuarios.nombre, 
                        gar_usuarios.apellidos
            		FROM consolidado as consolidado
            		JOIN gar_usuarios ON gar_usuarios.id_usuario=consolidado.id_usuario
            		JOIN comunas ON gar_usuarios.id_comuna=comunas.id_comuna
        		    JOIN region ON gar_usuarios.id_region=region.id_region
            		WHERE consolidado.codigo_consolidado=:codigo_consolidado
        	    ",true);
            	$db->execute(array(':codigo_consolidado' => $guia));
            	$datosEnvioEmail = $db->get_results();
            	$datosEnvioEmail[0]->paquete_consolidado = $datosEnvioEmail[0]->codigo_consolidado;

    	    }else{
    	       echo "Error en tipo de paquete consolidado";
    	    }
    	    
    	    $datosEnvioEmail = $datosEnvioEmail[0];
    	    //$emailCliente = $datosEnvioEmail->email;
    	    //Para Pruebas
	        $emailCliente = 'ing.greyuzcategui@gmail.com';
    	    $nroGuia = $datosEnvioEmail->paquete_consolidado;
    	    $tipoFacturaBoleta = $datosEnvioEmail->tipo_dte == 33 ? 'Factura' : 'Boleta';
    	    $dominio = $conf['path_files_boletas_dominio'];
    	    $pathDescararFacturaOBoleta = $dominio.$nroGuia.".pdf";
    	    $tipoPaqueteConsolidado = $datosEnvioEmail->tipo_paquete_consolidado == 1 ? 'Paquete' : 'Consolidado';


    	    correoFacturaBoletaDescargar(
        	    $emailCliente, 
        	    $nroGuia, 
        	    $tipoFacturaBoleta, 
        	    $pathDescararFacturaOBoleta,
        	    $tipoPaqueteConsolidado
        	);
    	    
    	   /*correoFacturaBoletaDescargar(
        	    $emailCliente=, 
        	    $nroGuia="TLCCONSGrey", 
        	    $tipoFacturaBoleta='Boleta', 
        	    $pathDescararFacturaOBoleta='https://tlccourier.cl/tlc_admin/santiago/santiago-operaciones/boletas/boletasFiles/TLC10290.pdf',
        	    $tipoPaqueteConsolidado='Paquete'
        	);*/
        	
        	// Guarda la response del servicio
        	$db->prepare("UPDATE boletas_paquete_consolidado SET pdf_mail_enviado=:pdf_mail_enviado WHERE paquete_consolidado=:paquete_consolidado");
        	$db->execute(array(
        	    ':pdf_mail_enviado' => 1,
        	    ':paquete_consolidado' => $guia
        	));

        }else{
             echo json_encode(array('error'=>"Mensaje de error"));
        }
        
	    $i++;
	}
	
	//echo "FIN";
	//die();
	

	
	function correoFacturaBoletaDescargar($emailCliente, $nroGuia, $tipoFacturaBoleta, $pathDescararFacturaOBoleta, $tipoPaqueteConsolidado){

    	$mensaje="
            <title>TLC Courier</title>
            <table width=531 border=0 align=center cellpadding=0 cellspacing=0>
                <tbody>
                    <tr>
                        <td colspan=3 align=left valign=top></td>
                    </tr>
                    <tr>
                        <td colspan=3 align=left valign=top bgcolor=#0161AC>
                            <img src=http://tlccourier.cl/inicio/images/banda_mail.png width=531 height=96>
                        </td>
                    </tr>
                    <tr>
                        <td width=16 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                        <td width=500 align=left valign=top bgcolor=#FFFFFF>
                            <table width=490 border=0 align=center cellpadding=0 cellspacing=0 bordercolor='#CCCCCC'>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <tbody>
                                    <tr>
                                        <td align=center valign=top bgcolor=#FFFFFF>
                                            <table width=400 border=0 cellpadding=0 cellspacing=0>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align=center style='margin-top: 100px; margin-bottom: 100px; padding-top:20px; padding-bottom:10px'>
                                                        <font style=font-size:10pt; color=#0161AC face=Arial size=1>
                                                            Haz recibido una <strong> $tipoFacturaBoleta </strong> pertenecienta al $tipoPaqueteConsolidado, $nroGuia.
                                                        </font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align=center style='margin-top: 100px; margin-bottom: 100px; padding-top:20px; padding-bottom:20px' >
                                                        <font style=font-size: 13pt; color=#0161AC face=Arial>
                                                            <strong>
                                                                Descarga la boleta haciendo clic 
                                                                <a href='$pathDescararFacturaOBoleta' download>
                                                                    aqu&iacute;
                                                                </a>
                                                            </strong>
                                                        </font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align=center>
                                                        <a href='$pathDescararFacturaOBoleta' download>
                                                            <table height= 80 width=200  cellpadding=3 cellspacing=0 
                                                                style='border-radius: 10px; margin-top: 50px; margin-bottom: 50px; border-style: solid; border-color: #0161AC;'>
                                                                <tr>
                                                                    <td align=center >
                                                                        <font style=font-size: 15pt; face=Arial >
                                                                            <strong> 
                                                                                Descargar
                                                                            </strong>
                                                                        </font>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </a> 
            
            
                                                        <table width=450 border=0  bordercolor=#CCCCCC cellpadding=3 cellspacing=0>
                                                            <tr>
                                                                <td height=10 align=center>
                                                                    <font style=font-size:10pt; color=#0161AC face=Arial size=1>
                                                                        <p>Recuerda que puedes realizar seguimiento de tu env&iacute;o a trav&eacute;s de tu cuenta en TLC Courier.</p>
                
                                                                        <p>Gracias por la confianza</p>
                                                                        
                                                                        <p>Equipo TLC Courier.</p>
                                                                        
                                                                        <p>TLC Courier</p>
                                                                        <a href='https://tlccourier.cl'>www.tlccourier.cl</a>
                                                                    </font>
                                                                </td>
                                                            </tr>
                                                        </table>
            
                                                        <hr/>
            
                                                        <table width=450 border=0  bordercolor=#CCCCCC cellpadding=3 cellspacing=0>
                                                            <tr>
                                                                <td align=center bgcolor=#FFFFFF> 
                                                                    <font style=font-size:10pt; color=#0161AC face=Arial ><em><strong>IMPORTANTE:</strong><br />
                                                                    NUNCA enviaremos un e-mail solicitando tus claves o datos personales y SIEMPRE nos dirigiremos a ti por tu nombre y apellido.<br />
                                                                    Nunca reveles tus claves.<br />
                                                                    Mant&eacute;n tus datos actualizados.</em></font>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                                
                                
                                <tr>
                                    <td height=30 align=center valign=bottom>
                                        <font style=font-size: 10pt; color=#0161AC face=Arial size=2 >www.tlccourier.cl - &copy; Todos los Derechos Reservados</font>
                                    </td>
                                </tr>
                                &nbsp;&nbsp;&nbsp;
                            </table>
                        </td>
                        <td width=15 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                        &nbsp; 
                    </tr>
                    <tr>
                        <td colspan=3 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 align=left valign=top bgcolor=#0161AC>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 align=left valign=top></td>
                    </tr>
                </tbody>
            </table>
       
        ";
    	
    	enviarCorreo($emailCliente, $tipoFacturaBoleta.' de TLC Courier',$mensaje);
	    
	}
	
	


function login($dataLogin, $url) {

    $ch = curl_init( $url.'api/Authenticate/');
    $payload = json_encode($dataLogin);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
}

function obtenerPdfBoleta($token, $folio, $idEmpresa, $tipoDte, $url) {
    $authorization = 'Authorization: Bearer ' . $token;
    $ch = curl_init($url.'api/DteFirma/'.$folio.'/'.$tipoDte.'/'.$idEmpresa);
    //$payload = json_encode($data);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
}
	
	
	
	
	
	
	
	
	
	
	

//----------------------------------MENSAJE CLIENTE-----------------------------------------------------------------



//------------------------------------------------------------------------------------------------------------------

    
	//header("location:".$conf['path_host_url']."/usuario_registro/msj_registro_usuario.php");
	//die();
?>