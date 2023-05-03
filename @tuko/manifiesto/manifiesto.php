<?php
require_once("../inc/BD.php");
require_once("../inc/Valida.php");
require_once("../inc/Accion.php");
require_once("../inc/tpl.php");
require_once("../inc/Paginacion.php");

$pagina='manifiesto';
$tabla='manifiesto';
$titulo='Manifiesto';

$login = new Valida();

include("modelo/Modelo.php");
include("control/Control.php");
?>