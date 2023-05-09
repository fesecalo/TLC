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
    // $pdf->Image('ruta de la imagen','posicion izquierda o derecha','posicion arriba o abajo','tama«Ğo de la imagen');

    $pdf=new PDF_AutoPrint();
    $header = array();
    $pdf->AddPage('P','Letter');
    
    if (isset($_GET['paquete'])) {
        $id_paquete=$_GET['paquete'];
    }else{
        die("Error al generar etiqueta.");
    }

    $db->prepare("SELECT
            codigo_consolidado,
            peso_kilos,
            numero_paquetes,
            peso_volumen
            
        FROM consolidado
        WHERE id_consolidado=:id
    ");
    $db->execute(array(':id' => $id_paquete));

    $sql_paquete=$db->get_results();

    foreach ($sql_paquete as $key => $paquete) {
        $tracking_garve=$paquete->codigo_consolidado;
        $pieza=$paquete->numero_paquetes;
        $peso=$paquete->peso_kilos;
        $peso_volumen=$paquete->peso_volumen;
    }

    $pdf->SetFont('Arial','',10);
    $pdf->SetTextColor(0,0,0);        

    $pdf->Ln();
    $pdf->SetFont('Arial','B',25);
    
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

    $pdf->Rect(10, 85, 196, 25, 'D');

    $pdf->SetFont('Arial','',12);
    $pdf->Cell(196,5,"Guia consolidado:",0,1,"L");
    $pdf->SetFont('Arial','B',25);
    $pdf->Cell(196,10,iconv("UTF-8", "ISO-8859-1", $tracking_garve),0,1,"C");
    $pdf->Cell(196,5,'',0,1,"L");

    $pdf->Rect(10, 110, 196, 40, 'D');
    // $pdf->Rect(10, 140, 196, 65, 'D');

    $pdf->Cell(196,30,'',0,1,"L");
    $pdf->Image($conf['path_host'].'/miami/etiqueta/barcode.gif',25,110,140);

    // $pdf->Ln();
    $pdf->Cell(196,15,'',0,1,"L");

    $pdf->SetFont('Arial','',15);
    $pdf->Cell(69,10,'Peso(KG):',1,0,"L");
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(78,10,$peso,1,0,"C");
    $pdf->Cell(49,10,'',1,1,"C");
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(69,10,'Total paquetes',1,0,"L");
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(78,10,$pieza,1,0,"C");
    $pdf->Cell(49,10,'',1,1,"C");
    $pdf->SetFont('Arial','',15);
    $pdf->Cell(69,10,'Peso volumetrico (KG/VOL)',1,0,"L");
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(78,10,$peso_volumen,1,0,"C");
    $pdf->Cell(49,10,'',1,1,"C");
    
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    

    $pdf->AutoPrint(true);
    $pdf->Output();
?>