<?php
  require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
  require $conf['path_host'].'/EasyPDO/conexionPDO.php';

  // funcion fecha actual tiene que ir despues de la conexion PDO
  require $conf['path_host'].'/funciones/fecha_actual.php';

  $url=$_GET['accion'];
  $url2=$_GET['accion2'];
  $url3=$_GET['accion3'];

  $db->prepare("INSERT INTO log SET 
    accion=:accion,
    detalle=:detalle,
    detalle2=:detalle2,
    ip=:ip,
    fecha=:fecha
  ");

  $db->execute(array(
    ':accion' => 'csrf',
    ':detalle' => $url,
    ':detalle2' => $url2,
    ':ip' => $url3,
    ':fecha' => $fecha_actual
  )); 
?>
<!DOCTYPE html>
<html lang="en">

  <!-- head -->
  <?php require $conf['path_host'].'/include/include_head.php'; ?>   
  <!-- fin head-->
  
  <!-- java scripts -->
  <?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
  <!-- fin java scripts-->
  
  <body>

    <!-- fin mensaje -->
     <div id="ms-preload" class="ms-preload">
      <div id="status">
        <div class="spinner">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
      </div>
    </div>
    <!-- mensaje -->
    <div class="bg-full-page bg-primary back-fixed">
      <div class="mw-500 absolute-center">
        <div class="card animated zoomInUp animation-delay-7 color-primary withripple">
          <div class="card-block">
            <div class="text-center color-dark">
              <h1 class="color-primary text-big">ERROR</h1>
              <h2>Ocurrió un problema. Vuelva a intentarlo.</h2>
              <a href="<?php echo $conf['path_host_url'] ?>/index.php" class="btn btn-primary btn-raised">
                <i class="zmdi zmdi-home"></i>Volver</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- fin mensaje -->

  </body>
</html>