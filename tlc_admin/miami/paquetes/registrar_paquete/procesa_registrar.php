<?php

	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	require $conf['path_host'].'/funciones/enviar_correo.php';
	
	set_time_limit(0);

	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['cliente'])) {
		die("Ocurrio un problema con el numero de cliente");
	}else{
		$id_cliente=$_POST['cliente'];
	}

	if (!isset($_POST['consignatario'])) {
		die("Ocurrio un problema con el consignatario ingresado");
	}else{
		$consignatario=$_POST['consignatario'];
	}

	if(!isset($_POST['currier'])) {
		die("Ocurrio un problema con la compa単ia de currier seleccionada");
	}else{
		$currier=$_POST['currier'];
	}

	if (!isset($_POST['tracking_usa'])) {
		die("Ocurrio un problema con el numero de tracking ingresado");
	}else{
		$tracking_usa=$_POST['tracking_usa'];
	}

	if (!isset($_POST['proveedor'])) {
		die("Ocurrio un problema con la tienda proveedora seleccionada");
	}else{
		$proveedor=$_POST['proveedor'];
	}

	if (!isset($_POST['valor'])) {
		die("Ocurrio un problema con el valor del producto ingresado");
	}else{
		$valor=$_POST['valor'];
	}

	if (!isset($_POST['tipo_paquete'])) {
		die("Ocurrio un problema con el tipo de paquete seleccionado");
	}else{
		$tipo_paquete=$_POST['tipo_paquete'];
	}

	if (!isset($_POST['producto'])) {
		die("Ocurrio un problema con el nombre del producto ingresado");
	}else{
		$producto=$_POST['producto'];
	}

	if (!isset($_POST['numero_piezas'])) {
		die("Ocurrio un problema con el numero de piezas ingresado");
	}else{
		$numero_piezas=$_POST['numero_piezas'];
	}

	if(!isset($_POST['peso_kg'])) {
		die("Ocurrio un problema con el peso del producto");
	}else{
		$peso_kg=$_POST['peso_kg'];
		$peso_kg=floatval($peso_kg)*(0.45);
	}

	if($tipo_paquete==1 || $tipo_paquete==6){
		$largo=0;
		$ancho=0;
		$alto=0;
		$pesoVolumen=0;
	}else{

		if (!isset($_POST['largo'])) {
			die("Ocurrio un problema con el largo del producto ingresado");
		}else{
			$largo=$_POST['largo'];
			$largo=floatval($largo)*(2.54);
		}

		if (!isset($_POST['ancho'])) {
			die("Ocurrio un problema con el ancho del producto ingresado");
		}else{
			$ancho=$_POST['ancho'];
			$ancho=floatval($ancho)*(2.54);
		}

		if (!isset($_POST['alto'])) {
			die("Ocurrio un problema con el alto del producto ingresado");
		}else{
			$alto=$_POST['alto'];
			$alto=floatval($alto)*(2.54);
		}

		$pesoVolumen=($alto*$ancho*$largo)/6000;
	}
	
	$db->prepare("SELECT * FROM paquete WHERE tracking_eu=:id ORDER BY id_paquete DESC LIMIT 1");
	$db->execute(array(':id' => $tracking_usa));
	$sql_tracking_usa=$db->get_results();

	if(!empty($sql_tracking_usa)){
		die('Ya existe un paquete registrado con el mismo Tracking number de USA.');
	}

	// se crea el numero de tracking de garve shop
	$sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=1");

    //var_dump($sql_tracking_usa, $sql_parametro);die();

	foreach ($sql_parametro as $key => $parametro) { 
		$prefijo=$parametro->prefijo_etiqueta;
		$incremento=$parametro->incremento_valor;
	}

	$incremento=$incremento+1;

	$numero_seguimiento=$prefijo.$incremento;

	// Actualiza el valor de incremento de la tabla parametro
	$db->prepare("UPDATE parametro SET incremento_valor=:incremento WHERE id_parametro=1");
	$db->execute(array(':incremento' => $incremento));
	// Fin actualizar tabla parametros

	// Ingreso de datos a la tabla principal "envios"
	$db->prepare("INSERT INTO paquete SET 
		id_usuario=:cliente,
		consignatario=:consignatario,
		currier=:currier, 
		descripcion_producto=:producto, 
		pieza=:pieza, 
		valor=:valor,
		tracking_eu=:tracking_eu,
		tracking_garve=:seguimiento,
		id_proveedor=:proveedor,
		id_usuario_miami=:usuario,
		fecha_procesado_miami=:fecha_proceso,
		peso=:peso_kg,
		prealerta=0,
		status=2,
		fecha_registro=:fecha,
		largo=:largo,
		ancho=:ancho,
		alto=:alto,
		peso_volumen=:pesoVolumen,
		id_tipo_paquete=:id_tipo_paquete
	");
	$db->execute(array(
		':cliente' => $id_cliente,
		':consignatario' => $consignatario,
		':currier' => $currier,
		':producto' => $producto,
		':pieza' => $numero_piezas,
		':valor' => $valor,
		':tracking_eu' => $tracking_usa,
		':seguimiento' => $numero_seguimiento,
		':proveedor' => $proveedor,
		':usuario' => $id_usu,
		':fecha_proceso' => $fecha_actual,
		':peso_kg' => $peso_kg,
		':fecha'=>$fecha_actual,
		':largo' => $largo,
		':ancho' => $ancho,
		':alto' => $alto,
		':pesoVolumen'=>$pesoVolumen,
		':id_tipo_paquete' => $tipo_paquete
	));
	$id=$db->lastId();
	//obtiene el id de la solicitud ingresada

	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status='2',
		id_usuario=:usuario,
		id_lugar='2',
		fecha=:fecha
	");
	$db->execute(
		array(
			':id' => $id,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
	));
    
	
	//----------------------------------MENSAJE CLIENTE-----------------------------------------------------------------
	$db->prepare("SELECT * FROM gar_usuarios WHERE id_usuario=:idCliente");
	$db->execute(array(':idCliente' => $id_cliente));
	$cliente=$db->get_results();
	
	$correoEmail=$cliente[0]->email;
	$mensaje="
        <title>TLC Courier</title>
        <table width=531 border=0 align=center cellpadding=0 cellspacing=0>
            <tbody>
                <tr>
                    <td colspan=3 align=left valign=top></td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#0161AC>
                        <img src=http://tlccourier.cl/inicio/images/banda_mail.png width=531 height=96>
                    </td>
                </tr>
                <tr>
                   <td width='16' align='left' valign='top' bgcolor='#0045AD'>&nbsp; </td>
                   <td width='500' align='left' valign='top' bgcolor='#FFFFFF'>
                      <table width='490' border=0 align='center' cellpadding='0' cellspacing='0'>
                         <tbody>
                            <tr>
                               <td>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               </td>
                            </tr>
                         </tbody>
                         <tbody>
                            <tr>
                               <td align='center' valign='top' bgcolor='#FFFFFF'>
                                  <table width='400' border='0' cellpadding='0' cellspacing='0'>
                                     <tbody>
                                        <tr>
                                           <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                           <td align='center'><font color='#0045AD' face='Arial'><strong><br>
                                              TLC Courier informa a usted, que su env&iacute;o ha sido recibido en Miami.</strong></font> 
                                           </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' align='center'>
												<font color='#0045AD' face='Arial'>
													Solicitamos que adjunte a la brevedad su <a href='../2019/index.php#home' target='_blank'>factura/invoice</a> 
													al sistema para evitar demoras o retenciones en Aduana. La <a href='../2019/index.php#home' target='_blank'>factura/invoice</a> 
													es un documento que debe indicar:<br><br>
													• Tienda de compra<br>
													• Detalle de el o los artículos comprados<br>
													• Valores asociados (costo productos, posibles TAX y costos de envío).<br><br>

													La misma se puede obtener en el sitio o tienda donde realizó la compra. <strong><u>No enviar imágenes que solo indiquen valor de la compra.</u></strong><br><br>

													Este documento es solicitado por Aduana y no presentarlo significará una <strong><u>retención de su compra y posible presunción de abandono</u></strong> según la norma aduanera vigente.<br><br>
												</font>
											</td>
                                        </tr>
                                        <tr>
                                           <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                           <td align='center'>
                                              <table width='400' border='0' bgcolor='#0045AD' cellpadding='3' cellspacing='0'>
                                                 <tbody>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Cuenta :TLC-" . $id_cliente . "</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Guia TLC:&nbsp;". $numero_seguimiento ."</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Descripcion:&nbsp;" . $producto . "</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Tracking:&nbsp;" . $tracking_usa . "</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Peso:&nbsp;" . $peso_kg . " KG</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td>&nbsp;</td>
                                                    </tr>
                                                    <tr bgcolor='#FFFFFF'>
                                                       <td colspan='2' align='center'><font color='#0045AD' face='Arial'>El paquete ha sido recibido exitosamente en Miami y est&aacute; en proceso de ingreso en vuelo<br>
                                                          <br>
                                                          Con la prealerta anticipada evitas retrasos en los embarques y en el proceso de aduanas en Chile.<br>
                                                          <br>
                                                          Recuerda que puedes realizar seguimiento de tu env&iacute;o a trav&eacute;s de tu cuenta en TLC Courier.<br>
                                                          <br>
                                                          Gracias por la confianza<br>
                                                          <br>
                                                          Equipo TLC Courier. </font>
                                                       </td>
                                                    </tr>
                                                 </tbody>
                                              </table>
                                           </td>
                                        </tr>
                                     </tbody>
                                  </table>
                               </td>
                            </tr>
                         </tbody>
                         <tbody>
                            <tr>
                               <td height='30' align='center' valign='bottom'><br>
                                  <font color='#0045AD' face='Arial' size='2'><b>TLC Courier</b><br>
                                  <a href='http://www.tlccourier.cl' target='_blank' data-saferedirecturl='https://www.google.com/url?q=http://www.tlccourier.cl&amp;source=gmail&amp;ust=1662580026452000&amp;usg=AOvVaw0CS7fxBi-lOf1Ysp8sp8qZ'>www.tlccourier.cl</a> </font><br>
                                  <br>
                               </td>
                            </tr>
                            <tr>
                               <td>
                                  &nbsp;&nbsp;&nbsp;
                               </td>
                            </tr>
                         </tbody>
                      </table>
                   </td>
                   <td width='15' align='left' valign='top' bgcolor='#0045AD'>&nbsp; </td>
                   <td>
                      &nbsp;
                   </td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#0161AC>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top></td>
                </tr>
            </tbody>
        </table>
    ";

    enviarCorreo($correoEmail,'Recibido en Miami/ Adjuntar Factura',$mensaje);
    
    barcode($numero_seguimiento);
    
	?>
		<script>
			var id= "<?php echo $id; ?>";
			var numero_piezas= "<?php echo $numero_piezas; ?>";
			var directorio= "<?php echo $conf['path_host_url']; ?>";

		    window.open(directorio+'/miami/etiqueta/etiqueta_pdf.php?paquete='+id+'&total='+numero_piezas , '_blank');

		    window.location.href=directorio+'/miami/paquetes/registrar_paquete/inicio_escanear_codigo.php';
	    </script>
	<?php

?>

					
				