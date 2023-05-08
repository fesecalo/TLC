<header class="clearfix">
    <div class="col-md-2">
        <h2 class="logo-text">
            <a href="<?= $conf['path_host_url'] ?>/index.php">
                <img width="143" height="79" style="width:150px;" src="<?= $conf['path_host_url'] ?>/img/<?= $conf['path_logo'] ?>" >
            </a>
        </h2>
    </div>

    <nav class="clearfix">
        <!--Inicio Menu de navegacion -->
        <ul class="clearfix">
            <?php if(isset($_SESSION['numero_cliente'])){ ?>
            <li><a href="<?php echo $conf['path_host_url'] ?>/tracking/tracking.php" class="active">Sigue tu envio</a></li>
            <?php if($_SESSION['tipo_cliente']==2){ ?>
                <li><a href="<?php echo $conf['path_host_url'] ?>/manifiesto/inicio.php" class="active">Manifiesto</a></li>
            <?php } ?>
            <li><a href="<?php echo $conf['path_host_url'] ?>/tracking/historial_paquetes.php" class="active">Historial</a></li>
            <li><a href="<?php echo $conf['path_host_url'] ?>/mi_cuenta/mi_cuenta.php" class="active">Mi Cuenta</a></li>
            <li><a href="<?php echo $conf['path_host_url'] ?>/cerrar_sesion.php" class="active">Cerrar Sesi&oacute;n</a></li>
            <?php }else{ ?>
            <li><a href="<?php echo $conf['path_host_url'] ?>/index.php" class="active">Inicio</a></li>
            <li><a href="<?php echo $conf['path_host_url'] ?>/usuario_registro/registro_usuario.php" class="active">Registrate</a></li>
            <?php } ?>
        </ul>
        <!-- Fin menu de navegacion -->
    </nav>

    <nav class="clearfix pull-right">
        <?php if(isset($_SESSION['numero_cliente'])){ ?>
        <ul class="clearfix" style="">
            <li><a style="padding: 0px;padding-top:18px; padding-right:20px; padding-left:160px;" href="#" class="active"></a><?= 'Casilla: TLC-'.str_pad($_SESSION['numero_cliente'], 5, '0', STR_PAD_LEFT) ?></a></li>
        </ul>
        <?php } ?>
    </nav>

    <!--<div class="pullcontainer">
        <a href="#" id="pull"><i class="fa fa-bars fa-2x"></i></a>
    </div>     -->
</header>

 <hr size="1" color="#FF0000" />