<?php
include_once("../lib/conf.php");
	$q_rs32 = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_rs32 = mysqli_query($connection, $q_rs32) or die('Error en llamada 86');
	$ROW_CONF3 = mysqli_fetch_assoc($arr_rs32);

?>
<script language="JavaScript">
<!--
<?php 
$sstq="select * from comunas";
$slinkq = mysqli_query($connection, $sstq) or die('Error en llamada 76r');
while ($srow3q = mysqli_fetch_assoc($slinkq)) { 
$sajys.= '"'.$srow3q['nombre_comuna'].'",';
$iajys.= $srow3q['id_comuna'].',';
$ajys.= $srow3q['id_region'].',';
}
$sajys = substr($sajys,0,(strlen($sajys)-1));
$iajys = substr($iajys,0,(strlen($iajys)-1));
$ajys = substr($ajys,0,(strlen($ajys)-1));
?>


function act_categoria (parent_select, curr_id) {
categoria = new Array(4);
categoria[0] = new Array (<?php echo $iajys?>); 
categoria[1] = new Array (<?php echo $sajys?>);
categoria[2] = new Array (<?php echo $ajys?>);

// Sincronización dinámica de areas y subareas
// programado por PIMENTON

var current_parent_id = parent_select.options[parent_select.selectedIndex].value; // id para filtrar
var currSelect = document.form1["subcategoria"];

currSelect.length = 0;
var myOption = new Option("[Seleccione Comuna]", "", true, true);
currSelect.options[currSelect.length] = myOption;

var CurrItem = 1;
for (var i=0; i < categoria[0].length; i++) {
	if (categoria[2][i] == current_parent_id) {
		var myOption = new Option(categoria[1][i], categoria[0][i]);
		currSelect.options[CurrItem++] = myOption;
	}
}

currSelect.selectedIndex = 0;

if (! isNaN(curr_id)) {
	for (var i=0; i < currSelect.length; i++) {
		if (currSelect.options[i].value == curr_id)  {
			currSelect.selectedIndex = i;
		}
	}
}

}

//-->//-->
</script>
<script language="Javascript"> 
function aparecer(id) {
	var d = document.getElementById(id);
	d.style.display = "block";
	d.style.visibility = "visible";
}
function ocultar(id) {
	var d = document.getElementById(id);
	d.style.display = "none";
	d.style.visibility = "hidden";
}
window.onload = function () {
	//Al cargar la página se oculta el div de consulta
	ocultar("condiciones");
}
</script> 




<!--   FIN VALIDACION de RUT/-->
<div class="contact">
      	<div class="container">
      	   <div class="register" style="margin-left:20px;">
		  	 <form action="enviar_tlc_venezuela.php" method="post" enctype="multipart/form-data" onSubmit="javascript:return valida()" class="row" name="form1">

				 <div class="register-top-grid">
					<h3>CREA TU CASILLA GRATIS</h3>
					 <div>
                     <input name="promoap" size="60" maxlength="100" class="form-control" type="hidden" value="venezuela_2019_land_F" >
						<span>Email<label>*</label></span>
						<input style="padding:8px 10px;outline: none;color: #333333; background: #fff; border:solid 1px #E8E8E8 ;width: 95%;" id="email_usu" name="email_usu"  type="email" value="" title="Ingresa tu email"  placeholder="email" required="required"  >

					 </div>
					 <div>
						<span>Nombre<label>*</label></span>
					<input id="firstName" name="nombre_usu"  type="text" value="" title="Ingresa tu Nombre" placeholder="Nombre" required="required">
          </div>
					 <div>
						 <span>Apellido<label>*</label></span>
						             <input id="lastName" type="text" name="apellidos_usu" placeholder="Apellidos"  value="" title="Ingresa tu Apellido" required="required" >
					 </div>
                     
                      <div>
						 <span>RUT: E.j. 11.111.111-1 <label>*</label></span>
                         
                         
                         
                         
						 <input name="rut_usu" type="text"  id="rut_usu" value=""   placeholder="RUT"   title="Ingresa tu RUT" oninput="checkRut(this)"  required="required">  
