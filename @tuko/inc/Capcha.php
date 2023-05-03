<?php
		//Elegimos el ancho y alto del captcha
		$ancho = 80;
		$alto = 40;
		
		//Colores
		$imagen = imagecreatetruecolor($ancho, $alto);
		$negro = imagecolorallocate($imagen,  100, 100, 100);
		$linea = imagecolorallocate($imagen, 190, 190, 190);
		$fondo = imagecolorallocate($imagen, 255, 255,255);
		$amarillo=imagecolorallocate($imagen, 241, 196, 15);
		$naranja=imagecolorallocate($imagen, 220, 118, 51);
		$verde=imagecolorallocate($imagen, 46, 204, 113);
		$azul=imagecolorallocate($imagen, 41, 128, 185);
		$rojo=imagecolorallocate($imagen, 231, 76, 60);
		
		//Fondo
		imagefill($imagen, 0, 0, $fondo);
		
		//Rejilla
		imageline($imagen, $ancho-2, 2, 2, $alto-2, $linea);
		
		// dibujar un pol�gono
		$valores = array(
					20,  35,  // Point 1 (x, y)
					10,  35, // Point 2 (x, y)
					38,  5,  // Point 3 (x, y)
					78, 38,  // Point 4 (x, y)
					38,  38,  // Point 5 (x, y)
					10,  10,  // Point 6 (x, y)        
					);
		imagefilledpolygon($imagen, $valores, 6, $linea);
		
		//A�adir ruido para que sea m�s ilegible
		for ($i = 0;$i <= 2000; $i++) {
		   $randx = rand(5,155);
		   $randy = rand(5,55);
		   imagesetpixel($imagen, $randx, $randy, $linea);
		   imagesetpixel($imagen, $randx, $randy, $fondo);

		}		
		
		//Marco
		$string=imagerectangle($imagen,1,1,$ancho-2,$alto-2,$linea);
			
		//Texto 
		$cadena=base64_decode($_GET['c']);

		//Fuente a utilizar
		
		$fuente =6;
		
		//Escribir verticalmente
		$x = ($ancho-(strlen($cadena)*imagefontwidth($fuente)))/2;
		$y = $alto/2.5;

		imagestring($imagen, $fuente, $x, $y, $cadena, $tt);
				
		//Salida
		header("Content-type: image/png");
		echo imagegif($imagen);
		imagedestroy($imagen);
?>