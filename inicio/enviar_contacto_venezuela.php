<?php
include("../lib/conf.php");

	$mensajeemail="Contacto desde TLC Courier Landing Venezuela";
	$respondere="logisticaglobal@tlccourier.cl";
	$asuntoe="www.tlccourier.cl";
	$autore="www.tlccourier.cl";
	$cuerpoe=$_POST['nombre'].", ha enviado un mensaje desde CONTACTO con los siguientes datos:<br><br>
	Nombre: ".$_POST['nombre']."<br>
	Fono: ".$_POST['fono']."<br>
	Email: ".$_POST['email']."<br>
	Mensaje: ".$_POST['mensaje']."<br>";
	$emilio="logisticaglobal@tlccourier.cl";
	$nombre_persona="'".$_POST['nombre']."'";
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
	$mail->AddAddress("logisticaglobal@tlccourier.cl","LOGISTICA GLOBAL");
	$body = $cuerpoe;
	$mail->Body = $body;
	$mail->Send();

//------------------------------------------------------------------------------------------------------------------

echo "<script languaje='javascript'>";
echo "top.frames.location.replace('ok_contacto_venezuela.php')";
echo "</script>";
?>
