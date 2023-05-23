<?php

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);

    require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/funciones/enviar_correo_grey.php';
    
    $nombre="Grey ";
    $apellido_p="Uzcategui";
    $id_usuario=3166;
    $pass="AxLa1992";

    $correoEmail='ing.greyuzcategui@gmail.com';
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
                                              TLC Courier informa a usted, que su envío:</strong></font> 
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
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Cuenta :CHI-&nbsp;9881</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Guia Garve:&nbsp;GS1213669</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Descripcion:&nbsp;REPUESTO</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Tracking:&nbsp;1Z6874XX0399354133</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align='center'><font color='#FFFFFF' face='Arial'><strong>Peso:&nbsp;20.7 KG</strong><br>
                                                          </font>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td>&nbsp;</td>
                                                    </tr>
                                                    <tr bgcolor='#FFFFFF'>
                                                       <td colspan='2' align='center'><font color='#0045AD' face='Arial'>Ha arribado a Chile y está en proceso de aduanas de Chile.<br>
                                                          <br>
                                                          Recuerda que puedes realizar seguimiento de tu envío a través de tu cuenta en TLC Courier.<br>
                                                          <br>
                                                          Si no has realizado la prealerta favor adjunta la factura de esta compra en <a href='http://www.tlccourier.cl' target='_blank' data-saferedirecturl='https://www.google.com/url?q=http://www.tlccourier.cl&amp;source=gmail&amp;ust=1662580026452000&amp;usg=AOvVaw0CS7fxBi-lOf1Ysp8sp8qZ'>
                                                          TLC Courier</a><br>
                                                          <br>
                                                          Con la prealerta anticipada evitas retrasos en los embarques y en el proceso de aduanas en Chile.<br>
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
    
    echo enviarCorreo($correoEmail,'Bienvenido a TLC Courier',$mensaje);

?>