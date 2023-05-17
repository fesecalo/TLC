<?php

    require_once '/home/tlccouri/public_html/tlc_admin/archivos_prueba/composer-phpmailer/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
	function enviarCorreo($direccion_destinatario,$asunto,$contenido){
		//require_once '/home/tlccouri/public_html/tlc_admin/PHPMailer-master/PHPMailerAutoload.php';

		$mail = new PHPMailer;

        $mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
        $mail->isSMTP();
        $mail->Host = 'mail.tlccourier.cl';
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$mail->Username = 'info@tlccourier.cl';
        //$mail->Password = 'ncrcdmvybxkqgzmx';
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
		//require_once '/home/tlccouri/public_html/tlc_admin/PHPMailer-master/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
        $mail->isSMTP();
        $mail->Host = 'mail.tlccourier.cl';
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$mail->Username = 'info@tlccourier.cl';
        //$mail->Password = 'ncrcdmvybxkqgzmx';
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