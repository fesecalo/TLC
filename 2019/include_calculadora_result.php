<?php
include_once("../lib/conf.php");
//echo "pasa qau";
//-------CONFIGURACION-----/////////***************
	$q_rs2 = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_rs2 = mysqli_query($connection, $q_rs2) or die('Error en llamada 86');
	$ROW_CONF = mysqli_fetch_assoc($arr_rs2);
	
//***************************************************
if (isset($_POST['Calcular']) && ($_POST['Calcular']<>"")){
if ($_POST['peso'] > 30){		
		echo "<script languaje='javascript'>";
		echo "window.alert('El peso de su producto excede los 30 kilos, favor comunicarse con servicio al cliente de tlccourier.');";
		echo "window.location.href = '../2019/calculadora.php';";
		echo "</script>";
}
if (isset($_POST['valor_compra']) && ($_POST['valor_compra'] > 0)){
//variables recibidas
//echo "<br><br><br>";
/*echo "tipo ".$_POST['tipo_prod']."<br>";
echo "compra".$_POST['valor_compra']."<br>";
echo "tipopeso".$_POST['tipopeso']."<br>";
echo "peso".$_POST['peso']."<br>";*/
$libra = 0.45359237;
$USS=710;
$USA=691.36;

if ($_POST['tipopeso'] == 1){$tipodepeso = "Libras";}else{$tipodepeso="Kilogramos";};
if (isset($_POST['tipopeso']) && ($_POST['tipopeso']==1)){$Vpeso = $_POST['peso'] * $libra;}else{$Vpeso = $_POST['peso'];};
//echo "tipo p".$Vtipoproducto."<br>";
//echo "vpeso".$Vpeso."<br>";




$FOB = $_POST['valor_compra'];
//echo "fob".$FOB."<br>";
if (isset($Vpeso) && ($Vpeso<>"")){

//KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

mysqli_query($connection ,"SET NAMES 'utf8'");
$resf = "select * from valorpeso order by id_valorpeso";
$arr_resf = mysqli_query($connection,$resf) or die('Error en llamada 43');
$pesoanterior =0;
while ($RSVASf = mysqli_fetch_assoc($arr_resf)) { 
		if (($_POST['peso'] < $RSVASf['peso']) && ($_POST['peso'] >= $pesoanterior )){ $vvpp = $tarifaanterior; break; };
		$pesoanterior = $RSVASf['peso'];
		$tarifaanterior = $RSVASf['tarifa'];
 };
//KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK
};
$transporte = $vvpp;
//exit();
$res = "select * from valoradse order by id_valoradse";
$arr_res = mysqli_query($connection,$res) or die('Error en llamada 258');
$fobanterior =0;
while ($RSVAS =mysqli_fetch_assoc($arr_res)) { 
		
		if (($FOB < $RSVAS['valorfob']) && ($FOB >= $fobanterior )){ $manejoaduana = $RSVAS['manejoaduana']; $gseguro = $RSVAS['garveseguro'];};
		
		$fobanterior = $RSVAS['valorfob'];
 };
//echo "manejoaduana".$manejoaduana."<br>";
//echo "gseguro".$gseguro."<br>";
$CIFa = (($FOB *1.02) + ($transporte/520));
$CIF = number_format($CIFa, 2, '.', '');
//echo "cif".$CIF."<br>";

	if ($FOB >30){
		if (isset($_POST['tipo_prod']) && ($_POST['tipo_prod']==4)){$ADVALOREM = $CIF * 0.06 ;}else{$ADVALOREM = 0;};
		$ADVALOREME = number_format($ADVALOREM, 2, '.', '');
		$IVAa = (($ADVALOREME + $CIF)* 0.19) ;
		$IVA = number_format($IVAa, 2, '.', '');
		$ADUANAa = $IVAa + $ADVALOREM;
		$ADUANA = number_format($ADUANAa, 2, '.', '');
	}else{
		$ADUANA = 0;
		$ADVALOREME = 0;
		$IVA = 0;
	}
}
//echo "impuesto aduana".$ADUANA."<br>";
//echo "advalorem".$ADVALOREME."<br>" ;
//echo "IVA".$IVA."<br>";
if (($FOB<>0) && ($FOB > 30)){$almacenaje = $USS;}else{$almacenaje = 0;};
if (($_POST['peso'] <= 0.5) && ($_POST['valor_compra'] <=30) && ($transporte > 2500)){$valorpromocion=5000;}else{$valorpromocion=0;};



	
	$q_insert = "INSERT INTO registro_calculadora 
	(ippublica,producto,valor,peso,tipo_peso)	VALUES	
	('". $_SERVER['REMOTE_ADDR']."','".cargatippoproducto($_POST['tipo_prod'])."','".$_POST['valor_compra']."','".$_POST['peso']."','".$tipodepeso."') ";
	//echo $q_insert;
	$arr_i = mysqli_query($connection,$q_insert) or die('Error en llamada 15');
	$RS_INSERTA = mysqli_fetch_assoc($arr_i);

//######################################################################################################################
}
//INSERTA REGISTRO INFO
function cargatippoproducto($a){
global $connection;   
	$qr_com = "select * from tipoproducto where id_tipoproducto = '".$a."' limit 1";
	$arr_com = mysqli_query($connection,$qr_com) or die('Error en llamada 322');
	$ROW_COM = mysqli_fetch_assoc($arr_com);
	return $ROW_COM['descripcion'];
}
	
?>


