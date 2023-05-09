<?php
    require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/fpdf17/fpdf.php';

    // funcion fecha actual tiene que ir despues de la conexion PDO
    require $conf['path_host'].'/funciones/fecha_actual.php';

    $id_transaccion=$_GET['num_recibo'];
    // $id_transaccion=20;

    $db->prepare("SELECT
            transaccion.id_cliente,
            transaccion.numero_recibo,
            transaccion.total,
            transaccion.total_aduana

        FROM transaccion AS transaccion
        WHERE id_transaccion=:id
    ");
    $db->execute(array(':id' => $id_transaccion ));
    $resTransaccion=$db->get_results();

    foreach ($resTransaccion as $key => $transaccion) {
        $id_cliente=$transaccion->id_cliente;
        $numero_recibo=$transaccion->numero_recibo;
        $total=$transaccion->total;
        $total_aduana=$transaccion->total_aduana;
    }

    $db->prepare("SELECT
            detalle.id_tipo_pago,
            tipo_pago.tipo_pago,
            banco.nombre_banco,
            tarjeta.nombre_tarjeta,
            cheque.nombre_tipo_cheque,
            detalle.monto,
            detalle.monto_pagado,
            detalle.vuelto,
            detalle.numero_cuenta,
            detalle.rut_pago,
            detalle.numero_documento,
            detalle.comprobante,
            detalle.descripcion

        FROM transaccion_detalle AS detalle
        LEFT JOIN data_tipo_pago AS tipo_pago ON tipo_pago.id_tipo_pago=detalle.id_tipo_pago
        LEFT JOIN data_banco AS banco ON banco.id_banco=detalle.id_banco
        LEFT JOIN data_tipo_tarjeta AS tarjeta ON tarjeta.id_tipo_tarjeta=detalle.id_tipo_tarjeta
        LEFT JOIN data_tipo_cheque AS cheque ON cheque.id_tipo_cheque=detalle.id_tipo_cheque
        WHERE id_transaccion=:id
    ");
    $db->execute(array(':id' => $id_transaccion ));
    $resDetalleTransaccion=$db->get_results();

        $forma_pago=1;
        $tipo_pago=1;
        $impuesto_pago_tarjeta=1;
        $total_pago=1;

    $db->prepare("SELECT
            paquete.id_usuario,
            paquete.pieza,
            paquete.descripcion_producto,
            paquete.tracking_garve,
            paquete.numero_miami,
            
            cargo.aduana,
            cargo.flete,
            cargo.manejo,
            cargo.proteccion,
            cargo.total
                
        FROM paquete AS paquete
        INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo
        WHERE id_transaccion=:id
        AND cargo.eliminado=0
    ");
    $db->execute(array(':id' => $id_transaccion ));
    $resPaquetes=$db->get_results();

    $db->prepare("SELECT

            cliente.nombre,
            cliente.apellidos,
            cliente.rut,
            cliente.direccion,
            cliente.telefono,
            cliente.email,

            comuna.nombre_comuna,

            region.nombre_region

        FROM  gar_usuarios AS cliente
        INNER JOIN comunas AS comuna ON comuna.id_comuna=cliente.id_comuna
        INNER JOIN region AS region ON region.id_region=cliente.id_region
        
        WHERE cliente.id_usuario=:id
    ");
    $db->execute(array(':id' => $id_cliente));
    $resRecibo=$db->get_results();

    foreach ($resRecibo as $key => $recibo) {
        $nombre=$recibo->nombre;
        $apellidos=$recibo->apellidos;
        $rut=$recibo->rut;
        $direccion=$recibo->direccion;
        $telefono=$recibo->telefono;
        $email=$recibo->email;
        $nombre_comuna=$recibo->nombre_comuna;
        $nombre_region=$recibo->nombre_region;
    }

    
    

    header('Content-Type: text/html; charset=utf-8');

    if (!class_exists('PDF')) {
        class PDF extends FPDF
        {
        // Load data
            public function Header(){                

            }
        }
        function Footer(){

        }
        function LoadData($tb){
            // Read file lines
            $data = array();
            return $data;
        }

        // Simple table
        function BasicTable($header, $data, $tb){

        }

        $pdf = new PDF();
        // Column headings

        $header = array();
        // Data loading
    }

    // $pdf->Cell(largo celda,ancho celda,'contenido',margen(1 o 0),salto de linea(1 o 0),alineacion("L" o "R" o "C");
    // $pdf->Image('ruta de la imagen','posicion izquierda o derecha','posicion arriba o abajo','tamaño de la imagen');

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $header = array();
    $pdf->AddPage('P','Letter');

    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);        
        $pdf->Image($conf['path_host'].'/img/logo-tlc-azul.png',10,5,20);
        $pdf->SetFont('Arial','b',11);
        $pdf->cell(0,10,"DETALLE DE ENTREGA",0,0,"C");
        
        $pdf->Ln();
        $pdf->Ln();

        // $pdf->Rect("posicion izquierda o derecha","arriba o abajo","ancho","alto","estilo, puede ser D, F o DF");
        $pdf->Rect(10, 30, 65, 15, 'D');

        $pdf->SetFont('Arial','',8);
        $pdf->cell(65,5,"Marchant Pereira 433",0,0,"L");
        $pdf->cell(66,5,"",0,0,"C");
        $pdf->cell(22,5,"Fecha",1,0,"L");
        $pdf->cell(43,5,date("d/m/Y",strtotime($fecha_actual)),1,1,"C");

        $pdf->cell(65,5,"Providencia - Santiago",0,0,"L");
        $pdf->cell(66,5,"",0,0,"C");
        $pdf->cell(22,5,"Recibo N".iconv("UTF-8", "ISO-8859-1", "°"),1,0,"L");
        $pdf->cell(43,5,$numero_recibo,1,1,"C");

        $pdf->cell(65,5,"Tel".iconv("UTF-8", "ISO-8859-1", "é")."fonos: (562)27898174 - (562)27898129",0,0,"L");
        $pdf->cell(66,5,"",0,1,"C");

        $pdf->Ln();
        $pdf->Rect(10, 55, 196, 25, 'D');

        $pdf->SetFont('Arial','b',11);
        $pdf->cell(32,5,"Para:",0,1,"L");

        $pdf->SetFont('Arial','',8);
        $pdf->cell(32,5,"Nombre:",0,0,"L");
        $pdf->cell(164,5,iconv("UTF-8", "ISO-8859-1",$nombre)." ".iconv("UTF-8", "ISO-8859-1",$apellidos),0,1,"L");

        $pdf->cell(32,5,"RUT:",0,0,"L");
        $pdf->cell(164,5,$rut,0,1,"L");

        $pdf->cell(32,5,"Direcci".iconv("UTF-8", "ISO-8859-1", "ó")."n:",0,0,"L");
        $pdf->cell(164,5,iconv("UTF-8", "ISO-8859-1",$direccion).", ".iconv("UTF-8", "ISO-8859-1",$nombre_comuna).", ".iconv("UTF-8", "ISO-8859-1",$nombre_region),0,1,"L");

        $pdf->cell(32,5,"Fono contacto:",0,0,"L");
        $pdf->cell(164,5,iconv("UTF-8", "ISO-8859-1",$telefono),0,1,"L");

        $pdf->cell(32,5,"Email:",0,0,"L");
        $pdf->cell(164,5,iconv("UTF-8", "ISO-8859-1",$email),0,1,"L");

        $pdf->Ln();

        $pdf->SetFont('Arial','b',11);
        $pdf->cell(32,5,"Detalle:",0,1,"L");

        $pdf->SetFont('Arial','',8);

        $pdf->cell(13,5,"Cantidad",1,0,"C");
        $pdf->cell(18,5,"Guia",1,0,"C");
        $pdf->cell(75,5,"Descripci".iconv("UTF-8", "ISO-8859-1", "ó")."n",1,0,"C");
        $pdf->cell(18,5,"Aduana",1,0,"C");
        $pdf->cell(18,5,"Flete",1,0,"C");
        $pdf->cell(18,5,"Manejo",1,0,"C");
        $pdf->cell(18,5,"Proteccion",1,0,"C");
        $pdf->cell(18,5,"Total",1,1,"C");

        $pdf->Ln();

        foreach ($resPaquetes as $key => $paquete) {
            $pdf->cell(13,5,$paquete->pieza,0,0,"C");
            $pdf->cell(18,5,$paquete->tracking_garve,0,0,"C");
            $pdf->cell(75,5,iconv("UTF-8", "ISO-8859-1", substr($paquete->descripcion_producto, 0, 35)),0,0,"C");
            $pdf->cell(18,5,"$ ".number_format($paquete->aduana),0,0,"R");
            $pdf->cell(18,5,"$ ".number_format($paquete->flete),0,0,"R");
            $pdf->cell(18,5,"$ ".number_format($paquete->manejo),0,0,"R");
            $pdf->cell(18,5,"$ ".number_format($paquete->proteccion),0,0,"R");
            $pdf->cell(18,5,"$ ".number_format($paquete->total),0,1,"R");
        }

        $pdf->Ln();
        $pdf->SetFont('Arial','b',8);

        $pdf->Ln();
        $pdf->cell(178,5,"Subtotal:",1,0,"L");
        $pdf->cell(18,5,"$ ".number_format($total),1,1,"R");
        $pdf->cell(178,5,"Recargo:",1,0,"L");
        $pdf->cell(18,5,"$ ".number_format(round($total_aduana)),1,1,"R");

        $pdf->Ln();

        foreach ($resDetalleTransaccion as $key => $detalle) {
            if($detalle->id_tipo_pago==1){
                $pdf->cell(178,5,"Tipo de pago:".iconv("UTF-8", "ISO-8859-1", $detalle->tipo_pago),1,0,"L");
                $pdf->cell(18,5,"$ ".number_format($detalle->monto),1,1,"R");
                $pdf->cell(178,5,"Pagado:",1,0,"L");
                $pdf->cell(18,5,"$ ".number_format($detalle->monto_pagado),1,1,"R");
                $pdf->cell(178,5,"vuelto:",1,0,"L");
                $pdf->cell(18,5,"$ ".number_format($detalle->vuelto),1,1,"R");
                $pdf->Ln();
            }elseif($detalle->id_tipo_pago==5){
                $pdf->cell(178,5,"Tipo de pago:".iconv("UTF-8", "ISO-8859-1", $detalle->tipo_pago),1,0,"L");
                $pdf->cell(18,5,"$ ".number_format($detalle->monto),1,1,"R");
                $pdf->Ln();
            }else{
                $pdf->cell(178,5,"Tipo de pago:".iconv("UTF-8", "ISO-8859-1", $detalle->tipo_pago),1,0,"L");
                $pdf->cell(18,5,"$ ".number_format($detalle->monto),1,1,"R");
                $pdf->Ln();
            }
        }

        $pdf->Ln();

        $pdf->cell(98,30,"Recibo conforme: ___________________________________",1,0,"L");

        $db->prepare("SELECT sum(monto) AS totalFinal FROM transaccion_detalle WHERE id_transaccion=:id_transaccion");
        $db->execute(array(':id_transaccion' => $id_transaccion));
        $resTotalFinal=$db->get_results();

        $pdf->SetFont('Arial','b',14);
        $pdf->cell(49,30,"TOTAL:",1,0,"R");
        $pdf->cell(49,30,"$ ".number_format($resTotalFinal[0]->totalFinal),1,1,"C");

        $pdf->SetTextColor(252, 34, 34);
        $pdf->SetFont('Arial','b',14);
        $pdf->cell(196,30,"PAGADO PENDIENTE DE ENTREGA",0,0,"C");

        $pdf->Output($conf['path_files_comprobante'].'/'.$numero_recibo.'.pdf','F');
        $pdf->Output();

?>