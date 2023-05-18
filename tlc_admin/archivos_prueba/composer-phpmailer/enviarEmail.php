<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function enviarCorreo($direccion_destinatario,$asunto,$contenido){

    $mail = new PHPMailer();    
    $mail->Timeout       =   30; 
    $mail->SMTPKeepAlive = true; 
    //$mail->SMTPDebug = 3;
    $mail->IsSMTP();
    $mail->Host = 'mail.tlccourier.cl';
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true;
    $mail->Port = 465;
    $mail->Username = 'noreply@tlccourier.cl';
    $mail->Password = '[d!x}E(mX1WF';
    $mail->IsHTML(true);

    
    // Emisor
    $mail->From = "noreply@tlccourier.cl";
    $mail->FromName = "";
    
    // Receptor
    $res=explode(",", $direccion_destinatario);
    
    foreach ($res as $key => $var) {
        $mail->addAddress($var,"");
    }
    
    $mail->Subject = utf8_decode($asunto);
    $mail->Body = utf8_decode($contenido);
    
    try {
        if(!$mail->Send()){
            return $mail->ErrorInfo;
        }else{
            return true;
        }

    } catch (Exception $e) {
     var_dump($e); 
    }

    $mail->SmtpClose();
}

/*
$nombre="Josse ";
$apellido_p="Niño";
$id_usuario=3166;
$pass="AxLa1992";

$correoEmail='jossenino@gmail.com';
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
                <td width=16 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                <td width=500 align=left valign=top bgcolor=#FFFFFF>
                    <table width=490 border=0align=center cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <tbody>
                            <tr>
                                <td align=center valign=top bgcolor=#FFFFFF>
                                    <table width=400 border=0 cellpadding=0 cellspacing=0>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <font style=font-size:10pt; color=#0161AC face=Arial size=1>Felicitaciones <strong>".$nombre.": </strong> Ya eres parte tlccourier, a partir de ahora todas tus compras en USA o el mundo nosotros lo traemos.</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=center>
                                                <font style=font-size: 13pt; color=#0161AC face=Arial><strong><br>
                                                Tus accesos para My TLC son:</strong></font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=center>
                                                <table width=450 border=0 bgcolor=#0161AC cellpadding=3 cellspacing=0>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 15pt; color=#FFFFFF face=Arial ><strong> Numero de cliente: ".$id_usuario."</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 15pt; color=#FFFFFF face=Arial><strong style=text-decoration:none> Correo: ".$correoEmail."</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 15pt; color=#FFFFFF face=Arial ><strong>Contraseña: ".$pass."</strong></font>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <br/>

                                                <table width=450 border=0 bgcolor=#0161AC cellpadding=3 cellspacing=0>
                                                    <tr >
                                                        <td align=center bgcolor=#FFFFFF >
                                                            <font style=font-size:10pt; color=#0161AC face=Arial><strong>Para efectuar tus compras, debes ingresar la informaci&oacute;n <br>
                                                            de la siguiente forma:</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Name:&nbsp;".$nombre."&nbsp;".$apellido_p."</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Address line 1:&nbsp;8256 N. W 30 TH TERRACE</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial >
                                                            <strong>Address line 2: TLC-".$id_usuario."</strong><br>
                                                            <em>(!) siempre debes ingresar tu código</em></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>City:&nbsp;MIAMI</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>State:FLORIDA</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Zipcode:33122-1914</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align=center >
                                                            <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Phone:786-6158656</strong></font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height=10></td> 
                                                    </tr>
                                                </table>
                                                <br><br>

                                                <table width=450 border=0  bordercolor=#CCCCCC cellpadding=3 cellspacing=0>
                                                    <tr>
                                                        <td height=10></td>
                                                    </tr>

                                                    <tr>
                                                        <td align=center bgcolor=#FFFFFF> 
                                                            <font style=font-size:10pt; color=#0161AC face=Arial ><em><strong>IMPORTANTE:</strong><br />
                                                            NUNCA enviaremos un e-mail solicitando tus claves o datos personales y SIEMPRE nos dirigiremos a ti por tu nombre y apellido.<br />
                                                            Nunca reveles tus claves.<br />
                                                            Mantén tus datos actualizados.</em></font>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <td height=30 align=center valign=bottom>
                                <font style=font-size: 10pt; color=#0161AC face=Arial size=2 >www.tlccourier.cl - &copy; Todos los Derechos Reservados</font>
                            </td>
                        </tr>
                        &nbsp;&nbsp;&nbsp;
                    </table>
                </td>
                <td width=15 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                &nbsp; 
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

*/