<div class="contact">
      	<div class="container">
      	   <div class="contact_top">
      		<div class="col-md-3 contact_left">
      			<div class="contact_grid contact_address">
                	
					<h3>Calcula tu Compra</h3>
                    <!--p>Reg&iacute;strate GRATIS</p>
                    <p>Lo Compras</p>
                    <p>Lo Traemos</p>
                    <p>Lo Disfrutas</p-->
               
				</div>
				
      		</div>
      		<div class="col-md-9">
      			<div class="contact-form">
				   <form action="calculadora_result.php" method="post" enctype="multipart/form-data" onSubmit="javascript:return valida()" class="row" name="form1">
                  <select name="tipo_prod"  class="form-control"  id="id_tipo_prod" title="Tipo de Producto" required="required"  >
<option value="">Selecciona tipo de producto</option>
<?php mysqli_query($connection ,"SET NAMES 'utf8'"); $result4 = "select * from tipoproducto order by id_tipoproducto";
	$arr_vend = mysqli_query($connection, $result4) or die('Error en llamada 258');
	while ($Rs2 = mysqli_fetch_assoc($arr_vend)) { ?>
		<option value="<?php echo $Rs2['id_tipoproducto'] ?>" ><?php	echo $Rs2['descripcion']; ?></option>
<?php }; ?>
</select>
<script type="text/javascript">var id_tipo_prod = new LiveValidation('id_tipo_prod');id_tipo_prod.add( Validate.Presence );</script><br /><br />


					 <span>TOTAL (USD): <label>*</label></span>
					 <input id="valor_compra" name="valor_compra" size="50" maxlength="10" class="form-control" style="height:70px; font-size:120%" type="text" value="" title="Ingresa el valor total del producto en D&oacute;lares"  placeholder="Valor del producto + Shipping + TAX" required="required" >

					 <br />
  <input name="tipopeso" type="radio" value="k"> Kilogramos/Kgs&nbsp;&nbsp;
     <input name="tipopeso" type="radio" value="l"> Libras 
<input id="peso_compra" name="peso" size="50" maxlength="10" class="form-control" type="text" value="" style="height:70px; font-size:120%"  title="Ingresa el peso de tu producto"  placeholder="0"  required="required"  >	
<script type="text/javascript">var peso_compra = new LiveValidation('peso_compra');peso_compra.add( Validate.Presence );</script>
<script type="text/javascript"> numberblog(document.getElementById("peso_compra"))</script>
 <span>PESO: <label>*</label></span><br />
					 <input class="btn btn-primary btn-lg" style="float:right" style="background-color:#F60" type="submit" value="Calcular" id="submit" title="Calcular"  name="Calcular" > 
				   </form>
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