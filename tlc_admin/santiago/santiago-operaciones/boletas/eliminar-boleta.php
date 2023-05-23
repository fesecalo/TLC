<?php

require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
require $conf['path_host'].'/EasyPDO/conexionPDO.php';
require $conf['path_host'].'/include/include_sesion.php';

$id_paquete_consolidado=$_GET["idBoleta"];

if($id_paquete_consolidado==""){
    echo "<h1>No existe la boleta a eliminar</h1>";
    die();
}

if($_SESSION["tipo_usuario"]!=1){
    echo json_encode(array('resultado'=>"No tienes los permisos suficientes para eliminar boletas"));
    die();
}

$db->prepare(
    "DELETE FROM `boletas_paquete_consolidado` 
    WHERE (`id` = :id_paquete_consolidado); 
    ",true);
$db->execute(array(':id_paquete_consolidado' => $id_paquete_consolidado));
$resultadoOperacion=$db->get_results();

if(empty($resultadoOperacion)){
    $resultado=array('resultado'=>true);
}else{
    $resultado=array('resultado'=>true);
}

echo json_encode($resultado);
die();