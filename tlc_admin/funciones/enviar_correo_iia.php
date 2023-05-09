<?php
	function enviarCorreo($direccion_destinatario,$asunto,$contenido){
		require_once '/home/tlccourier/public_html/tlc_admin/PHPMailer-master/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		
		$mail->IsSMTP();
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = false;
	//	$mail->Host = 'mail.tlccourier.cl';
		$mail->Host = 'cp05.iia.cl';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';

		// CREDENCIALES DE 
		$mail->Username = "noreply@tlccourier.cl";
		$mail->Password = "TLCcourrier2021!";

		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		//$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

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


		if(!$mail->Send())
		    return $mail->ErrorInfo;
		else
		    return true;
	}


         $correoEmail='grupo.servidores@iia.cl';
         $mensaje="Mensaje de prueba........ ";

 	echo enviarCorreo($correoEmail,'Bienvenido a TLC Courier',$mensaje);
        echo "<BR>correo enviado";
?>
