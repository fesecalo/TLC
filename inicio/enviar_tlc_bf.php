<?php
include_once("../lib/conf.php");
//************ JMG CONFIGURACION-----/////////********************************
	$qr_conf = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_conf = mysqli_query($connection, $qr_conf) or die('Error en llamada 37');
	$ROW_CONF = mysqli_fetch_array($arr_conf);
	
	
//**********************************************************************
function comuna($comuna){
global $connection;   
	$qr_com = "SELECT * from comunas WHERE id_comuna = $comuna limit 1";
	$arr_com =mysqli_query($connection,$qr_com) or die('Error en llamada 32');
	$ROW_COM = mysqli_fetch_array($arr_com);
	return $ROW_COM['nombre_comuna'];
}

function region($region){
global $connection;   
	$qr_com = "SELECT * from region WHERE id_region = $region limit 1";
	$arr_com = mysqli_query($connection,$qr_com) or die('Error en llamada 322');
	$ROW_COM = mysqli_fetch_array($arr_com);
	return $ROW_COM['nombre_region'];
}


//************ JMG VALIDACION RUT Y EMAIL ********************************
	$qr_val = "SELECT * from gar_usuarios WHERE rut='".$_POST['rut_usu']."' OR email='".$_POST['email_usu']."' LIMIT 1";
	//echo $qr_val;
	$arr_val = mysqli_query($connection,$qr_val) or die('Error en llamada 32222');
	$ROW_VAL = mysqli_fetch_array($arr_val);
	
	//echo "muestra".$ROW_VAL['id_usuario'];
	//exit();
	if ($ROW_VAL['id_usuario']<>""){
			//echo "muestra bandera";
			echo "<script languaje='javascript'>";
			echo "alert('Ups! tu RUT o e-mail ya se encuentran en nuestros registros actuales');";
			echo "window.history.back()";
			echo "</script>";
			exit();
					
		}
	
	
	
//**********************************************************************






//INSERTO datos de usuario

	$q_= "SELECT MAX(id_usuario) as id_usuam FROM gar_usuarios";
	$arr_ = mysqli_query($connection, $q_) or die('Error en llamada 86');
	$RS_ = mysqli_fetch_assoc($arr_);
	$numeroid = $RS_['id_usuam']+1;
	$numerocliente= "721-".$numeroid;
	

	$q_insert = "INSERT INTO gar_usuarios 
	(id_cliente, promoap,email,nombre,apellidos,rut,telefono,direccion,id_region,id_comuna)	VALUES	
	('".$numerocliente."','".$_POST['promoap']."','".$_POST['email_usu']."','".$_POST['nombre_usu']."','".$_POST['apellidos_usu']."','".$_POST['rut_usu']."','".$_POST['fono_usu']."','".$_POST['direccion_usu']."',".$_POST['categoria'].",".$_POST['subcategoria'].") ";
	//echo $q_insert;
	$arr_i = mysqli_query($connection, $q_insert) or die('Error en llamada 15');
	$RS_INSERTA = mysqli_fetch_assoc($arr_i);
	$id_asignado = mysqli_insert_id($connection); //esta es la VARIABLE PARA UTILIZAR DEL ID ASIGNADO $id_asignado
	
	$qr_ed = "SELECT * from gar_usuarios WHERE id_usuario = '".$id_asignado."' LIMIT 1";
	$arr_ed = mysqli_query($connection, $qr_ed) or die('Error en llamada 73');
	$ROW_ED = mysqli_fetch_array($arr_ed);

	
//----------------------------------MENSAJE ADMINISTRADOR------------------------------------------------------------

//$mensajeemail="Sus credenciales fueron enviadas a su email, revise y vuelva a ingresar;";
	$respondere="atencionalcliente@tlccourier.cl";
	$asuntoe="Nueva Cuenta de Cliente TLC Courier";
	$autore="www.tlccourier.cl ";
	$cuerpoe="<table width=98% border=0 align=center cellpadding=5 cellspacing=0 bordercolor=#0088cc bgcolor=#0161AC>
