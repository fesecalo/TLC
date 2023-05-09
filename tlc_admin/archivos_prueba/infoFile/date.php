<?php
	echo "zona horaria Server: ";
	echo "<br>";
	echo date_default_timezone_get().": ";
	echo date("d/m/Y H:i:s");

	// GMT -3
	echo "<br><br>";
	echo "America/Santiago: ";
	echo "<br>";
	date_default_timezone_set('America/Santiago');
	echo date_default_timezone_get().": ";
	echo date("d/m/Y H:i:s");

	// GMT -4
	// echo "<br><br>";
	// echo "La paz: ";
	// echo "<br>";
	// date_default_timezone_set('America/La_Paz');
	// echo date_default_timezone_get().": ";
	// echo date("d/m/Y H:i:s");

	// echo "<br><br>";
	// echo "Argentina: ";
	// echo "<br>";
	// date_default_timezone_set('America/Argentina/Buenos_Aires');
	// echo date_default_timezone_get().": ";
	// echo date("d/m/Y H:i:s");
	
?>