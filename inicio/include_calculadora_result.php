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
		echo "window.location.href = '../inicio/calculadora.php';";
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
$USS=725;
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
<div class="contact">
      	<div class="container">
      	   <div class="contact_top">
      		<div class="col-md-3 contact_left">
      			<div class="contact_grid contact_address">
                	
					<h3>Valor de tu Compra</h3>
                    <p>Reg&iacute;strate GRATIS</p>
                    <p>Lo Compras</p>
                    <p>Lo Traemos</p>
                    <p>Lo Disfrutas</p>
               
				</div>
				
      		</div>
      		<div class="col-md-9">
            
            <div class="contact-form">
            
           
<table class="bordered">
    <thead>
    <!--tr>
        <th>IMDB Top 10 Movies</th>
        <th>Year</th>
    </tr-->
    </thead> 
        <tr>
          <th style="color:#FFFFFF; font-weight:lighter;">Total cargos en chile	<strong></strong><br>
</th>
       
          <th align="right" style="color:#FFFFFF; font-weight:lighter;"><strong style="font-size:200%" >
		  <?php 
		  if ($valorpromocion > 0 ){ echo "Valor Promoción $".number_format($valorpromocion,0,'', '.');}else{
		  echo "$".number_format(($almacenaje + $manejoaduana+$gseguro+$transporte+($ADUANA*$USA)),0,'', '.');};
		  
		  ?>
          
          </strong></th>
          
        </tr>

</table><br>
<br>
<input class="btn btn-primary btn-lg" style="background-color:#0161AC" type="button" value="Ver cuenta en detalle" title="Mostrar" onClick="mostrar()"> 


<!-- ELEMENTOS OCULTOS-->

<div id='oculto' style='display:none;'>

<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;">IMPUESTOS</th>
        <th style="color:#FFFFFF;"><strong>Valor (CLP)</strong></th>
    </tr>
    <!--tr>
        <th>IMDB Top 10 Movies</th>
        <th>Year</th>
    </tr-->
    </thead>
    <tr>
      <td><strong>Derechos Ad-Valorem</strong></td>
      <td><strong><?php  echo "$".number_format(($ADVALOREME*$USA),0,'', '.');?>(*)</strong></td>
    </tr>
      <tr>
      <td><strong>IVA</strong></td>
      <td><strong><?php echo "$".number_format(($IVA*$USA),0,'', '.');?>(*)</strong></td>
    </tr>
      <tr>
      <td><strong>Almacenaje </strong></td>
      <td><strong><?php echo $almacenaje;?></strong></td>
    </tr> 
        <tr>
          <th style="color:#FFFFFF;"><strong>Total Impuestos</strong></th>
          <th style="color:#FFFFFF;"><strong><?php echo "$".number_format((($ADUANA*$USA) + $almacenaje),0,'', '.');?>.-</strong></th>
          
        </tr>

</table>		<br>
<br>
<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;">Cargos tlccourier</th>
        <th style="color:#FFFFFF;"><strong>Valor (CLP)</strong></th>

    </tr>
    <!--tr>
        <th>IMDB Top 10 Movies</th>
        <th>Year</th>
    </tr-->
    </thead>
    <tr>
      <td><strong>Transporte</strong></td>
      <td><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{ echo "$".number_format(($transporte),0,'', '.');};?> (*)</strong></td>
    </tr>
      <tr>
      <td><strong>Manejo Aduanal</strong></td>
      <td><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{ echo "$".number_format(($manejoaduana),0,'', '.');};?> (*)</strong></td>
    </tr>
      <tr>
        <td><strong>tlccourier Seguro</strong></td>
        <td><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{ echo "$".number_format(($gseguro),0,'', '.');};?> (*)</strong></td>
      </tr> 
        <tr>
          <th style="color:#FFFFFF;"><strong>Total Servicio Casillas </strong></th>
          <th style="color:#FFFFFF;"><strong><?php if ($valorpromocion > 0 ){ echo "$ 0";}else{echo "$".number_format(($manejoaduana+$gseguro+$transporte),0,'', '.');};?>.-</strong></th>
          
        </tr>

</table><br>
<br><br />

                <!--  CALCULADORA-->
