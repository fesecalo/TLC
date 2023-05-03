<?php
include("../lib/conf.php");

	$mensajeemail="Mensaje desde COMPRAMOS POR TI";
	$respondere="atencionalcliente@tlccourier.cl";
	$asuntoe="www.tlccourier.cl";
	$autore="www.tlccourier.cl";
	$cuerpoe=$_POST['pnombre'].", ha enviado un mensaje desde la seccion COMPRAMOS POR TI, con los siguientes datos:<br><br>
	Nombre: ".$_POST['pnombre']."<br>
	Apellido: ".$_POST['papellido']."<br>
	Fono: ".$_POST['pfono']."<br>
	Email: ".$_POST['pemail']."<br><br>
	Detallle del Producto:<br>
	Link del Producto: ".$_POST['plink']."<br>
	Nombre Producto: ".$_POST['pnombreproducto']."<br>
	Cantidad Producto: ".$_POST['pcantidad']."<br>
	Descripcion Producto: ".$_POST['pdescripcion']."<br>";
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
