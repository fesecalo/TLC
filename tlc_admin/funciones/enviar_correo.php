<?php

     require_once '/home/tlccouri/public_html/tlc_admin/archivos_prueba/composer-phpmailer/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
	function enviarCorreo($direccion_destinatario,$asunto,$contenido){
		//require_once '/home/tlccouri/public_html/tlc_admin/PHPMailer-master/PHPMailerAutoload.php';

		/*$mail->IsSMTP();
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = true;
		$mail->Host = 'mail.tlccourier.cl';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';

		// CREDENCIALES DE 
		$mail->Username = "noreply@tlccourier.cl";
		$mail->Password = "TLCcourrier2021!"; */
		
	    /*$mail->IsSMTP();
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = true;
		$mail->Host = 'tlccourier.cl';
		$mail->Port = 465;
		$mail->SMTPSecure = 'tls';

		// CREDENCIALES DE 
		$mail->Username = "noreply@tlccourier.cl";
		$mail->Password = "TLCcourrier2021!";*/
		
        $mail = new PHPMailer;

        //$mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
        $mail->isSMTP();
        $mail->Host = 'tlccourier.cl';
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$mail->Username = 'info@tlccourier.cl';
        //$mail->Password = 'ncrcdmvybxkqgzmx';
        //$mail->Password = 'Cou12345';
        $mail->Username = 'noreply@tlccourier.cl';
        $mail->Password = '[d!x}E(mX1WF';
        
        
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

	function enviarCorreoAdjunto($direccion_destinatario,$asunto,$contenido,$ruta,$archivo){
		//require_once '/home/tlccourier/public_html/tlc_admin/PHPMailer-master/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();
        $mail->Host = 'tlccourier.cl';
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$mail->Username = 'info@tlccourier.cl';
        //$mail->Password = 'ncrcdmvybxkqgzmx';
        //$mail->Password = 'Cou12345';
        $mail->Username = 'noreply@tlccourier.cl';
        $mail->Password = '[d!x}E(mX1WF';

		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		//$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

		// Emisor
		$mail->From = "noreply@tlccourier.cl";
		$mail->FromName = "";

   		$mail->AddAttachment($ruta.$archivo);

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
?>
