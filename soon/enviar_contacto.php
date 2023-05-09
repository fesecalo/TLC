<?
		$contactemail="pimenton@pimenton.cl";
	$subject="TLC Courier";
	$texto_email.="/////////// INICIO DE MENSAJE ///////////\n\n";
		$texto_email.="FOLIO : ". $_POST['folio'] ."\n";
	$texto_email.="Fecha : ". $_POST['fecha'] ."\n\n";
	$texto_email.="Nombre : ". $_POST['nombre'] ."\n";
	$texto_email.="email: ". $_POST['email'] ."\n";
	$texto_email.="Fono: ". $_POST['telefono'] ."\n";
		$texto_email.="/////////// FIN DE MENSAJE ///////////\n\n";
	$myname = "www.tlccourier.cl";
	$headers .= "From: $myname<$myemail>\n";
	$headers .= "Reply-To: $myemail\n";
	$headers .= "X-Sender: <$myemail>\n";
	$headers .= "X-Mailer: PHP\n"; //mailer
	$headers .= "X-Priority: 3\n"; //1 UrgentMessage, 3 Normal
	$headers .= "Return-Path: <$myemail>\n";
	$headers .= "cc:pimenton@pimenton.cl\n"; 
	$headers .= "cc:claudio@pimenton.cl\n"; 

	$message = $texto_email; 
	//echo $message;
	//usleep(4000000);
	mail ($contactemail, $subject, $message, $headers);		

//------------------------------------------------------------------------------------------------------------------

echo "<script languaje='javascript'>";
echo "top.frames.location.replace('ok.php')";
echo "</script>";
?>
