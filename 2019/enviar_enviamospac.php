<?php
include("../lib/conf.php");

	$mensajeemail="Mensaje desde ENVÍOS INTERNACIONALES - PAQUETE";
	$respondere="atencionalcliente@tlccourier.cl";
	$asuntoe="www.tlccourier.cl";
	$autore="www.tlccourier.cl";
	$cuerpoe=$_POST['enombrepac'].", ha enviado un mensaje desde la seccion  ENVÍOS INTERNACIONALES - PAQUETE, con los siguientes datos:<br><br>
	Nombre: ".$_POST['enombrepac']." <br>
	Apellido: ".$_POST['eapellidopac']."<br>
	Fono: ".$_POST['efonopac']."<br>
	Email: ".$_POST['eemailpac']."<br><br>
	Datos del Paquete:<br>
	Desde: ".$_POST['edesdepac']."<br>
	Hacia: ".$_POST['ehaciapac']."<br>
	Largo: ".$_POST['elargopac']."cms.<br>
	Ancho: ".$_POST['eanchopac']."cms.<br>
	Alto: ".$_POST['ealtopac']."cms.<br>
	Peso: ".$_POST['epesopac']."kg.<br>";


$emilio="info@tlccourier.cl"; 
	$nombre_persona="'".$_POST['nombre']."'";
	include_once("class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = $respondere;
	$mail->FromName = $autore;
	$mail->Subject = $asuntoe;
	$mail->isHTML(true);
	$mail->AddAddress($emilio, $nombre_persona);
	$mail->AddAddress("claudio@pimenton.cl","TEST");
	$mail->AddAddress("info@tlccourier.cl","INFO");
	$mail->AddAddress("comunicaciones@tlccourier.cl","COM");
	$mail->AddAddress("ruben@tlccourier.cl","GERENCIA");
	$mail->AddAddress("atencionalcliente@tlccourier.cl","ATENCION CLIENTES");
	$body = $cuerpoe;
	$mail->Body = $body;
	$mail->Send();

//------------------------------------------------------------------------------------------------------------------

echo "<script languaje='javascript'>";
echo "top.frames.location.replace('ok_cotizacion.php')";
echo "</script>";
?>
