<?php
// function etiqueta_pdf($id){
    require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/fpdf17/fpdf.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';

    class PDF_JavaScript extends FPDF {

        var $javascript;
        var $n_js;

        function IncludeJS($script) {
            $this->javascript=$script;
        }

        function _putjavascript() {
            $this->_newobj();
            $this->n_js=$this->n;
            $this->_out('<<');
            $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
            $this->_out('>>');
            $this->_out('endobj');
            $this->_newobj();
            $this->_out('<<');
            $this->_out('/S /JavaScript');
            $this->_out('/JS '.$this->_textstring($this->javascript));
            $this->_out('>>');
            $this->_out('endobj');
        }

        function _putresources() {
            parent::_putresources();
            if (!empty($this->javascript)) {
                $this->_putjavascript();
            }
        }

        function _putcatalog() {
            parent::_putcatalog();
            if (!empty($this->javascript)) {
                $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
            }
        }
    }

    class PDF_AutoPrint extends PDF_JavaScript{

        function AutoPrint($dialog=false){
            //Open the print dialog or start printing immediately on the standard printer
            $param=($dialog ? 'true' : 'false');
            $script="print($param);";
            $this->IncludeJS($script);
        }

        function AutoPrintToPrinter($server, $printer, $dialog=false){
            //Print on a shared printer (requires at least Acrobat 6)
            $script = "var pp = getPrintParams();";
            if($dialog)
                $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            else
                $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
            $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
            $script .= "print(pp);";
            $this->IncludeJS($script);
        }
    }

    header('Content-Type: text/html; charset=utf-8');

    if (!class_exists('PDF')) {
        class PDF extends FPDF{
            public function Header(){                
               
            }
        }
        function Footer(){

        }
        function LoadData($tb){
            $data = array();
            return $data;
        }

        function BasicTable($header, $data, $tb){

        }

        $pdf = new PDF();
        $header = array();
    }

    // $pdf->Cell(largo celda,ancho celda,'contenido',margen(1 o 0),salto de linea(1 o 0),alineacion("L" o "R" o "C");
    // $pdf->Image('ruta de la imagen','posicion izquierda o derecha','posicion arriba o abajo','tamaño de la imagen');

    $pdf=new PDF_AutoPrint();
    $header = array();
    $pdf->AddPage('P','Letter');

    if (isset($_GET['total'])) {
        if($_GET['total']==''){
            $total_paquete=1;
        }else{
            if($_GET['total']==0){
                $total_paquete=1;
            }else{
                $total_paquete=$_GET['total'];
            }
        }
    }else{
        $total_paquete=1;
    }
    
    if (isset($_GET['paquete'])) {
        $id_paquete=$_GET['paquete'];
    }else{
        die("Error al generar etiqueta.");
    }
    

    for ($i=1; $i <($total_paquete+1) ; $i++) {
    
        $db->prepare("SELECT 
                    paquete.consignatario,
                    paquete.id_usuario,
                    usuario.direccion,
                    comuna.nombre_comuna,
                    region.nombre_region,
                    paquete.descripcion_producto,
                    paquete.tracking_garve,
                    paquete.pieza,
                    paquete.peso,
                    paquete.peso_volumen,

                    region.id_region

            FROM paquete as paquete
            LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
            LEFT JOIN comunas AS comuna ON comuna.id_comuna=usuario.id_comuna
            LEFT JOIN region AS region ON region.id_region=usuario.id_region
            WHERE paquete.id_paquete=:id
            ORDER BY paquete.id_paquete ASC
        ",true);
        $db->execute(array(':id' => $id_paquete));

        $sql_paquete=$db->get_results();

        foreach ($sql_paquete as $key => $paquete) {
            $consignatario=$paquete->consignatario;
            $id_cliente=$paquete->id_usuario;
            $direccion=$paquete->direccion;
            $nombre_comuna=$paquete->nombre_comuna;
            $nombre_region=$paquete->nombre_region;
            $producto=$paquete->descripcion_producto;
            $tracking_garve=$paquete->tracking_garve;
            $pieza=$paquete->pieza;
            $peso=$paquete->peso;
            $pesoVolumen=$paquete->peso_volumen;

            $id_region=$paquete->id_region;
        }

        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(0,0,0);        

        $pdf->Ln();
        $pdf->SetFont('Arial','B',25);

        if ($id_region==0) {
            $pdf->Cell(26,20,'N/A',1,0,"C");
        }elseif ($id_region==13) {
            $pdf->Cell(26,20,'SCL',1,0,"C");
        }else{
            $pdf->Cell(26,20,'R',1,0,"C");
        }
        
        $pdf->Cell(170,20,iconv("UTF-8", "ISO-8859-1", $conf['path_company_name']),0,1,"L");

        // $pdf->Rect("posicion izquierda o derecha","arriba o abajo","ancho","alto","estilo, puede ser D, F o DF");
        $pdf->Rect(10, 10, 196, 75, 'D');

        $pdf->SetFont('Arial','',20);
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $conf['path_direccion']),0,1,"L");
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $conf['path_ciudad']),0,1,"L");
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $conf['path_pais']),0,1,"L");
        $pdf->Cell(196,5,'',0,1,"L");
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $conf['path_phono']),0,1,"L");
        $pdf->Cell(196,10,'',0,1,"L");

        $pdf->Rect(10, 85, 196, 35, 'D');

        $pdf->SetFont('Arial','',15);
        $pdf->Cell(196,10,'Consignatario:',0,1,"L");
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $consignatario),0,1,"L");
        $pdf->Cell(196,10,$conf['path_cuenta']."".$id_cliente,0,1,"L");
        $pdf->Ln();

        $pdf->Rect(10, 120, 196, 20, 'D');

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(196,5,"Guia:",0,1,"L");
        $pdf->SetFont('Arial','B',25);
        $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $tracking_garve),0,1,"C");
        $pdf->Cell(196,5,'',0,1,"L");


        $pdf->Rect(10, 140, 196, 65, 'D');

        $pdf->Cell(196,30,'',0,1,"L");
        $pdf->Image($conf['path_host'].'/miami/etiqueta/barcode.gif',25,140,150);

        $pdf->SetFont('Arial','',15);
        $pdf->Cell(69,10,'Peso(KG):',1,0,"L");
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(78,10,$peso,1,0,"C");
        $pdf->Cell(49,10,'',1,1,"C");
        $pdf->SetFont('Arial','',15);
        $pdf->Cell(69,10,'Peso volumetrico (KG/VOL)',1,0,"L");
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(78,10,$pesoVolumen,1,0,"C");
        $pdf->Cell(49,10,'',1,1,"C");
        $pdf->SetFont('Arial','',15);
        $pdf->Cell(69,10,'Paquete',1,0,"L");
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(78,10,$i.' de '.$total_paquete,1,0,"C");
        $pdf->Cell(49,10,'',1,1,"C");
        
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
    }

    $pdf->AutoPrint(true);
    $pdf->Output();
?>