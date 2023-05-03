<?php
include("../lib/conf.php");

	$mensajeemail="Mensaje desde ENVÍOS INTERNACIONALES - DOCUEMNTO";
	$respondere="atencionalcliente@tlccourier.cl";
	$asuntoe="www.tlccourier.cl";
	$autore="www.tlccourier.cl";
	$cuerpoe=$_POST['enombredoc'].", ha enviado un mensaje desde la seccion  ENVÍOS INTERNACIONALES - DOCUEMNTO, con los siguientes datos:<br><br>
	Nombre: ".$_POST['enombredoc']."<br> 
	Apellido: ".$_POST['eapellidodoc']."<br>
	Fono: ".$_POST['efonodoc']."<br>
	Email: ".$_POST['eemaildoc']."<br><br>
	Detalle del Documento:<br>
	Desde: ".$_POST['edesdedoc']."<br>
	Hacia: ".$_POST['ehaciadoc']."<br>
	Peso: ".$_POST['epesodoc']."kg.<br>";

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
