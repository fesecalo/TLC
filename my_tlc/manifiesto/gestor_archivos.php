<?php

		$ruta_final=$_SERVER['DOCUMENT_ROOT']."/my_tlc/manifiesto/Manifiesto.csv";

		header ("Content-Disposition: attachment; filename=Manifiesto.csv");
		header ("Content-Type: application/force-download");
		header ("Content-Length: ".filesize($ruta_final));
		readfile($ruta_final);

?>