<script src="validarRUT.js"></script>

					 </div>
                     
                      <div>
						<span>Tel&eacute;fono<label>*</label></span>
						
                        
                        
                        <input style="padding:8px 10px;outline: none;color: #333333; background: #fff; border:solid 1px #E8E8E8 ;width: 95%; overflow:none;" name="fono_usu"  id="fono_usu"  type="number" value=""  title="Ingresa un n&uacute;mero de tel&eacute;fono" required="required"   />
                  
					 </div>
					 <div>
						<span>Direcci&oacute;n<label>*</label></span>
						<input id="direccion" name="direccion_usu"  type="text" value="" title="Ingresa tu Direcci&oacute;n" placeholder="Direcci&oacute;n" required="required"  >

					 </div>
					
                     
                      <div>
						 <span>Regi&oacute;n<label>*</label></span>
						<select name="categoria" class="form-control"    id="id_comuna_scl" title="Sellecciona una Region" onChange="act_categoria(this);" required="required" style="padding:8px 10px;outline: none;color: #333333; background: #fff; border:solid 1px #E8E8E8 ;width: 95%;">
<option value="">Seleccione Region</option>
<?php  mysqli_query($connection ,"SET NAMES 'utf8'"); $result4 = "select * from region where id_region<>0";
	$arr_vend = mysqli_query($connection, $result4) or die('Error en llamada 483');
	while ($Rs2 = mysqli_fetch_assoc($arr_vend)) {?>
	
							<option value="<?php echo $Rs2['id_region'] ?>" ><?php	echo $Rs2['nombre_region']; ?>	</option>
							<?php }; ?>
</select>
					 </div>
                     
                      <div>
						 <span>Comuna<label>*</label></span>
						 <select name="subcategoria" class="form-control" title="Selecciona una Comuna" id="subcategoria" style="padding:8px 10px;outline: none;color: #333333; background: #fff; border:solid 1px #E8E8E8 ;width: 95%;" required="required"  >
						<option value="0"></option>
						 </select>
					 </div>
					 <div class="clearfix"> </div>
					   <a class="news-letter" href="#condiciones" onClick="aparecer('condiciones');ocultar('politica');">
						 <label class="checkbox"><input type="checkbox" name="checkbox" checked="" required="required"><i> </i>Acepto Los T&eacute;rminos y Condiciones</label>
					   </a>
                       
                       
                       
<!-- DIV CONDICIONES-->               
<div id="condiciones">
<a href="#condiciones" style="float:right; color:#036; font-weight:bold;" onClick="ocultar('condiciones');">CERRAR</a><br />

<p style="font-size:16px; font-weight:bold;">Acepto los siguientes t&eacute;rminos y condiciones:</p><br />

<p style="font-size:12px; font-weight:bold;">CONTRATO DE SERVICIO CASILLA INTERNACIONAL TLCCOURIER</p><br />

El presente contrato regula los t&eacute;rminos y condiciones en virtud del cual TLC Courier S.A., en adelante &ldquo;TLCCOURIER&rdquo;, ofrece a usted, en adelante el &ldquo;Cliente&rdquo;, sus casillas internacionales denominadas individual y conjuntamente, seg&uacute;n sea el caso, como &ldquo;TLCCOURIER&rdquo;.<br /><br />

