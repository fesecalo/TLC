<header class="clearfix">
    
    
    <!--<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            
            <div class="navbar-header" style="display:table !important; cursor:pointer !important;">
                <a href="<?= $conf['path_host_url_btrace_admin']; ?>/index.php" class="navbar-brand" style="display:table !important; cursor:pointer !important;">
                    <img width="100" height="85" style="width:70px;" src="<?= $conf['path_host_url'] ?>/img/<?= $conf['path_logo'] ?>" >
                </a>
            </div>
            
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">

                <?php if(isset($_SESSION['numero_cliente'])){ ?>
                <li><a href="<?= $conf['path_host_url'] ?>/tracking/tracking.php" >Sigue tu envio</a></li>
                <li><a href="<?= $conf['path_host_url'] ?>/manifiesto/inicio.php" >Manifiesto</a></li>
                <li><a href="<?= $conf['path_host_url'] ?>/tracking/historial_paquetes.php" >Historial</a></li>
                <?php }else{ ?>
                <li><a href="<?= $conf['path_host_url'] ?>/index.php" >Inicio</a></li>
                <li><a href="<?= $conf['path_host_url'] ?>/usuario_registro/registro_usuario.php" >Registrate</a></li>
                <?php } ?>
                
                
              </ul>
              <ul class="nav navbar-nav navbar-right">

                  
                <?php if(isset($_SESSION['numero_cliente'])){ ?>
                <li><a href="<?= $conf['path_host_url'] ?>/mi_cuenta/mi_cuenta.php">Mi Cuenta</a></li>
                <li><a href="<?= $conf['path_host_url'] ?>/cerrar_sesion.php" >Cerrar Sesi&oacute;n</a></li>
                <li>
                    <a href='#'> <?= 'Cliente TLC-'.str_pad($_SESSION['numero_cliente'], 5, '0', STR_PAD_LEFT) ?> </a>
                </li>
                
                
                <?php } ?>

              </ul>
            </div>
        </div>
    </nav>
    
    <br>
    <br>
    <br>
    <br>-->
    

    <div class="logo col-md-2">
        <h2 class="logo-text">
            <a href="<?= $conf['path_host_url_btrace_admin']; ?>/index.php">
                <img width="143" height="79" style="width:150px;" src="<?= $conf['path_host_url'] ?>/img/<?= $conf['path_logo'] ?>" >
            </a>
        </h2>
    </div>

    <nav class="clearfix">
        
        <ul class="clearfix">
            <?php if(isset($_SESSION['numero_cliente'])){ ?>
            <li><a href="<?= $conf['path_host_url'] ?>/tracking/tracking.php" class="active">Sigue tu envio</a></li>
            <li><a href="<?= $conf['path_host_url'] ?>/manifiesto/inicio.php" class="active">Manifiesto</a></li>
            <li><a href="<?= $conf['path_host_url'] ?>/tracking/historial_paquetes.php" class="active">Historial</a></li>
            <li><a href="<?= $conf['path_host_url'] ?>/mi_cuenta/mi_cuenta.php" class="active">Mi Cuenta</a></li>
            <li><a href="<?= $conf['path_host_url'] ?>/cerrar_sesion.php" class="active">Cerrar Sesi&oacute;n</a></li>
            <?php }else{ ?>
            <li><a href="<?= $conf['path_host_url'] ?>/index.php" class="active">Inicio</a></li>
            <li><a href="<?= $conf['path_host_url'] ?>/usuario_registro/registro_usuario.php" class="active">Registrate</a></li>
            <?php } ?>
        </ul>
        
    </nav>
    
    <nav class="clearfix pull-right">
        <?php if(isset($_SESSION['numero_cliente'])){ ?>
        <ul class="clearfix" style="">
            <li><a style="padding: 0px;padding-top:18px; padding-right:20px; padding-left:160px;" href="#" class="active"></a><?= 'Casilla: TLC-'.str_pad($_SESSION['numero_cliente'], 5, '0', STR_PAD_LEFT) ?></a></li>
        </ul>
        <?php } ?>
    </nav>
   
</header>

 <hr size="1" color="#FF0000" />