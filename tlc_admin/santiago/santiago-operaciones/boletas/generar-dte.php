<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);

    $id_usuario_ejecuta=$_SESSION["id_usu"];

	$db->prepare("
        SELECT
        max(lote) as id_lote
    	FROM boletas_paquete_consolidado
    ",true);
	$db->execute(array());
	$lote=$db->get_results();
	
    $lote = $lote[0]->id_lote + 1;

    foreach($_POST['paquete'] as $datosPaquete ){
        $datoCsvPaquete = explode('|', $datosPaquete);
        $columnaIdCliente=$datoCsvPaquete[0];
        $columnaCodigoGuia=$datoCsvPaquete[1];
        $columnaPeso=$datoCsvPaquete[2];
        $columnaFob=$datoCsvPaquete[3];
        $columnaServicio=$datoCsvPaquete[4];
        $columnaGestionAduanera=$datoCsvPaquete[5];
        $columnaFlete=$datoCsvPaquete[6];
        $columnaSed=$datoCsvPaquete[7];
        $columnaContainer=$datoCsvPaquete[8];
        $columnaPallets=$datoCsvPaquete[9];
        $columnaImpuestos=$datoCsvPaquete[10];
        
        $db->prepare("
	        SELECT
            paquete_consolidado
    		FROM boletas_paquete_consolidado
    		WHERE paquete_consolidado=:paquete_consolidado
    		ORDER BY boletas_paquete_consolidado.id ASC
	    ",true);
    	$db->execute(array(':paquete_consolidado' => $columnaCodigoGuia));
    	$paqueteConsolidadoBoleta=$db->get_results();

        if(!empty($paqueteConsolidadoBoleta)){ //paquete o consolidado Previamente procesado. No debe procesarse.
            $boletasPrevias[]=$paqueteConsolidadoBoleta[0]->paquete_consolidado;
            continue;
        }
        
        $db->prepare("
            SELECT
			usuario.id_usuario,
			usuario.rut,
			usuario.direccion,
			usuario.telefono,
			usuario.nombre,
			usuario.apellidos,
			usuario.email,
			usuario.tipo_cliente,
			
			paquete.tracking_garve,
			paquete.numero_miami,
			paquete.consignatario,

			currier.nombre_currier,

			paquete.tracking_eu,
			paquete.proveedor,
			paquete.valor,
			paquete.descripcion_producto,
			paquete.pieza,
			paquete.peso,
			paquete.largo,
			paquete.ancho,
			paquete.alto,

			valija.cincho,

			vuelo.codigo_vuelo,

			paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete,
			paquete.peso_volumen,
			
			comunas.nombre_comuna,
			region.nombre_region

    		FROM paquete as paquete
    		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
    		INNER JOIN comunas AS comunas ON usuario.id_comuna=comunas.id_comuna
    		INNER JOIN region AS region ON usuario.id_region=region.id_region
    		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
    		LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
    		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
    		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
    		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
    		WHERE paquete.tracking_garve=:tracking_garve
    		ORDER BY paquete.id_paquete ASC
	    ",true);
    	$db->execute(array(':tracking_garve' => $columnaCodigoGuia));
    
    	$sql_paquete=$db->get_results();

    	$tipoPaqueteConsolidado=1;
    	
    	if(!empty($sql_paquete)){
    	    $codigoPaqueteConsolidado=$sql_paquete[0]->tracking_garve;
    	}
    	
    	if(empty($sql_paquete)){
    	    
    	    /*$db->prepare("
    	    
    	        SELECT
                consolidado.codigo_consolidado,
                gar_usuarios.email,
                gar_usuarios.nombre, 
                gar_usuarios.apellidos, 
                gar_usuarios.rut, 
                gar_usuarios.telefono, 
                gar_usuarios.direccion,
                gar_usuarios.tipo_cliente,
                comunas.nombre_comuna,
			    region.nombre_region
        		FROM consolidado as consolidado
        		JOIN gar_usuarios ON gar_usuarios.id_usuario=consolidado.id_usuario
        		JOIN comunas ON gar_usuarios.id_comuna=comunas.id_comuna
    		    JOIN region ON gar_usuarios.id_region=region.id_region
        		WHERE consolidado.codigo_consolidado=:codigo_consolidado
        		ORDER BY consolidado.id_consolidado ASC
    	    
    	    ",true);
        	$db->execute(array(':codigo_consolidado' => $columnaCodigoGuia));
        	$sql_paquete=$db->get_results();

        	$codigoPaqueteConsolidado = $sql_paquete[0]->codigo_consolidado;
    	    
    	    $tipoPaqueteConsolidado=2;*/
    	    
    	     $db->prepare("
    	    
    	        SELECT
                consolidado.id_consolidado,
                consolidado.codigo_consolidado
        		FROM consolidado as consolidado
        		WHERE consolidado.codigo_consolidado=:codigo_consolidado
        		ORDER BY consolidado.id_consolidado ASC
    	    
    	    ",true);
        	$db->execute(array(':codigo_consolidado' => $columnaCodigoGuia));
        	$sql_consolidado=$db->get_results();
        	
        	$codigoPaqueteConsolidado = $sql_consolidado[0]->codigo_consolidado;
        	$idConsolidado = $sql_consolidado[0]->id_consolidado;
        	
        	 $db->prepare("
                SELECT
    			usuario.id_usuario,
    			usuario.rut,
    			usuario.direccion,
    			usuario.telefono,
    			usuario.nombre,
    			usuario.apellidos,
    			usuario.email,
    			usuario.tipo_cliente,
    			
    			paquete.tracking_garve,
    			paquete.numero_miami,
    			paquete.consignatario,
    
    			currier.nombre_currier,
    
    			paquete.tracking_eu,
    			paquete.proveedor,
    			paquete.valor,
    			paquete.descripcion_producto,
    			paquete.pieza,
    			paquete.peso,
    			paquete.largo,
    			paquete.ancho,
    			paquete.alto,
    
    			valija.cincho,
    
    			vuelo.codigo_vuelo,
    
    			paquete.id_proveedor,
    
    			proveedor.nombre_proveedor,
    			tipo_paquete.nombre_tipo_paquete,
    			paquete.peso_volumen,
    			
    			comunas.nombre_comuna,
    			region.nombre_region
    
        		FROM paquete as paquete
        		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        		INNER JOIN comunas AS comunas ON usuario.id_comuna=comunas.id_comuna
        		INNER JOIN region AS region ON usuario.id_region=region.id_region
        		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        		LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
        		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
        		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
        		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
        		WHERE paquete.id_consolidado=:id_consolidado
        		ORDER BY paquete.id_paquete ASC limit 1
    	    ",true);
        	$db->execute(array(':id_consolidado' => $idConsolidado));
        
        	$sql_paquete=$db->get_results();
    	    $tipoPaqueteConsolidado=2;
    	    //Verificar si no es un paquete y no es un consolidado. $sql_paquete agregarlo a un arreglo para notificarlo al usuario.
    	    
    	}

        $data = array(
            'Email' => $conf['email'],
            'Password' => $conf['password'],
            'Imei' => $conf['imei']
        );
        
        $tokenObj = login($data, $conf['url']); 
        //var_dump($tokenObj);

        if($tokenObj->Token==null){
            ?>
            <h1>Ha ocurrido un error al loguearse con SIIPO</h1>
            <?php die();
        }

        $servicioPrecioMontoItemTotalLinea= $sql_paquete[0]->tipo_cliente != 2 ? round($columnaServicio * $_POST['tipo_cambio'] + ( $columnaServicio * $_POST['tipo_cambio'] * 0.19 ),2) : round($columnaServicio * $_POST['tipo_cambio'],2);

    	if($columnaServicio > 0){
    	    $detallesDocumentoManejoOperacional = array(
        	    "DetalleDocumentoId" => 0,
                "Descripcion" => "TLC Manejo Operacional",
                "Cantidad" => 1,
                "Precio" => $servicioPrecioMontoItemTotalLinea ,
                "Exento" => false,
                "MontoItem" => $servicioPrecioMontoItemTotalLinea,
                //"MontoItem" => ($sql_paquete[0]->valor/$sql_paquete[0]->pieza)*$_POST['tipo_cambio'],
                "FechaProducto" => date("Y-m-d h:i:s"),
                "CodigoProducto" => $codigoPaqueteConsolidado,
                "DescuentoPorcentaje" => 0,
                "MontoDescuento" => 0,
                "Documento" => null,
                "TotalLinea" => $servicioPrecioMontoItemTotalLinea
            );
    	}

    	$fletePrecioMontoItemTotalLinea= round($columnaFlete * $_POST['tipo_cambio'],2);
    	
        if($columnaFlete > 0){
        	$detallesDocumentoFlete = array(
        	    "DetalleDocumentoId" => 0,
                "Descripcion" => "TLC Flete",
                "Cantidad" => 1,
                "Precio" => $fletePrecioMontoItemTotalLinea,
                "Exento" => true,
                "MontoItem" => $fletePrecioMontoItemTotalLinea,
                "FechaProducto" => date("Y-m-d h:i:s"),
                "CodigoProducto" => $codigoPaqueteConsolidado,
                "DescuentoPorcentaje" => 0,
                "MontoDescuento" => 0,
                "Documento" => null,
                "TotalLinea" => $fletePrecioMontoItemTotalLinea
            );
        }
        
        $impuestosPrecioMontoItemTotalLinea = round($columnaImpuestos,2) ;
        
        if($columnaImpuestos > 0){
        	$detallesDocumentoImpuestos = array(
        	    "DetalleDocumentoId" => 0,
                "Descripcion" => "Impuestos",
                "Cantidad" => 1,
                "Precio" => $impuestosPrecioMontoItemTotalLinea ,
                "Exento" => true,
                "MontoItem" => $impuestosPrecioMontoItemTotalLinea ,
                "FechaProducto" => date("Y-m-d h:i:s"),
                "CodigoProducto" => $codigoPaqueteConsolidado,
                "DescuentoPorcentaje" => 0,
                "MontoDescuento" => 0,
                "Documento" => null,
                "TotalLinea" => $impuestosPrecioMontoItemTotalLinea
            );
        }
        
        $gestionAduaneraPrecioMontoItemTotalLinea = $sql_paquete[0]->tipo_cliente != 2 ?  round($columnaGestionAduanera * $_POST['tipo_cambio'] + ($columnaGestionAduanera * $_POST['tipo_cambio'] * 0.19), 2) : round($columnaGestionAduanera * $_POST['tipo_cambio'], 2);
        
        if($columnaGestionAduanera > 0){
        	$detallesDocumentoGestionAduanera = array(
        	    "DetalleDocumentoId" => 0,
                "Descripcion" => "Gestion Aduanera",
                "Cantidad" => 1,
                "Precio" => $gestionAduaneraPrecioMontoItemTotalLinea ,
                "Exento" => false,
                "MontoItem" => $gestionAduaneraPrecioMontoItemTotalLinea ,
                "FechaProducto" => date("Y-m-d h:i:s"),
                "CodigoProducto" => $codigoPaqueteConsolidado,
                "DescuentoPorcentaje" => 0,
                "MontoDescuento" => 0,
                "Documento" => null,
                "TotalLinea" => $gestionAduaneraPrecioMontoItemTotalLinea 
            );
        }

        $receptor = array(
            "Rut" => $sql_paquete[0]->rut,
            "RazonSocial" => $sql_paquete[0]->nombre.' '.$sql_paquete[0]->apellidos,
            "Giro" => "Cliente TLC",
            "Direccion" => $sql_paquete[0]->direccion,
            "Comuna" => $sql_paquete[0]->nombre_comuna,
            "Ciudad" => $sql_paquete[0]->nombre_region,
            "Telefono" => $sql_paquete[0]->telefono,
            "Correo" => $sql_paquete[0]->email
        );
        
        $referencias = array(
            array(
                "numeroLinea" => 1,
                "tipoDte" => 801,
                "folio" => "",
                "fecha" => date("Y-m-d h:i:s"),
                "razon" => "Referencia Prueba",
                "tipoReferencia" => 0
            )
        );
        
        $facturaElectronicaBoletaElectronica = $sql_paquete[0]->tipo_cliente == 2 ? 33 : 39;
        
        $arrayItems=array();
        $arrayItemsParaCargos=array();
        $banderaNoProcesarServicio=false;
        $banderaNoProcesarFlete=false;
        $banderaNoProcesarImpuestos=false;
        $banderaNoProcesarGestionAduanera=false;
        
        if(!($columnaServicio === "0" || $columnaServicio == null) ){
            array_push($arrayItems, $detallesDocumentoManejoOperacional);
            array_push($arrayItemsParaCargos, $detallesDocumentoManejoOperacional);
        }else{
            $banderaNoProcesarServicio=true;
        }
        
        if(!($columnaFlete === "0" || $columnaFlete == null)){
            array_push($arrayItems, $detallesDocumentoFlete);
            array_push($arrayItemsParaCargos, $detallesDocumentoFlete);
        }else{
            $banderaNoProcesarFlete=true;
        }
        
        if(!($columnaImpuestos === "0" || $columnaImpuestos == null)){
            //array_push($arrayItems, $detallesDocumentoImpuestos);
            array_push($arrayItemsParaCargos, $detallesDocumentoImpuestos);
        }else{
            $banderaNoProcesarImpuestos=true;
        }
        
        if(!($columnaGestionAduanera === "0" || $columnaGestionAduanera == null)){
            array_push($arrayItems, $detallesDocumentoGestionAduanera);
            array_push($arrayItemsParaCargos, $detallesDocumentoGestionAduanera);
        }else{
            $banderaNoProcesarGestionAduanera=true;
        }
        
        $empresa = array(
            "EmpresaId" => $tokenObj->EmpresaId,
            "DocumentoId" => 0,
            "OrigenId" => $columnaCodigoGuia,
            "TipoDte" =>$facturaElectronicaBoletaElectronica,
            "FolioDte" => 0,
            "TipoOperacion" => 2,
            "Receptor" => $receptor,
            "referencias" => $referencias,
            "DetallesDocumento" => $arrayItems
        ); // para Enviar a Siipo

        $empresaParaCargos = array(
            "EmpresaId" => $tokenObj->EmpresaId,
            "DocumentoId" => 0,
            "OrigenId" => $columnaCodigoGuia,
            "TipoDte" =>$facturaElectronicaBoletaElectronica,
            "FolioDte" => 0,
            "TipoOperacion" => 2,
            "Receptor" => $receptor,
            "referencias" => $referencias,
            "DetallesDocumento" => $arrayItemsParaCargos
        ); // para Enviar a Tabla CARGOS


        if($banderaNoProcesarServicio == true && $banderaNoProcesarFlete == true && $banderaNoProcesarImpuestos == true && $banderaNoProcesarGestionAduanera == true){
            echo "No tiene item de Servicio, Flete, Gestion Aduanera o Impuestos asociados. Produce un error, No procesar este documento electronico tributario.";
            die();
        }
        /*$salidaAmbiente = match ($conf['ambienteSiipo']){
            'test' => 1,
            'prod' => 2,
            'prepro' => 3,
            default => 0 // Opcional, en caso de que ninguno de los casos anteriores se cumpla.
        };*/
        
        if($conf['ambienteSiipo'] == 'prod'){
            $salidaAmbiente=1;
        }else if($conf['ambienteSiipo'] == 'test'){
            $salidaAmbiente=2;
        }else if($conf['ambienteSiipo'] == 'espe'){
            $salidaAmbiente=3;
        }else{
            $salidaAmbiente=0;
        }

        $db->prepare(
            'INSERT INTO boletas_paquete_consolidado (paquete_consolidado,tipo_paquete_consolidado, json_request, tipo_dte, ambiente, lote, tasa_aplicada, id_usuario_ejecuta) 
            VALUES(:paquete_consolidado,:tipo_paquete_consolidado,:json_request, :tipo_dte, :ambiente, :lote, :tasa_aplicada, :id_usuario_ejecuta)');
        $db->execute(
        	array(
        		':paquete_consolidado' => $columnaCodigoGuia,
        		':tipo_paquete_consolidado' => $tipoPaqueteConsolidado,
        		':json_request' => json_encode($empresa),
        		':tipo_dte' => $facturaElectronicaBoletaElectronica,
        		':ambiente' => $salidaAmbiente,
        		':lote' => $lote,
        		':tasa_aplicada' => $_POST['tipo_cambio'],
        		':id_usuario_ejecuta' => $id_usuario_ejecuta
        	)
        );

        $idBoletaInsertada = $db->lastId();

        $respuestaGeneracionBoleta=generarBoleta($tokenObj->Token, $empresa, $conf['url']);
        $respuestaDecodificada=json_decode($respuestaGeneracionBoleta);
        $idFolioObtenido=$respuestaGeneracionBoleta->Objeto->Folio;

    	// Guarda la response del servicio
    	$db->prepare("UPDATE boletas_paquete_consolidado SET json_response=:json_response, folio=:folio WHERE id=:id");
    	$db->execute(array(
    	    ':json_response' => json_encode ( $respuestaGeneracionBoleta ),
    	    ':id' => $idBoletaInsertada,
    	    ':folio' => $idFolioObtenido
    	));
    	
    	/* Respuesta del servicio
    {
        "Objeto": {
            "Folio": 14,
            "TipoDte": "33",
            "IdDte": 13253,
            "FechaRegistro": "11/7/2022 12:17:05 PM",
            "RutEmpresa": "96986730-3"
        }, */
    	
    	// Fin Guarda la response del servicio

    	if($respuestaGeneracionBoleta->Objeto->Folio!=null){
    	    
    	    $boletasProcesadasPositivas[]=$columnaCodigoGuia;

    	    $boletaPdf=obtenerPdfBoleta($tokenObj->Token, $respuestaGeneracionBoleta->Objeto->Folio, $tokenObj->EmpresaId, $respuestaGeneracionBoleta->Objeto->TipoDte, $conf['url']);
    	    // Guarda la response del servicio
        	/*$db->prepare("UPDATE boletas_paquete_consolidado SET pdfBase64=:pdfBase64, folio=:folio WHERE id=:id");
        	$db->execute(array(
        	    ':folio' => $respuestaGeneracionBoleta->Objeto->Folio ,
        	    ':pdfBase64' => $boletaPdf->DocBase64 ,
        	    ':id' => $idBoletaInsertada
        	));

        	$pdfBase64 = base64_decode($boletaPdf->DocBase64);
        	$file = fopen( $conf['path_files_boletas_absoluto'].$columnaCodigoGuia.'.pdf', "wb");
            fwrite($file, $pdfBase64);
            fclose($file);*/

            foreach($empresaParaCargos["DetallesDocumento"] as $item){
                $descripcion=$item['Descripcion'];
                $totalPesos=$item['TotalLinea'];
                $totalDolares=$item['TotalLinea'] / $_POST['tipo_cambio'];
                $precioDolarPeso=$_POST['tipo_cambio'];

                $db->prepare(
                    'INSERT INTO cargos (guia,descripcion, total_pesos, total_dolares, precio_dolar_peso) 
                    VALUES(:guia,:descripcion,:total_pesos, :total_dolares, :precio_dolar_peso)'
                );
                $db->execute(
                	array(
                		':guia' => $columnaCodigoGuia,
                		':descripcion' => $descripcion,
                		':total_pesos' => $totalPesos,
                		':total_dolares' => $totalDolares,
                		':precio_dolar_peso' => $precioDolarPeso
                	)
                );
            }
            
            
    	}else{
    	    $boletasProcesadasNegativas[]=$columnaCodigoGuia;
    	}
    	
    	//object(stdClass)#7 (3) { ["Objeto"]=> object(stdClass)#3 (5) { ["Folio"]=> int(46) ["TipoDte"]=> string(2) "33" ["IdDte"]=> int(13396) ["FechaRegistro"]=> string(21) "11/17/2022 9:35:39 PM" ["RutEmpresa"]=> string(10) "96986730-3" } ["EsError"]=> bool(false) ["ErrorDescripcion"]=> NULL }
    	
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

function generarBoleta($token, $data, $url) {

    $authorization = 'Authorization: Bearer ' . $token;
    $ch = curl_init($url.'api/DteFirma');

    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
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

?>
<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body >
	
	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
			require $conf['path_host'].'/include/include_menu_operador_local.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

<!--Inicio Contenido -->

	<!-- inicio datos cliente -->
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
<!-- Fin datos cliente -->

    <section style="margin:5%;">
    	<center>
    	    <h2>Resultado del procesamiento de Paquetes y Consolidados</h2>
    	    
    	</center>

        
        
    </section>
    
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        
                        <h3 class="text-center">Previamente procesados. </h3>
                        <h4 class="text-center">No deben ser procesados</h4>
                        
                        <?php if(empty($boletasPrevias)){?>
                            <div class="alert alert-success" role="alert">No tiene paquetes y/o consolidados procesados previamente.</div>
                        <?php }else{ ?>
                        
                            <ul class="list-group">
                                <?php foreach ($boletasPrevias as $BP){ ?>
                                    <li class="list-group-item list-group-item-warning"><?=$BP; ?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    
                    <div class="col-md-4">
                        
                        <h3 class="text-center">No procesados. </h3>
                        <h4 class="text-center"> Error durante el procesamiento</h4>
                        
                        <?php if(empty($boletasProcesadasNegativas)){?>
                            <div class="alert alert-info" role="alert">No tiene paquetes y/o consolidados con errores durante el procesamiento.</div>
                        <?php }else{ ?>
                            <ul class="list-group">
                                <?php foreach ($boletasProcesadasNegativas as $BP){ ?>
                                    <li class="list-group-item list-group-item-danger"><?=$BP; ?></li>
                                <?php } ?>
                            </ul>
                            
                        <?php }?>
                       
                    </div>
                    
                    <div class="col-md-4">
                        
                        <h3 class="text-center">Procesados Exitosamente.</h3>
                        <h4 class="text-center">Boletas generadas satisfactoriamente</h4>
                        
                        <?php if(empty($boletasProcesadasPositivas)){?>
                            <div class="alert alert-danger" role="alert">No tiene paquetes y/o consolidados procesados correctamente.</div>
                        <?php }else{?>
                            <ul class="list-group">
                                <?php foreach ($boletasProcesadasPositivas as $BP){ ?>
                                    <li class="list-group-item list-group-item-success"><?=$BP; ?></li>
                                <?php } ?>
                            </ul>
                        <?php }?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <br/>
    
    <section>
	    <div class="row">
		    <div class="col-lg-12">
        		<center><a href="index.php" class="button solid-color">VOLVER</a></center>
            </div>
        </div>
        
        <br/>
        <br/>
        <br/>
        <br/>
	
	</section>


</body>

</html>