<div class="contact-form">

                					<h3>Calcular nuevamente</h3>

				  <form action="calculadora_result.php" method="post" enctype="multipart/form-data" onSubmit="javascript:return valida()" class="row" name="form1">
            <div id="input_email" class="col-md-12"> TIPO DE PRODUCTO: 
              <select name="tipo_prod"  class="form-control"  id="id_tipo_prod" title="Tipo de Producto" required="required"  >
                <option value="">Selecciona tipo de producto</option>
                <?php $result4 = "select * from tipoproducto order by id_tipoproducto";

	$arr_vend = mysqli_query($connection,$result4) or die('Error en llamada 258');
	while ($Rs2 =mysqli_fetch_assoc($arr_vend)) { ?>
                <option value="<?php echo $Rs2['id_tipoproducto'] ?>" <?php if ($_POST['tipo_prod']== $Rs2['id_tipoproducto']){echo "selected";};?>> 
                <?php echo $Rs2['descripcion']; ?>
                </option>
                <?php }; ?>
              </select>
			<script type="text/javascript">var id_tipo_prod = new LiveValidation('id_tipo_prod');id_tipo_prod.add( Validate.Presence );</script>
            </div>
            <div id="input_email" class="col-md-12"> TOTAL (USD): 
              <input id="valor_compra" name="valor_compra" size="50" maxlength="10" class="form-control" onChange="calcula('+',2)" onFocus="if(this.value == '0.00') {this.value=''}" onBlur="if(this.value == ''){this.value ='0.00'}" type="text" value="<?php if ($_POST['valor_compra']<>""){echo $_POST['valor_compra'];}else{echo "0.00";};?>"  title="Ingresa el valor total del producto en D&oacute;lares"  placeholder="Valor del producto + Shipping + TAX"  >
              <script type="text/javascript">var valor_compra = new LiveValidation('valor_compra');valor_compra.add( Validate.Presence );</script>
              <script type="text/javascript"> numberblog(document.getElementById("valor_compra"))</script>
            </div>
            <div id="input_email" class="col-md-12"> PESO: 
              <input name="tipopeso" type="radio" value="0">
              Kilogramos/Kgs&nbsp;&nbsp; 
              <input name="tipopeso" type="radio" value="1">
              Libras 
              <input id="peso_compra" name="peso" size="50" maxlength="10" class="form-control" onChange="calcula2('+',3)" onFocus="if(this.value == '0.000') {this.value=''}" onBlur="if(this.value == ''){this.value ='0.000'}" value="<?php if ($_POST['peso']<>""){echo $_POST['peso'];};?>"  title="Ingresa el peso de tu producto"  placeholder="0"  >
              <script type="text/javascript">var peso_compra = new LiveValidation('peso_compra');peso_compra.add( Validate.Presence );</script>
              <script type="text/javascript"> numberblog(document.getElementById("peso_compra"))</script>
            </div>

 
									<!-- Submit Button -->
<div id="form_register_btn" class="text-center">

<input class="btn btn-primary btn-lg" style="float:right" style="background-color:#F60" type="submit" value="Calcular" id="submit" title="Calcular" name="Calcular"> 
</div>  
																	
</form>	
				</div>
                <!-- FIN CALCULADORA-->
</div> 
<!-- FIN EEMENTO OCULTO-->

                        	<!-- Description #1 -->	
							
                        
                        	
            
            
            </div>

            
            
      			
      		</div>
      		<div class="clearfix"> </div>
      	   </div>
      		<div class="contact-form" >
            <p>IMPORTANTE:</p>
		    <p style="font-size:80%; color:#666;">Si cotizas dos o m&aacute;s productos cuyos valores FOB, en conjunto, superen los 30 d&oacute;lares, podr&iacute;as tener que pagar impuestos de internaci&oacute;n, si estos ingresan al mismo tiempo al pa&iacute;s. Esos montos no est&aacute;n considerados en esta cotizaci&oacute;n.<br />
Compras con un costo igual o inferior a US$30,00 quedan libres de impuestos. Aduanas se reserva el derecho de valorar producto y solicitar pago de impuestos. Si llegan a Chile dos o mas productos y la suma de sus valores es superior a US$30, Aduana solicitara pago de impuestos.<br />
Compras con un valor igual o superior a US$1000,00 necesita tramite con Agente de Aduana. Consulta con Servicio al Cliente para mas detalles.<br />
Algunos productos requieren autorizaciones previa a su importaci&oacute;n (SAG, Servicio de Salud, SESMA, etc) y los cargos adicionales no est&aacute;n considerados en esta simulaci&oacute;n de cargos.<br />
Los montos que muestra la calculadora son de referencia, en funci&oacute;n de valor y peso entregado.<br />
Los cargos de Aduana son aproximados y solo se conoce su monto final al momento de emitir la Declaraci&oacute;n de Importaci&oacute;n y Pago Simult&aacute;neo (DIPS)<br />
Para acoger su compra a TLC CHI-USA el producto debe venir acompa&ntilde;ado, ademas de su factura, con un certificado de origen que informe manufactura del producto.<br />
Productos con medidas sobre los 2 metros, consultar con Servicio al Cliente.</p>
	        </div>
      	</div>
      </div>