<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*$conf['db_hostname'] = "localhost";
$conf['db_name'] = "tlccourier_bd";
$conf['db_username'] = "tlccourier_user";
$conf['db_password'] = "TLCCourrier001!";*/

$conf['db_hostname'] = 'localhost';
$conf['db_name'] = 'tlccouri_sistema_db';
$conf['db_username'] = 'tlccouri_tlccourier_user';
$conf['db_password'] = 'Kl%y*aui7dRreCUr@23u#44$o';

$enlace = mysqli_connect($conf['db_hostname'] , $conf['db_username'], $conf['db_password'], $conf['db_name']);

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL;

mysqli_close($enlace);