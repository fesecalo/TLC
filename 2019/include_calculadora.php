


<div class="block type-2 scroll-to-block" data-id="about">
                <div class="container-fluid type-2-text">
                    <div class="row">
                        <div class="image-block mob-hide wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="center-image" src="img/content/Home-1/big_content_image_8.jpg" alt=""/>
                        </div>
                        <div class="col-md-4 col-md-offset-7 col-sm-12 col-sm-offset-0 wow fadeInRight" data-wow-delay="0.3s">
                            <article class="normall">
                                <h2 class="h2 titel-left">CALCULA TU COMPRA</h2>
                                <p>Calcula el precio de tu compra en moneda local y sin sorpresas.</p><br />

                                <div class="col-md-7 col-md-offset-1 wow fadeInRight" data-wow-delay="0.3s" style="width:100%;">
                            
                            <form action="calculadora_result.php" method="post" enctype="multipart/form-data"  name="form1">

 
 <!---TIPO DE PRODUCTO-->
 <label style="font-weight:bolder; color:#0247AD;">TIPO DE PRODUCTO:</label>
 <select name="tipo_prod"  style="margin-left:-5px; color:#999; font-size:100%;border:1px solid #999;" class="form-control"  id="id_tipo_prod" title="Selecciona tipo de producto" required="required"  >
 
<option value="">Selecciona tipo de producto</option>
<?php mysqli_query($connection ,"SET NAMES 'utf8'"); $result4 = "select * from tipoproducto order by id_tipoproducto";
	$arr_vend = mysqli_query($connection, $result4) or die('Error en llamada 258');
	while ($Rs2 = mysqli_fetch_assoc($arr_vend)) { ?>
		<option value="<?php echo $Rs2['id_tipoproducto'] ?>" ><?php	echo $Rs2['descripcion']; ?></option>
<?php }; ?>
</select>
 


   <br />
<!---Valor del producto + Shipping + TAX-->  
   <label style="font-weight:bolder; color:#0247AD;">TOTAL (USD:</label>                        
<input class="form-control"   style="border:1px solid #999;width: 95%; padding:6px 15px; 
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
input[type=number] { -moz-appearance:textfield;" placeholder="Valor del producto + Shipping + TAX" value="" id="valor_compra" name="valor_compra"  type="number" required="required"  >
<br />
<label style="float:left; font-weight:bolder; color:#0247AD;">PESO:</label>
<div class="checkbox-entry radio">
<input id="chek" name="tipopeso" type="radio" value="k" > <label>Kilogramos/Kgs&nbsp;&nbsp;</label>
     
     </div>
 <div class="checkbox-entry radio">
<input id="chek" name="tipopeso" type="radio" value="l"> <label>Libras </label>
     </div>
    
     
<input id="peso_compra" name="peso" size="50" maxlength="10" class="form-control" type="number" value="" style="border:1px solid #999;width: 95%; padding:6px 15px; 
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
input[type=number] { -moz-appearance:textfield;"  placeholder="0"  required="required"  >	
<script type="text/javascript"> numberblog(document.getElementById("peso_compra"))</script>

                         
                     <div class="clearfix"> </div>
				    
                                
                                
 
                     
                                <div class="submit-wraper">
<!--div class="button">CALCULA TU COMPRA <input  style="background-color:#F60" type="submit" value="Calcular" id="submit" title="Calcular"  name="Calcular" >
              
              </div--> 
                                </div>
                                
                                         
                                
                            </form>

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