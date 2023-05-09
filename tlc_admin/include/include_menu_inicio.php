
<header class="clearfix">

    <div class="logo col-md-2">
        <h2 class="logo-text">
            <a href="index.php"><img src="<?= $conf['path_host_url'] ?>/img/<?= $conf['path_logo'] ?>"></a>
        </h2>
    </div>
    <nav class="clearfix">
    <!--Inicio Menu de navegacion -->
    <ul class="clearfix">
        <?php if(isset($_SESSION['id_usu'])){ ?>
        <li><a href="<?= $conf['path_host_url'] ?>/miami/inicio.php" class="active">Origen</a></li>
        <li><a href="<?= $conf['path_host_url'] ?>/santiago/santiago-operaciones/inicio.php" class="active">Destino</a></li>
        <li><a href="<?= $conf['path_host_url'] ?>/servicio_cliente/inicio.php" class="active">Servicio al cliente</a></li>
        <li><a href="<?= $conf['path_host_url'] ?>/santiago/santiago-operaciones/boletas/" class="active">Boletas (pruebas)</a></li>
        <li><a href="<?= $conf['path_host_url_my_btrace'] ?>/index.php" class="active">My <?= $conf['path_company_name']; ?></a></li>
        <!-- <li><a href="<?= $conf['path_host_url'] ?>/administracion/inicio.php" class="active">ADMINISTRADOR</a></li> -->
        <li><a href="<?= $conf['path_host_url'] ?>/cerrar_sesion.php" class="active">Cerrar Sesi&oacute;n</a></li>
        <?php }else{ ?>
            <?php header("location: ".$conf['path_host_url']."/cerrar_sesion.php"); ?>
        <?php } ?>
    </ul>
    <!-- Fin menu de navegacion -->
</nav>
<div class="pullcontainer">
<a href="#" id="pull"><i class="fa fa-bars fa-2x"></i></a>
</div>     
</header>
 <hr size="1" color="#FF0000" />
        