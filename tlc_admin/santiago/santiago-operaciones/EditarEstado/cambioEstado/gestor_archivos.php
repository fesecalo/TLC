<?php

		$ruta_final=$_SERVER['DOCUMENT_ROOT']."/tlc_admin/santiago/santiago-operaciones/EditarEstado/cambioEstado/cambioEstado.csv";

		header ("Content-Disposition: attachment; filename=Manifiesto.csv");
		header ("Content-Type: application/force-download");
		header ("Content-Length: ".filesize($ruta_final));
		readfile($ruta_final);

?>