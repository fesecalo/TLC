<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
require $conf['path_host'].'/EasyPDO/conexionPDO.php';
require $conf['path_host'].'/include/include_sesion.php';

//$barcode=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
$id_consolidado=$_POST['id_consolidado'];
$peso_consolidado=0;


if($id_consolidado=='nuevoConsolidado'){ // Crear nuevo consolidado

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];


	// se crea el numero de tracking de garve shop
	$sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=1");

	foreach ($sql_parametro as $key => $parametro) { 
		$prefijo=$parametro->prefijo_consolidado;
		$incremento=$parametro->incremento_consolidado;
	}

	$incremento=$incremento+1;

	$numero_seguimiento=$prefijo.$incremento;

	// Actualiza el valor de incremento de la tabla parametro
	$db->prepare("UPDATE parametro SET incremento_consolidado=:incremento WHERE id_parametro=1");
	$db->execute(array(':incremento' => $incremento));
	// Fin actualizar tabla parametros

	$db->prepare("INSERT INTO consolidado SET codigo_consolidado=:codigo_consolidado, fecha=:fecha_registro, id_usuario=:usuario");
	$db->execute(array(':codigo_consolidado'=>$numero_seguimiento,':fecha_registro'=>$fecha_actual, ':usuario'=>$id_usu));

    $db->prepare("SELECT id_consolidado FROM consolidado WHERE codigo_consolidado=:codigo_consolidado limit 1");
	$db->execute(array(':codigo_consolidado' => $numero_seguimiento));
	$id_consolidado=$db->get_results();
	$id_consolidado=$id_consolidado[0]->id_consolidado;
	
    // FIN CREAR NUEVO CONSOLIDADO
    $i=0;
    foreach ($_POST['array_tracking_garve'] as $barcode){
    //echo json_encode(array('respuesta'=>$i));     
        
        $db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete LIMIT 1");
	    
    	$db->execute(array(':codigo' => $barcode));
    	$sql_paquete=$db->get_results();
    	
    	foreach ($sql_paquete as $key => $paquete) {
    		$id_paquete=$paquete->id_paquete;
    		$id_consolidado_old=$paquete->id_consolidado;
    	}
    
    	if (empty($sql_paquete)) {
    	    echo json_encode(array('respuesta'=>"No hay paquetes"));die();
    		// "No hay paquetes disponibles con el codigo ingresado";
    		//header("location: trabajar_consolidado.php?id_cons=$id_consolidado&msg=1");
    		die;
    	}else{
    	    
    		$db->prepare("UPDATE paquete SET id_consolidado=:id_consolidado WHERE id_paquete=:id");
    		$db->execute(array(':id_consolidado' => $id_consolidado, ':id' => $id_paquete));
    
    		$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
    		$db->execute(array(':id_consolidado' => $id_consolidado));
    		$sql_paquete_consolidado=$db->get_results();
    
    		$numero_paquetes=count($sql_paquete_consolidado);
    		
    		foreach ($sql_paquete_consolidado as $key => $paquete) {
    		    
    		    $peso_consolidado=$peso_consolidado+$paquete->peso;
    		}
    		//var_dump($peso_consolidado);die();

    		$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
    		$db->execute(array(':kilos' => $peso_consolidado, ':numero' =>$numero_paquetes, ':id' => $id_consolidado));
    
    		// si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
    		
    		//var_dump($id_consolidado_old);
    		//var_dump($id_consolidado);
    		//var_dump($id_consolidado_old!=$id_consolidado);die();
    		
    		
    		/*if ($id_consolidado_old!=$id_consolidado) {
    			$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
    			$db->execute(array(':id_consolidado' => $id_consolidado_old));
    			$sql_paquete_consolidado_old=$db->get_results();
    
    			$numero_paquetes_old=count($sql_paquete_consolidado_old);
                $peso_consolidado_old=0;
    			foreach ($sql_paquete_consolidado_old as $key => $paquete) {
    				$peso_consolidado_old=$peso_consolidado_old+$paquete->peso;
    			}
    
    			$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
    			$db->execute(array(':kilos' => $peso_consolidado_old, ':numero' =>$numero_paquetes_old, ':id' => $id_consolidado_old));
    		}*/
    		// fin si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
    
    		//header("location: trabajar_consolidado.php?id_cons=$id_consolidado");
	    }
	    $i++;
	}
    echo json_encode(array('respuesta'=>true));die();

    //echo json_encode(array('consolidado'=>$sql_consolidado));
}else{
    
    foreach ($_POST['array_tracking_garve'] as $barcode){
        $db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete LIMIT 1");
	    
    	$db->execute(array(':codigo' => $barcode));
    	$sql_paquete=$db->get_results();
    
    	foreach ($sql_paquete as $key => $paquete) {
    		$id_paquete=$paquete->id_paquete;
    		$id_consolidado_old=$paquete->id_consolidado;
    	}
    	
    	if (empty($sql_paquete)) {
    		// "No hay paquetes disponibles con el codigo ingresado";
    		//header("location: trabajar_consolidado.php?id_cons=$id_consolidado&msg=1");
    		die;
    	}else{
    		$db->prepare("UPDATE paquete SET id_consolidado=:id_consolidado WHERE id_paquete=:id");
    		$db->execute(array(':id_consolidado' => $id_consolidado, ':id' => $id_paquete));
    
            
    
    		$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
    		$db->execute(array(':id_consolidado' => $id_consolidado));
    		$sql_paquete_consolidado=$db->get_results();
    		
    		
    
    		$numero_paquetes=count($sql_paquete_consolidado);
    
    		foreach ($sql_paquete_consolidado as $key => $paquete) {
    			$peso_consolidado=$peso_consolidado+$paquete->peso;
    		}
    
    		$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
    		$db->execute(array(':kilos' => $peso_consolidado, ':numero' =>$numero_paquetes, ':id' => $id_consolidado));
    
    		// si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
    		if ($id_consolidado_old!=$id_consolidado) {
    			$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
    			$db->execute(array(':id_consolidado' => $id_consolidado_old));
    			$sql_paquete_consolidado_old=$db->get_results();
    
    			$numero_paquetes_old=count($sql_paquete_consolidado_old);
                $peso_consolidado_old=0;
    			foreach ($sql_paquete_consolidado_old as $key => $paquete) {
    				$peso_consolidado_old=$peso_consolidado_old+$paquete->peso;
    			}
    
    			$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
    			$db->execute(array(':kilos' => $peso_consolidado_old, ':numero' =>$numero_paquetes_old, ':id' => $id_consolidado_old));
    		}
    		// fin si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
    
    		//header("location: trabajar_consolidado.php?id_cons=$id_consolidado");
	    }
	}
    echo json_encode(array('respuesta'=>true));die();
}
	
	
?>