<tr><td>
<table width=99% border=0 align=center cellpadding=10 cellspacing=1 >
 <tr bgcolor=#0161AC> 
	<td colspan=2 align=left><strong><font face=Verdana, Geneva, sans-serif color=#FFFFFF size=+3>Nueva Cuenta de Cliente</font></strong></td>
	</tr>
     <tr bgcolor=#FFFFFF> 
	<td colspan=2 align=left><font face=Verdana,>Se ha creado una nueva cuenta de cliente desde tlccourier.cl con los siguientes datos:</font></td>
	</tr>
     <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Fecha y hora:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".date('d-m-Y H:i:s')."</font></td>
  </tr>
   <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Numero de Cliente:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$ROW_ED['id_cliente']."</font></td>
  </tr>
  
   <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Promo Code:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['promoap']."</font></td>
  </tr>
  <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>email:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['email_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Nombre:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['nombre_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Apellido:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['apellidos_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>RUT:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['rut_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Tel&eacute;fono:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['fono_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Direcci&oacute;n:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".$_POST['direccion_usu']."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Regi&oacute;n:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".region($_POST['categoria'])."</font></td>
  </tr>
    <tr bgcolor=#FFFFFF> 
	<td width=25% align=right> <font face=Verdana, Geneva, sans-serif>Comuna:</font></td>
	<td width=75% align=left><font face=Verdana, Geneva, sans-serif>&nbsp;".comuna($_POST['subcategoria'])."</font></td>
  </tr>
</table>
</td></tr></table>";
	
	//$archivoad = $_FILES['archivo1'];
	$emilio="atencionalcliente@tlccourier.cl";
	//$emilio="jmarambiocl@gmail.com";
	$nombre_persona=$_POST['nombre_usu']." ".$_POST['apellidos_usu'];
	$nombre_persona= "TLC";
	include_once("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = $respondere;
	$mail->FromName = $autore;
	$mail->Subject = $asuntoe;
	$mail->isHTML(true);
	$mail->AddAddress($emilio, $nombre_persona);
	$mail->AddAddress("info@tlccourier.cl","INFO");
	$mail->AddAddress("comunicaciones@tlccourier.cl","COM");
	$mail->AddAddress("ruben@tlccourier.cl","GERENCIA");
	$mail->AddAddress("atencionalcliente@tlccourier.cl","ATENCION CLIENTES");
	$body = $cuerpoe;
	$mail->Body = $body;
	$mail->Send();


//------------------------------------------------------------------------------------------------------------------

//----------------------------------MENSAJE CLIENTE------------------------------------------------------------

//$mensajeemail="Sus credenciales fueron enviadas a su email, revise y vuelva a ingresar;";
	$respondere="atencionalcliente@tlccourier.cl";
	$asuntoe="Bienvenido a TLC Courier";
	$autore="www.tlccourier.cl";
	$cuerpoe="<title>TLC Courier</title>

<table width=531 border=0 align=center cellpadding=0 cellspacing=0>

<tbody>
  <tr>
    <td colspan=3 align=left valign=top></td>
    </tr>
  <tr>
    <td colspan=3 align=left valign=top bgcolor=#0161AC><img src=http://tlccourier.cl/inicio/images/banda_mail.png width=531 height=96></td>
    </tr>
  <tr>
    <td width=16 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
    <td width=500 align=left valign=top bgcolor=#FFFFFF><table width=490 border=0align=center cellpadding=0 cellspacing=0  bordercolor=#CCCCCC>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <tbody>
        <tr>
          <td align=center valign=top bgcolor=#FFFFFF><table width=400 border=0 cellpadding=0 cellspacing=0>
            <tr>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td><font style=font-size:10pt; color=#0161AC face=Arial size=1>Felicitaciones <strong>".$_POST['nombre_usu'].": </strong> Ya eres parte tlccourier, a partir de ahora todas tus compras en USA o el mundo nosotros lo traemos.</font></td>
              </tr>
            

              
            <tr>
              <td align=center><font style=font-size: 13pt; color=#0161AC face=Arial><strong><br>
                Tu cuenta es:</strong></font></td>
              </tr>
            <tr>
              <td align=center>
			  
			  
			   <table width=450 border=0   bgcolor=#0161AC cellpadding=3 cellspacing=0>
<tr >
  <td align=center ><font style=font-size: 15pt; color=#FFFFFF face=Arial ><strong>".$ROW_ED['id_cliente']."</strong></font></td></tr>
                </table>
			   <br />


              
              <table width=450 border=0   bgcolor=#0161AC cellpadding=3 cellspacing=0>
<tr >
  <td align=center bgcolor=#FFFFFF ><font style=font-size:10pt; color=#0161AC face=Arial><strong>Para efectuar tus compras, debes ingresar la informaci&oacute;n <br>
    de la siguiente forma:</strong></font></td>
</tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Name:&nbsp;".$_POST['nombre_usu']."&nbsp;".$_POST['apellidos_usu']."</strong></font></td>
</tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Address line 1:&nbsp;8256 N. W 30 TH TERRACE</strong></font></td></tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Address line 2:".$ROW_ED['id_cliente']."</strong> <br>
    <em>(!) siempre debes ingresar tu código</em></font></td>
</tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>City:&nbsp;MIAMI</strong></font></td></tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>State:FLORIDA</strong></font></td></tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Zipcode:33122-1914</strong></font></td>
</tr>
<tr >
  <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Phone:786-6158656</strong></font></td></tr>



<tr>
<td height=10>
</td> 
</tr>
                  

                </table>
                <br>
                <br>

                
              
              
              
              
              
              <table width=450 border=0  bordercolor=#CCCCCC cellpadding=3 cellspacing=0>

                  
               
                
              
           <tr>
  <td height=10>
  </td> 
</tr>
                  
                  
                  <tr>
                  <td align=center bgcolor=#FFFFFF> 
                 <font style=font-size:10pt; color=#0161AC face=Arial ><em><strong>IMPORTANTE:</strong><br />
NUNCA enviaremos un e-mail solicitando tus claves o datos personales y SIEMPRE nos dirigiremos a ti por tu nombre y apellido.<br />


Nunca reveles tus claves.<br />

Mantén tus datos actualizados.</em></font></td>
                  </tr>
                  

                </table></td>
              </tr>
            </table></td>
        </tr>
      </tbody>
   
      <tr>
      
                <td height=30 align=center valign=bottom><font style=font-size: 10pt; color=#0161AC face=Arial size=2 >www.tlccourier.cl - &copy; Todos los Derechos Reservados</font></td>
      </tr>
  &nbsp;&nbsp;&nbsp;
    </table></td>
  <td width=15 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
  &nbsp; </tr>
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
</table>";
	
	//$archivoad = $_FILES['archivo1'];
	$emilio=$_POST['email_usu']; 
	//$nombre_persona=$_POST['nombre_usu']." ".$_POST['apellidos_usu'];
	$nombre_persona= $_POST['nombre_usu']."".$_POST['apellidos_usu'];;
	include_once("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = $respondere;
	$mail->FromName = $autore;
	$mail->Subject = $asuntoe;
	$mail->isHTML(true);
	$mail->AddAddress($emilio, $nombre_persona);
	$body = $cuerpoe;
	$mail->Body = $body;
	$mail->Send();


//------------------------------------------------------------------------------------------------------------------


echo "<script languaje='javascript'>";
echo "top.frames.location.replace('ok_tlc_bf.php')";
echo "</script>";
?>
