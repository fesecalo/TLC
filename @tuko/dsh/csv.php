<?php
$p = new datos();
$p->fi=(isset($_GET['fi'])?date("d-m-Y", strtotime($_GET['fi'])):"01-".date("m-Y"));
$p->ff=(isset($_GET['ff'])?date("d-m-Y", strtotime($_GET['ff'])):date("d-m-Y"));
$p = $p->traeFiltroCsv();

$delimiter = ";";
$filename = "MTO_" . date('Y-m-d') . ".csv";

//create a file pointer
$f = fopen('php://memory', 'w');

//set column headers
$fields = array('Manifiesto','Socio','Tipo','Cant.P.','Kilos','Fecha Ingreso','Estado Manifiesto','Nro Guia','Cliente','Kilos Guia','Comprobante','Neto Guia','Iva Guia','Total Guia','Documento','Nro Doc.','Total Doc.','Estado Guia','Fecha Guia','Observaciones');
fputcsv($f, $fields, $delimiter);
    
while($r = $p->fetch_object()){
    $codigo=$r->codigo;
    $origen=isset($r->origen)?Accion::origen($r->origen):'';
    $tipo=isset($r->tipo)?Accion::tipoManifiesto($r->tipo):'';
    $cantidad=$r->cantidad;
    $kilo=$r->kilo;
    $fecha=$r->fecha;
    $estado=isset($r->estado)?Accion::estadoManifiestoCSV($r->estado):'';
    $guia=$r->guia;
    $cliente=isset($r->cliente)?Accion::cliente($r->cliente):'';
    $kiloGuia=$r->kiloGuia;
    $tipoGuia=isset($r->tipoGuia)?Accion::tipoGuia($r->tipoGuia):'';
    $neto=$r->neto;
    $iva=$r->iva;
    $total=$r->total;
    $documento=isset($r->documento)?Accion::tipoDocumento($r->documento):'';
    $din=$r->din;
    $totalDin=$r->totalDin;
    $estadoGuia=isset($r->estadoGuia)?Accion::estadoGuiaCSV($r->estadoGuia):'';
    $fechaGuia=$r->fechaGuia;
    $observacion=$r->observacion;

    $lineData = array($codigo,$origen,$tipo,$cantidad,$kilo,$fecha,$estado,$guia,$cliente,$kiloGuia,$tipoGuia,$neto,$iva,$total,$documento,$din,$totalDin,$estadoGuia,$fechaGuia,$observacion);
    fputcsv($f, $lineData, $delimiter);
}
    
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
fpassthru($f);
?>