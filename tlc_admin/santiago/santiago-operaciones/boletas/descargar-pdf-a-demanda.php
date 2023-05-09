<?php

	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_paquete_consolidado=$_GET["idboleta"];
	
	if($id_paquete_consolidado==""){
	    echo "<h1>Ha ocurrido un error al loguearse con SIIPO</h1>";
	    die();
	}

    $db->prepare("
        SELECT *
		FROM boletas_paquete_consolidado
		WHERE id=:id_paquete_consolidado
	    ",true);
	$db->execute(array(':id_paquete_consolidado' => $id_paquete_consolidado));
	$paqueteConsolidadoBoleta=$db->get_results();

	$folio=$paqueteConsolidadoBoleta[0]->folio;
	$tipoDte=$paqueteConsolidadoBoleta[0]->tipo_dte;

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
	    ':id' => $id_paquete_consolidado
	));

	/*$pdfBase64 = base64_decode($boletaPdf->DocBase64);
	$file = fopen( $conf['path_files_boletas_absoluto'].$columnaCodigoGuia.'.pdf', "wb");
    fwrite($file, $pdfBase64);
    fclose($file);*/
    
    //var_dump($boletaPdf->DocBase64);die();
    
    if($boletaPdf->DocBase64){
        echo json_encode(array('respuesta'=>$boletaPdf->DocBase64));
    }else{
        echo json_encode(array('error'=>"Mensaje de error"));
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
