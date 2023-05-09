<?php

	include_once 'db.php';

	class Tracking extends DB{
	    function obtenerTracking($id){

	        $query = $this->connect()->prepare('SELECT 
					estado.nombre_status,
					lugar.nombre_lugar,
				    historial.fecha
				    
				FROM paquete AS paquete
				INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
				INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
				INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
				WHERE paquete.tracking_eu=:id
				ORDER BY historial.id_status_log DESC
			');

	        $query->execute([':id' => $id]);
	        return $query;
	    }
	}

?>