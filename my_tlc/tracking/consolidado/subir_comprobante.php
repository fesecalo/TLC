<?php
require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
require $conf['path_host'].'/EasyPDO/conexionPDO.php';
require $conf['path_host'].'/include/include_sesion.php';

// funcion fecha actual tiene que ir despues de la conexion PDO
require $conf['path_host'].'/funciones/fecha_actual.php';

$id_usu=$_SESSION['numero_cliente'];
$id_consolidado=$_POST['id_consolidado'];

$db->prepare("SELECT codigo_consolidado	FROM consolidado WHERE id_consolidado=:id
",true);
$db->execute(array(':id' => $id_consolidado));

$resultado_consolidado=$db->get_results();
$numero_seguimiento=$resultado_consolidado[0]->codigo_consolidado;


if( !isset($_POST['id_consolidado']) ){
	die("Ocurrio un problema con los comprobantes ingresados");
}else{
    $id_consolidado=$_POST['id_consolidado'];
}

if( !isset($_POST['valorFactura']) ){
	die("Ocurrio un problema con los comprobantes ingresados");
}else{
    $valorFactura=$_POST['valorFactura'];
}

if( !isset($_FILES['comprobante']) ){
	die("Ocurrio un problema con los comprobantes ingresados");
}else{
	
	$valorFactura=$_POST['valorFactura'.$i];

	$nombre = $_FILES['comprobante'.$i]['name'];
	$nombre_tmp = $_FILES['comprobante'.$i]['tmp_name'];
	$tipo = $_FILES['comprobante'.$i]['type'];
	$tamano = $_FILES['comprobante'.$i]['size'];

	$partes_nombre = explode('.', $nombre);
	$extension = end( $partes_nombre );

	$limite = 10*1024*1024;//10 mb

	if(($tamano <= $limite) AND 
		($extension=="png" || 
		 $extension=="PNG" || 
		 $extension=="pdf" || 
		 $extension=="PDF" || 
		 $extension=="jpg" || 
		 $extension=="JPG" || 
		 $extension=="xlsx" || 
		 $extension=="XLSX" || 
		 $extension=="xls" || 
		 $extension=="XLS" || 
		 $extension=="docx" || 
		 $extension=="DOCX" || 
		 $extension=="doc" || 
		 $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
		
		// crea la carpeta con el id del cliente
		if(!file_exists( $conf['path_files_consolidado'].$id_usu."/".$id_consolidado) ){
			mkdir($conf['path_files_consolidado'].$id_usu."/".$id_consolidado, 0777, true);
		}
		// fin crear carpeta

		// procesa el nombre y el tipo de archivo
		if (strtoupper($extension)=="PDF" ) {
			$ext=1;
		}elseif (strtoupper($extension)=="JPG" ) {
			$ext=2;
		}elseif (strtoupper($extension)=="XLSX" ) {
			$ext=3;
		}elseif (strtoupper($extension)=="XLS" ) {
			$ext=4;
		}elseif (strtoupper($extension)=="DOCS" ) {
			$ext=5;
		}elseif (strtoupper($extension)=="DOC" ) {
			$ext=6;
		}elseif (strtoupper($extension)=="PNG" ) {
			$ext=7;
		}else {
			$ext=8;
		}
		$nombre_nuevo=$numero_seguimiento.'-'.date('m-d-y-g-i-s').'.'.strtoupper($extension);
		// fin procesa nombre y tipo de archivo

		// mueve el archivo a la carpeta
		move_uploaded_file($nombre_tmp,$conf['path_files_consolidado'].$id_usu."/".$id_consolidado."/".$nombre_nuevo);
		// fin mover archivos

		// ingreso de registros en la tabla comprobante_consolidado
		$db->prepare("INSERT comprobante_consolidado  
		    (
    		    id_consolidado, 
    		    id_usuario, 
    		    nombre_comprobante, 
    		    extension, 
    		    nombre_original, 
    		    valor_factura 
		    ) VALUES (
    			:id_consolidado,
    			:usuario,
    			:comprobante,
    			:extension,
    			:nombre_original,
    			:valor_factura
			)
		",true);
		$db->execute(array(
			':id_consolidado' => $id_consolidado,
			':usuario' => $id_usu,
			':comprobante' => $nombre_nuevo,
			':extension' => $ext,
			':nombre_original' => $nombre,
			':valor_factura' => $valorFactura
		));
		// fin registro tabla comprobante_consolidado
		
	}else{
		die("El archivo ingresado no es un PDF o supera los 10 mb");
	}
	
}
header("location: detalles_consolidado.php?id_consolidado=$id_consolidado&result=1");
?>