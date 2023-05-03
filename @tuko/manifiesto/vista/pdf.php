<?php
require('../fpdf/ean13.php');


$pdf=new PDF_EAN13(ORIENTA,'mm',IMP); 
$manifiesto=$p->codigo;
$nox=0;

while($r = $rwg->fetch_object()){
    $id=$r->id;
    $codigo=$r->codigo;
    $cliente=$r->cliente;
    $kilo=$r->kilo;
   
    if($nox==0){
    $pdf->AddPage();
    }
    $y=($nox*65)*GXH;
    $pdf->SetY(80+$y);
    $pdf->SetX(120);
    $pdf->UPC_A(120,(80+$y),$codigo);
    
    $pdf->SetFont("Arial","",36);
    $pdf->SetY(40+$y);
    $pdf->SetX(20);
    $pdf->Cell(0,0,EMP);
    $pdf->SetFont("Arial","",24);
    $pdf->SetY(60+$y);
    $pdf->SetX(20);
    $pdf->Cell(0,0,'MANIFIESTO COD: '.$manifiesto);
    $pdf->SetFont("Arial","",18);
    $pdf->SetY(80+$y);
    $pdf->SetX(20);
    $pdf->Cell(0,0,'CLIENTE: ');
    $pdf->SetY(90+$y);
    $pdf->SetX(20);
    $pdf->Cell(0,0,Accion::cliente($cliente));
    $pdf->SetY(110+$y);
    $pdf->SetX(20);
    $pdf->Cell(0,0,'KILOS: '.$kilo);
    $nox++;

    if(GXH==$nox){
        $nox=0;
    }
    
}

$pdf->Output();
?>