<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'tlccouriercl_pwebgc00');
define('DB_PASS', '@·Pdbd2k01');
define('DB_NAME', 'tlccouriercl_manifiesto');
define('DB_PRE', 'mf');

define('NPAG',10);//Largo Paginacion
define('URL_SITIO', 'http://tlccourier.cl/@tuko/');

date_default_timezone_set('America/Santiago');
define('ST_TT', "&copy;TUKO" );//Largo Paginacion
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
define('EMP','TLC LTDA.');//Largo Paginacion

/*

    orientación es la forma de colocación de la página, es decir, debemos indicar si es normal o apaisada. El valor por defecto P es normal. El valor para apaisada es L
    unidad es la medida de usuario y sus posibles valores son: pt punto, mm milímetro, cm centímetro e in pulgada. El valor por defecto es el mm
    formato de la página. Puede tener los siguientes valores: A3, A4, A5, Letter y Legal. El valor por defecto es A4 
*/

define('ORIENTA', 'p');
define('IMP', 'Letter');
define('GXH',2);
?>