<strong>1.- Servicio</strong> <br />
TLCCOURIER facilita al Cliente su direcci&oacute;n f&iacute;sica internacional ubicada en la ciudad de Miami, Estados Unidos, de ahora en adelante &ldquo;Pa&iacute;s extranjero&rdquo;, para que el Cliente direccione sus env&iacute;os a dicha Direcci&oacute;n F&iacute;sica y TLCCOURIER proceda a recibirlos, clasificarlos, consolidarlos, transportarlos v&iacute;a a&eacute;rea desde USA, presentar los env&iacute;os ante el Servicio Nacional de Aduanas de Chile, pagar los impuestos y aranceles que sean necesarios a nombre del cliente (los cuales deber&aacute;n ser reembolsados a la empresa al momento de ser despachada o retirada la carga) y luego a requerimiento del cliente enviarlos por una empresa externa a regiones, a la direcci&oacute;n que designe en Chile, despacho dentro de Santiago en los siguientes d&iacute;as h&aacute;biles por parte de TLCCOURIER cancelando el monto designado por sector o por defecto, a las bodegas de la casa matriz de TLCCOURIER.<br />
El Cliente se hace responsable de la veracidad, exactitud e integridad de la informaci&oacute;n que proporcione a TLCCOURIER para importar sus env&iacute;os y para efectuar las entregas en Chile a la direcci&oacute;n que &eacute;ste le se&ntilde;ale.<br />
<strong>2.- Direcci&oacute;n f&iacute;sica</strong><br />
Las compras que efect&uacute;e el Cliente deber&aacute;n ser dirigidas a la Direcci&oacute;n f&iacute;sica en Miami otorgada por TLCCOURIER. <br />
Esta Direcci&oacute;n f&iacute;sica no tiene costo alguno de apertura ni de mantenci&oacute;n.<br />
Todos los env&iacute;os y correspondencia, sin distinci&oacute;n alguna, que llegue a nombre del Cliente a esta Direcci&oacute;n f&iacute;sica se entender&aacute;n que han sido enviados por &eacute;ste, autorizando desde ya a TLCCOURIER para que a cargo del Cliente, los interne, transporte y entregue en Chile.<br />
Las partes acuerdan que por regla general todos los env&iacute;os que lleguen a TLCCOURIER a nombre del Cliente se presumir&aacute;n que han sido solicitados por &eacute;ste.<br />
Las &uacute;nicas limitantes para los paquetes y env&iacute;os que se reciban en la Direcci&oacute;n f&iacute;sica es toda papeler&iacute;a (revistas, diarios, flyers, avisos, etc) que no vengan dentro de una caja y todos aquellos env&iacute;os que est&eacute;n prohibidos por ley.<br />
<strong>3.- Cumplimiento normativa y autorizaciones</strong><br />
El Cliente declara conocer la legislaci&oacute;n chilena y del pa&iacute;s extranjero que regula la importaci&oacute;n a Chile de productos y mercanc&iacute;as. Producto de lo anterior, &eacute;ste declara conocer que sus env&iacute;os podr&aacute;n ser objeto de revisiones tanto en Chile como en el extranjero a objeto de verificar el cumplimiento de la normativa vigente de los pa&iacute;ses de origen y destino de las piezas. En www.TLCCOURIER.cl el Cliente podr&aacute; encontrar un listado meramente referencial de los productos cuyo transporte a&eacute;reo no est&aacute; autorizado por las autoridades federales de Estados Unidos de Am&eacute;rica y por las autoridades aduaneras chilenas y cuya internaci&oacute;n est&aacute; prohibida y/o restringida por la legislaci&oacute;n chilena. TLCCOURIER se reserva el derecho a no admitir los env&iacute;os que vulneren la legislaci&oacute;n vigente o puedan derivar en multas, sanciones y/o delitos tanto para TLCCOURIER como para el Cliente. El no ejercicio de ese derecho no acarrear&aacute; responsabilidad o culpa alguna a TLCCOURIER.<br />
El Cliente libera de toda responsabilidad a TLCCOURIER por la confiscaci&oacute;n de productos que puedan realizar las autoridades del pa&iacute;s extranjero o de Chile y del gravamen del cual puedan ser objeto producto de ello o de cualquier otra circunstancia. El Cliente ser&aacute; el &uacute;nico responsable del incumplimiento de dichas normas y se obliga, en todo caso, a mantener indemne a TLCCOURIER de todo perjuicio que para ella deriven de los procedimientos de importaci&oacute;n de los env&iacute;os del Cliente.<br />
T&eacute;rminos del servicio de entrega de USPS (united States Postal Service). El servicio Postal de Estados unidos (USPS) requiere autorizaci&oacute;n de cliente para que sus paquetes sean transportados, de acuerdo a lo exigido a trav&eacute;s del formulario &ldquo;1583&rdquo; indicado en link a continuaci&oacute;n, https://about.usps.com/forms/ps1583.pdf. <br />
<strong>4.- Documentaci&oacute;n</strong><br />
Para efectos de la internaci&oacute;n de los env&iacute;os, &eacute;stos deber&aacute;n venir debidamente acompa&ntilde;ados de sus facturas o de otros antecedentes que revelen indubitadamente el valor de compra o adquisici&oacute;n de dichos productos. <br />
En caso que los env&iacute;os del Cliente no contengan la correspondiente factura u otros documentos necesarios para su importaci&oacute;n, como certificados, autorizaciones administrativas, resoluciones, etc., TLCCOURIER le requerir&aacute; al Cliente la presentaci&oacute;n de &eacute;stos. TLCCOURIER no se hace responsable por los env&iacute;os del Cliente que requieran antecedentes y documentos adicionales a los que el Cliente cre&iacute;a que le afectaban de acuerdo a la legislaci&oacute;n chilena y del pa&iacute;s extranjero.<br />
Si transcurridos 30 d&iacute;as desde su solicitud no han sido presentados los antecedentes requeridos, TLCCOURIER declarar&aacute; abandonados los productos y proceder&aacute; a disponer de ellos para cubrirse de los cr&eacute;ditos devengados en su favor.<br />
<strong>5.- Tarifas, costos y pago</strong><br />
A trav&eacute;s del sitio www.tlccourier.cl el Cliente podr&aacute; acceder a un sistema referencial de simulaci&oacute;n de cargos de sus env&iacute;os al cual deber&aacute;n ingresarse las caracter&iacute;sticas exactas del producto que se desea importar. El Cliente declara conocer y aceptar que en caso que los datos ingresados no sean ajustados a las caracter&iacute;sticas como peso, origen, precio y destinaci&oacute;n de los productos, el valor final del servicio ofrecido por TLCCOURIER podr&iacute;a variar, ya sea en contra o en favor del Cliente. <br />
Ser&aacute;n de cargo del Cliente los aranceles, cargos, impuestos aduaneros, IVA, el transporte de sus env&iacute;os Miami- Santiago, cargos todos que por cuenta del Cliente pagar&aacute; TLCCOURIER con la finalidad de facilitar la importaci&oacute;n y entrega de los env&iacute;os. <br />
En particular ser&aacute;n de cargo del Cliente:<br />
a) Cargos por el transporte internacional de acuerdo con las tarifas establecidas por TLCCOURIER;<br />
b) Impuestos y tasas aduaneras por concepto de importaci&oacute;n;<br />
c) Gastos locales correspondientes a manejo aduanero, protecci&oacute;n y entrega en Santiago de Chile, o bien, gastos locales correspondientes a entrega en regiones;<br />
d) Certificaciones especiales que requiera la carga tanto en el extranjero como en Chile; y<br />
e) TLCCOURIER no realiza consolidaci&oacute;n de env&iacute;os. Si realizamos consolidaci&oacute;n en Miami con un costo de 35usd<br />
El Cliente se obliga a pagar el importe de los servicios de TLCCOURIER contra entrega. <br />
TLCCOURIER no estar&aacute; obligado a entregar en su sucursal o despachar los env&iacute;os del Cliente si &eacute;ste no ha pagado el valor total de los servicios. Liberados los env&iacute;os del Cliente del Servicio Nacional de Aduanas de Chile, se le informar&aacute; v&iacute;a correo electr&oacute;nico u otro medio de comunicaci&oacute;n, a este del importe de los servicios de TLCCOURIER. <br />
Los pagos podr&aacute;n realizarse en efectivo, cheque y transferencias, m&aacute;s detalles en p&aacute;gina web TLCCOURIER. <br />
Sin perjuicio de lo anterior, en casos de env&iacute;os cuyo valor FOB (free on board) sea igual o exceda del equivalente de USD 1.000 (Mil d&oacute;lares Estadounidenses), el importador deber&aacute; contratar un Broker ( Agente de aduanas). En caso que el importador, Cliente, no cuente con un agente de aduanas, TLCCOURIER podr&aacute; sugerir o recomendar una agente de aduanas.<br />
Si transcurridos 45 d&iacute;as desde la solicitud de pago &eacute;ste no se ha efectuado, TLCCOURIER declarar&aacute; abandonados los productos y proceder&aacute; a disponer de ellos para cubrirse de los cr&eacute;ditos devengados en su favor.<br />
<strong>6.- Costos del Transporte</strong><br />
La tarifa del flete a&eacute;reo y terrestre se aplicar&aacute; en base a su peso real, de acuerdo a informaci&oacute;n y restriccion vigente en la pagina web de TLCCOURIER. <br />
<strong>7.- Responsabilidad</strong><br />
TLCCOURIER no asume ninguna responsabilidad respecto de la calidad, marca o cualquier otro aspecto de las mercanc&iacute;as que el Cliente haya adquirido y enviado a trav&eacute;s de los servicios de TLCCOURIER y/o que sean transportadas a trav&eacute;s de los servicios de TLCCOURIER. Cualquier reclamo, disconformidad o disputa respecto a la calidad, marca, o cualquier otro aspecto inherente a los productos adquiridos por el Cliente deber&aacute;n ser consultados y reclamados directamente con su proveedor, no teniendo TLCCOURIER relaci&oacute;n alguna con &eacute;ste. En caso de problemas de da&ntilde;os, perdida total o de &iacute;tems faltantes , el cliente afectado deber&aacute; notificar a TLCCOURIER v&iacute;a mail o directamente en un plazo no mayor a 10 d&iacute;as h&aacute;biles luego de recepcionar el env&iacute;o en la oficina de TLCCOURIER o recibido conforme v&iacute;a transporte realizada por un tercero o entrega directa. TLCCOURIER determinar&aacute; seg&uacute;n cada caso si el servicio de protecci&oacute;n es aplicable y si cumple con las condiciones para ser efectivo el cambio o devoluci&oacute;n de la mercader&iacute;a, . Asimismo, TLCCOURIER no ser&aacute; responsable de los retrasos de las entregas de las mercader&iacute;as enviadas a TLCCOURIER a su Direcci&oacute;n f&iacute;sica en Miami.<br />
<strong>8.- Plazos y entrega</strong><br />
Los despachos materia del presente contrato que no presenten reparos y/o solicitudes asociadas, se realizar&aacute;n en un plazo promedio de 2 a 5 d&iacute;as h&aacute;biles contados desde su recepci&oacute;n en la casilla en Miami siempre y cuando el cliente haya cumplido con la documentaci&oacute;n, requisitos y normas aduaneras y condiciones indicadas en este contrato. El Cliente declara conocer que el plazo anterior ser&aacute; contabilizado una vez que su env&iacute;o haya sido recepcionado en TLCCOURIER Miami sin incidencias.<br />
TLCCOURIER no se responsabiliza por retrasos ocasionados por causa de fuerza mayor, caso fortuito o problemas ajenos a su control, como es el caso de huelgas, imprevistos de l&iacute;neas a&eacute;reas o en aeropuertos, problemas aduaneros o de la documentaci&oacute;n que se adjunta al env&iacute;o. <br />
Una vez llegada la mercanc&iacute;a a Chile y efectuados todos los tr&aacute;mites de internaci&oacute;n, TLCCOURIER dar&aacute; aviso al cliente que su paquete est&aacute; listo para ser retirado o para ser despachado. En caso que el cliente no d&eacute; acuse de recibo de estos avisos, ya sea por tel&eacute;fono, e-mail o presencialmente en las oficinas de TLCCOURIER en un per&iacute;odo de 45 d&iacute;as, el producto ser&aacute; declarado como abandonado y proceder&aacute; a disponer de ellos para cubrir los cr&eacute;ditos devengados a su favor.<br />
Este plazo es inimpugnable, de d&iacute;as corridos y no est&aacute; condicionado al pago del env&iacute;o por parte del cliente.<br />
<strong>9.- Cobertura adicional</strong><br />
Recibiendo TLCCOURIER el env&iacute;o encomendado listo para entregar, ser&aacute; responsabilidad del cliente dar aviso lo antes posible de cualquier desperfecto, da&ntilde;o o disconformidad con el env&iacute;o para aplicar las garant&iacute;as vigentes.<br />
<br />
Para m&aacute;s informaci&oacute;n respecto a nuestras condiciones de aplicaci&oacute;n de garant&iacute;a y protecci&oacute;n adicionales, consulte www.TLCCOURIER.cl<br />
<strong>10.- Indemnizaci&oacute;n</strong><br />
El Cliente acepta expresamente que TLCCOURIER pagar&aacute;, por cuenta y cargo del Cliente, los aranceles, cargos, tasas, e impuestos que sean necesarios para ingresar los env&iacute;os a Chile. El Cliente ha declarado en virtud del presente contrato conocer la legislaci&oacute;n tributaria y aduanera que rige las importaciones a Chile, en virtud de lo anterior, si con ocasi&oacute;n de la importaci&oacute;n de sus env&iacute;os derivaren multas o sanciones atribuibles al Cliente, &eacute;ste mantendr&aacute; en todo caso indemne a TLCCOURIER de todo reclamo, multa, sanci&oacute;n, demanda y cualquier acci&oacute;n que producto de los env&iacute;os o su internaci&oacute;n sea condenado TLCCOURIER.<br />
<strong>11- Ley Aplicable</strong><br />
Este contrato y los derechos y deberes de las partes emanados del mismo estar&aacute;n regidos por y ser&aacute;n interpretados de acuerdo con las leyes chilenas.<br />
<br />




<a href="#condiciones" style="float:right; color:#036; font-weight:bold;" onClick="ocultar('condiciones');">CERRAR</a><br />

</div>
<!--FIN DIV CONDICIONES-->
                       
					 </div>
				     <!--div class="register-bottom-grid">
						    <h3>DATOS DE ACCESO</h3>
							 <div>
								<span>Password<label>*</label></span>
								<input type="text">
							 </div>
							 <div>
								<span>Confirmar Password<label>*</label></span>
								<input type="text">
							 </div>
							 <div class="clearfix"> </div>
                             
					 </div-->
                 	
				<div class="clearfix"> </div>
				<div class="register-but">
				  
                  
                  
					   <input type="submit" style="float: right; background-color:#005FAC; border:none; padding:15px; font-size:90%; font-weight:bold; color:#FFF; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" value="Registrarme" required="required"  >
					   <div class="clearfix"> </div>
				  
				</div> </form>
		   </div>
      	 </div>
      </div>