<div class="block type-2 scroll-to-block" data-id="about">
                <div class="container-fluid type-2-text">
                    <div class="row">
                        <div class="image-block mob-hide wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="center-image" src="img/content/Home-1/big_content_image_8.jpg" alt=""/>
                        </div>
                        <div class="col-md-4 col-md-offset-7 col-sm-12 col-sm-offset-0 wow fadeInRight" data-wow-delay="0.3s">
                            <article class="normall">
                                <h2 class="h2 titel-left">RESULTADO</h2>

                                <div class="col-md-7 col-md-offset-1 wow fadeInRight" data-wow-delay="0.3s" style="width:100%;">
                            
                            
   <table class="table">
    <thead>
   
    </thead> 
        <tr bgcolor="#0247AD">
          <th style="color:#FFFFFF;">Total cargos en chile	<strong></strong><br>
</th>
       
          <th align="right" style="color:#FFFFFF"><strong style="font-size:200%; color:#FFFFFF;">
		  <?php 
		  if ($valorpromocion > 0 ){ echo "Valor Promoción $".number_format($valorpromocion,0,'', '.');}else{
		  echo "$".number_format(($manejoaduana+$gseguro+$transporte+($ADUANA*$USA)),0,'', '.');};
		  
		  ?>
          
          </strong></th>
          
        </tr>

</table><br>
<br>
<input class="btn btn-primary btn-lg" style="background-color:#0161AC" type="button" value="Ver cuenta en detalle" title="Mostrar" onClick="mostrar()"> 


<!-- ELEMENTOS OCULTOS-->

<div id='oculto' style='display:none;'>
<div class="table-responsive"><br />
<br />
<br />

<table class="table">

    <tr bgcolor="#0247AD">
        <th style="color:#FFFFFF">IMPUESTOS</th>
        <th style="color:#FFFFFF"><strong>Valor (CLP)</strong></th>
    </tr>
   
    <tr>
      <td><strong>Derechos Ad-Valorem</strong></td>
      <td><strong><?php  echo "$".number_format(($ADVALOREME*$USA),0,'', '.');?>(*)</strong></td>
    </tr>
      <tr>
      <td><strong>IVA</strong></td>
      <td><strong><?php echo "$".number_format(($IVA*$USA),0,'', '.');?>(*)</strong></td>
    </tr>
    
           <tr bgcolor="#0247AD">

          <th style="color:#FFFFFF"><strong>Total Impuestos</strong></th>
          <th style="color:#FFFFFF"><strong><?php echo "$".number_format((($ADUANA*$USA)),0,'', '.');?>.-</strong></th>
          
        </tr>

</table>	
</div>


	<br>
<br>
<div class="table-responsive">
<table class="table">

    <tr bgcolor="#0247AD">
        <th style="color:#FFFFFF">Cargos tlccourier</th>
        <th style="color:#FFFFFF"><strong>Valor (CLP)</strong></th>

    </tr>
   
    <tr>
      <td><strong>Transporte</strong></td>
      <td><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{ echo "$".number_format(($transporte),0,'', '.');};?> (*)</strong></td>
    </tr>
      <tr>
                <td><strong>Manejo Operacional</strong></td>
      <td><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{ echo "$".number_format(($manejoaduana),0,'', '.');};?> (*)</strong></td>
    </tr>
     
            <tr bgcolor="#0247AD">

          <td style="color:#FFFFFF"><strong>Total Servicio Casillas </strong></td>
          <td style="color:#FFFFFF"><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{echo "$".number_format(($manejoaduana+$transporte),0,'', '.');};?>.-</strong></td>
          
        </tr>

</table><br>                         
      </div>                      
                            
                            
                            
                            
                            
                            

<div class="clearfix"> </div>
<p style="font-weight:bolder;">IMPORTANTE:</p>

<p >*Peso m&iacute;nimo para simular: 0.1 Kg. (100 grs.),
(Los montos que muestra la calculadora son de referencia, en funci&oacute;n de valor y peso entregado.).<br />

		    Si cotizas dos o m&aacute;s productos cuyos valores FOB, en conjunto, superen los 30 d&oacute;lares, podr&iacute;as tener que pagar impuestos de internaci&oacute;n, si estos ingresan al mismo tiempo al pa&iacute;s. Esos montos no est&aacute;n considerados en esta cotizaci&oacute;n.<br />
Compras con un costo igual o inferior a US$30,00 quedan libres de impuestos. Aduanas se reserva el derecho de valorar producto y solicitar pago de impuestos. Si llegan a Chile dos o mas productos y la suma de sus valores es superior a US$30, Aduana solicitara pago de impuestos.<br />
Compras con un valor igual o superior a US$1000,00 necesita tramite con Agente de Aduana. Consulta con Servicio al Cliente para mas detalles.<br />
Algunos productos requieren autorizaciones previa a su importaci&oacute;n (SAG, Servicio de Salud, SESMA, etc) y los cargos adicionales no est&aacute;n considerados en esta simulaci&oacute;n de cargos.<br />
Los montos que muestra la calculadora son de referencia, en funci&oacute;n de valor y peso entregado.<br />
Los cargos de Aduana son aproximados y solo se conoce su monto final al momento de emitir la Declaraci&oacute;n de Importaci&oacute;n y Pago Simult&aacute;neo (DIPS)<br />
Para acoger su compra a TLC CHI-USA el producto debe venir acompa&ntilde;ado, ademas de su factura, con un certificado de origen que informe manufactura del producto.<br />
Productos con medidas sobre los 2 metros, consultar con Servicio al Cliente.</p>
                            
                         
                         
                   
				
				
                       
                       
     
                       
			
                        </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>