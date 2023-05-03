<?php
require_once("../inc/BD.php");
require_once("../inc/Valida.php");
require_once("../inc/Accion.php");
require_once("../inc/tpl.php");
require_once("../inc/Paginacion.php");

$pagina='dsh';
$tabla='cliente';
$titulo='DASHBOARD';

$login = new Valida();

Templeta::cab();
Templeta::nav($pagina);
?>
        <div id="page-wrapper">
            <div id="page-inner">
			<?php 
				include("modelo/Modelo.php");
				include("control/Control.php");
			?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
<?php Templeta::pie(); ?>